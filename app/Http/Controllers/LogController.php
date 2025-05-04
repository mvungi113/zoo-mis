<?php

namespace App\Http\Controllers;
use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
class LogController extends Controller
{
    // This file is part of the Zoomis project.
    // The LogController handles the display of logs from Firebase.
    public function index(FirebaseService $firebase)
{
    $logs = $firebase->getLogs();

    // Convert Firebase data (assoc array) to a Laravel collection
    $collection = collect($logs ?? [])->map(function ($log, $key) {
        return [
            'id' => $key,
            'animal_name' => $log['animal_name'] ?? 'Unknown',
            'camera' => $log['camera'] ?? 'Unknown',
            'confidence' => $log['confidence'] ?? 'N/A',
            'classification' => $log['classification'] ?? 'N/A',
            'created_at' => $log['timestamp'] ?? now(),
        ];
    })->sortByDesc('created_at')->values(); // Optional: sort newest first

    // Manual pagination
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
}
