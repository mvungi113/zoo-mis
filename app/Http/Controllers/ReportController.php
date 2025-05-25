<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('zoomisapi-firebase.json'))
            ->withDatabaseUri('https://zoomisapi-default-rtdb.firebaseio.com/'); // <-- Set correct URI

        $database = $factory->createDatabase();

        // Fetch all logs from Firebase
        $logs = $database->getReference('zoo_logs')->getValue();

        // Convert logs to a collection for easier handling
        $reports = collect($logs)->map(function ($item, $key) {
            return (object)[
                'id' => $key,
                'animal_name' => $item['animal_name'] ?? '',
                'camera' => $item['camera'] ?? '',
                'classification' => $item['classification'] ?? '',
                'confidence' => $item['confidence'] ?? '',
                'created_at' => $item['created_at'] ?? '',
            ];
        });

        // Get all unique behaviors for the filter dropdown
        $behaviors = $reports->pluck('classification')->unique()->filter();

        // Filter by behavior if requested
        if ($request->filled('behavior')) {
            $reports = $reports->where('classification', $request->behavior);
        }

        // --- CSV Export ---
        if ($request->get('export') === 'csv') {
            $filename = 'reports_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($reports) {
                $handle = fopen('php://output', 'w');
                // Add UTF-8 BOM for Excel
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($handle, ['ID', 'Animal', 'Camera', 'Behavior', 'Confidence', 'Created At']);
                foreach ($reports as $report) {
                    fputcsv($handle, [
                        $report->id,
                        $report->animal_name,
                        $report->camera,
                        $report->classification,
                        $report->confidence,
                        $report->created_at,
                    ]);
                }
                fclose($handle);
            };

            return Response::stream($callback, 200, $headers);
        }

        // --- PDF Export ---
        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.export_pdf', ['reports' => $reports]);
            return $pdf->download('reports_' . now()->format('Ymd_His') . '.pdf');
        }

        return view('admin.reports.index', compact('reports', 'behaviors'));
    }
}
