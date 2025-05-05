<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class LogController extends Controller
{
    // Display paginated logs from Firebase
    public function index(FirebaseService $firebase)
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
                'created_at' => $log['timestamp'] ?? now(),
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

        return view('logs.index', ['logs' => $paginatedLogs]);
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
                'created_at' => $log['timestamp'] ?? now(),
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

}
