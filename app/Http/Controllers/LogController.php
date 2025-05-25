<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
    // Display paginated logs from Firebase
    public function index(FirebaseService $firebase, Request $request)
    {
        $logs = collect($firebase->getLogs() ?? [])->map(function ($log, $key) {
            return [
                'id' => $key,
                'animal_name' => $log['animal_name'] ?? 'Unknown',
                'camera' => $log['camera'] ?? 'Unknown',
                'confidence' => $log['confidence'] ?? 'N/A',
                'classification' => $log['classification'] ?? 'N/A',
                'created_at' => $log['timestamp'] ?? now(),
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
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $logs->forPage($page, $perPage),
            $logs->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.logs.index', ['logs' => $paginated]);
    }

    // Used to load just the table for AJAX refresh (real-time updates)
    public function table(FirebaseService $firebase)
    {
        $logs = $firebase->getLogs(); // Fetch all logs from Firebase

        // Transform logs for easy display and sorting
        $collection = collect($logs ?? [])->map(function ($log, $key) {
            return [
                'id' => $key,
                'animal_name' => $log['animal_name'] ?? 'Unknown',
                'camera' => $log['camera'] ?? 'Unknown',
                'confidence' => $log['confidence'] ?? 'N/A',
                'classification' => $log['classification'] ?? 'N/A',
                'created_at' => $log['created_at'] ?? now(),
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
    }


    public function pieCharts(FirebaseService $firebase)
    {
        $logs = $firebase->getLogs();

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
    }

    public function export(FirebaseService $firebase, Request $request)
    {
        $type = $request->input('type', 'csv');
        $logs = collect($firebase->getLogs() ?? [])->map(function ($log, $key) {
            return [
                'id' => $key,
                'animal_name' => $log['animal_name'] ?? 'Unknown',
                'camera' => $log['camera'] ?? 'Unknown',
                'confidence' => $log['confidence'] ?? 'N/A',
                'classification' => $log['classification'] ?? 'N/A',
                'created_at' => $log['timestamp'] ?? now(),
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
            $pdf = Pdf::loadView('admin.logs.export_pdf', ['logs' => $logs]);
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
    }
}
