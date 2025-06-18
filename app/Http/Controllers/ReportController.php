<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('zoomisapi-firebase.json'))
            ->withDatabaseUri('https://zoomisapi-default-rtdb.firebaseio.com/');

        $database = $factory->createDatabase();

        // Fetch all logs from Firebase
        $logs = $database->getReference('zoo_logs')->getValue();

        // Convert logs to a collection for easier handling
        $allReports = collect($logs)->map(function ($item, $key) {
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
        $behaviors = $allReports->pluck('classification')->unique()->filter();

        // Filter by behavior if requested
        if ($request->filled('behavior')) {
            $allReports = $allReports->where('classification', $request->behavior);
        }

        // --- CSV Export ---
        if ($request->get('export') === 'csv') {
            $filename = 'reports_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($allReports) {
                $handle = fopen('php://output', 'w');
                // Add UTF-8 BOM for Excel
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($handle, ['ID', 'Animal', 'Camera', 'Behavior', 'Confidence', 'Created At']);
                foreach ($allReports as $report) {
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
            $pdf = Pdf::loadView('admin.reports.export_pdf', ['reports' => $allReports]);
            return $pdf->download('reports_' . now()->format('Ymd_His') . '.pdf');
        }

        // Pagination setup
        $perPage = 12;
        $currentPage = Paginator::resolveCurrentPage();
        $currentItems = $allReports->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $reports = new LengthAwarePaginator(
            $currentItems,
            $allReports->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );

        // Preserve query parameters for pagination links
        $reports->appends($request->query());

        return view('admin.reports.index', compact('reports', 'behaviors'));
    }
}
