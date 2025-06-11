<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class LogController extends Controller
{
    private $database;

    public function __construct()
    {
        try {
            $credentialsPath = base_path('zoomisapi-firebase.json');
            
            if (!file_exists($credentialsPath)) {
                throw new \Exception('Firebase credentials file not found at: ' . $credentialsPath);
            }

            $factory = (new Factory)
                ->withServiceAccount($credentialsPath)
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL', 'https://zoomisapi-default-rtdb.firebaseio.com/'));

            $this->database = $factory->createDatabase();
            
        } catch (\Exception $e) {
            Log::error('Firebase initialization failed in LogController: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getLogs()
    {
        try {
            // Updated to use 'zoo_logs' instead of 'logs'
            $reference = $this->database->getReference('zoo_logs');
            $data = $reference->getValue();
            
            Log::info('Firebase getLogs called, data retrieved: ' . (is_array($data) ? count($data) : 'null'));
            
            return $data ?? [];
        } catch (\Exception $e) {
            Log::error('Firebase getLogs error: ' . $e->getMessage());
            throw $e;
        }
    }

    // Display paginated logs from Firebase
    public function index(Request $request)
    {
        try {
            Log::info('LogController index method called');
            
            $logs = collect($this->getLogs())->map(function ($log, $key) {
                return [
                    'id' => $key,
                    'animal_name' => $log['animal_name'] ?? 'Unknown',
                    'camera' => $log['camera'] ?? 'Unknown',
                    'confidence' => $log['confidence'] ?? 'N/A',
                    'classification' => $log['classification'] ?? 'N/A',
                    'created_at' => $log['created_at'] ?? $log['timestamp'] ?? now(),
                ];
            });

            // Filter by date range using Carbon for date-only comparison
            if ($request->filled('from')) {
                $from = $request->from;
                $logs = $logs->filter(function ($log) use ($from) {
                    return Carbon::parse($log['created_at'])->format('Y-m-d') >= $from;
                });
            }
            if ($request->filled('to')) {
                $to = $request->to;
                $logs = $logs->filter(function ($log) use ($to) {
                    return Carbon::parse($log['created_at'])->format('Y-m-d') <= $to;
                });
            }

            // Sort and paginate
            $logs = $logs->sortByDesc('created_at')->values();
            $perPage = 20;
            $page = $request->get('page', 1);
            $paginated = new LengthAwarePaginator(
                $logs->forPage($page, $perPage),
                $logs->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('logs.index', ['logs' => $paginated]);
            
        } catch (\Exception $e) {
            Log::error('LogController index error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Unable to load logs: ' . $e->getMessage());
        }
    }

    // Used to load just the table for AJAX refresh (real-time updates)
    public function table()
    {
        try {
            $logs = $this->getLogs(); // Fetch all logs from Firebase

            // Transform logs for easy display and sorting
            $collection = collect($logs ?? [])->map(function ($log, $key) {
                return [
                    'id' => $key,
                    'animal_name' => $log['animal_name'] ?? 'Unknown',
                    'camera' => $log['camera'] ?? 'Unknown',
                    'confidence' => $log['confidence'] ?? 'N/A',
                    'classification' => $log['classification'] ?? 'N/A',
                    'created_at' => $log['created_at'] ?? $log['timestamp'] ?? now(),
                ];
            })->sortByDesc('created_at')->values();

            // Set up pagination (12 logs per page)
            $perPage = 12;
            $page = request()->get('page', 1);

            $paginatedLogs = new LengthAwarePaginator(
                $collection->forPage($page, $perPage),
                $collection->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('logs.partials.table', ['logs' => $paginatedLogs]);
            
        } catch (\Exception $e) {
            Log::error('LogController table error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to load logs table'], 500);
        }
    }

    public function pieCharts()
    {
        try {
            $logs = $this->getLogs();

            $normal = ['eating', 'resting', 'walking'];
            $warning = ['visitor close', 'user interacting with animal'];
            $hazard = ['aggressive', 'attacking', 'cage scratching', 'restricted zone', 'animal escape attempt'];

            $categories = [
                'normal' => [],
                'warning' => [],
                'hazard' => [],
            ];

            foreach ($logs ?? [] as $log) {
                $classification = strtolower($log['classification'] ?? 'unlabeled');

                if (in_array($classification, $normal)) {
                    $categories['normal'][$classification] = ($categories['normal'][$classification] ?? 0) + 1;
                } elseif (in_array($classification, $warning)) {
                    $categories['warning'][$classification] = ($categories['warning'][$classification] ?? 0) + 1;
                } elseif (in_array($classification, $hazard)) {
                    $categories['hazard'][$classification] = ($categories['hazard'][$classification] ?? 0) + 1;
                }
            }

            return response()->json([
                'normal' => $categories['normal'],
                'warning' => $categories['warning'],
                'hazard' => $categories['hazard'],
                'summary' => [
                    'Normal' => array_sum($categories['normal']),
                    'Warning' => array_sum($categories['warning']),
                    'Hazard' => array_sum($categories['hazard']),
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('LogController pieCharts error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to load chart data'], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            $type = $request->input('type', 'csv');
            $logs = collect($this->getLogs())->map(function ($log, $key) {
                return [
                    'id' => $key,
                    'animal_name' => $log['animal_name'] ?? 'Unknown',
                    'camera' => $log['camera'] ?? 'Unknown',
                    'confidence' => $log['confidence'] ?? 'N/A',
                    'classification' => $log['classification'] ?? 'N/A',
                    'created_at' => $log['created_at'] ?? $log['timestamp'] ?? now(),
                ];
            });

            // Filter by date range using Carbon for date-only comparison
            if ($request->filled('from')) {
                $from = $request->from;
                $logs = $logs->filter(function ($log) use ($from) {
                    return Carbon::parse($log['created_at'])->format('Y-m-d') >= $from;
                });
            }
            if ($request->filled('to')) {
                $to = $request->to;
                $logs = $logs->filter(function ($log) use ($to) {
                    return Carbon::parse($log['created_at'])->format('Y-m-d') <= $to;
                });
            }

            $logs = $logs->sortByDesc('created_at')->values();

            if ($type === 'pdf') {
                $pdf = Pdf::loadView('logs.export_pdf', ['logs' => $logs]);
                return $pdf->download('logs.pdf');
            } else {
                $filename = 'logs.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"$filename\"",
                ];

                $callback = function () use ($logs) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['ID', 'Animal Name', 'Camera', 'Confidence', 'Classification', 'Created At']);
                    foreach ($logs as $log) {
                        fputcsv($handle, [
                            $log['id'],
                            $log['animal_name'],
                            $log['camera'],
                            $log['confidence'],
                            $log['classification'],
                            $log['created_at'],
                        ]);
                    }
                    fclose($handle);
                };

                return response()->stream($callback, 200, $headers);
            }
            
        } catch (\Exception $e) {
            Log::error('LogController export error: ' . $e->getMessage());
            return back()->with('error', 'Unable to export logs: ' . $e->getMessage());
        }
    }
}
