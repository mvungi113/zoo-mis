<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(FirebaseService $firebase)
    {
        $notifications = $firebase->getNotifications(); // We will add this in FirebaseService

        $collection = collect($notifications ?? [])->map(function ($notification, $key) {
            return [
                'id' => $key,
                'animal_name' => $notification['animal_name'] ?? 'Unknown',
                'classification' => $notification['classification'] ?? 'N/A',
                'camera' => $notification['camera'] ?? 'Unknown',
                'type' => $notification['type'] ?? 'N/A',
                'timestamp' => $notification['timestamp'] ?? now(),
            ];
        })->sortByDesc('timestamp')->values();

        $perPage = 12;
        $page = request()->get('page', 1);

        $paginated = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('notifications.index', ['notifications' => $paginated]);
    }
}
