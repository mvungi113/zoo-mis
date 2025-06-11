<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class NotificationController extends Controller
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
            Log::error('Firebase initialization failed in NotificationController: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getNotifications()
    {
        try {
            // Use 'notifications' path based on your Firebase structure
            $reference = $this->database->getReference('notifications');
            $data = $reference->getValue();
            
            Log::info('Firebase getNotifications called, data retrieved: ' . (is_array($data) ? count($data) : 'null'));
            
            return $data ?? [];
        } catch (\Exception $e) {
            Log::error('Firebase getNotifications error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function index(Request $request)
    {
        try {
            Log::info('NotificationController index method called');
            
            $notifications = collect($this->getNotifications())->map(function ($notification, $key) {
                return [
                    'id' => $key,
                    'animal_name' => $notification['animal_name'] ?? 'Unknown',
                    'classification' => $notification['classification'] ?? 'N/A',
                    'camera' => $notification['camera'] ?? 'Unknown',
                    'type' => $notification['type'] ?? 'N/A',
                    'severity' => $notification['severity'] ?? 'info',
                    'message' => $notification['message'] ?? 'No message',
                    'timestamp' => $notification['timestamp'] ?? $notification['created_at'] ?? now(),
                ];
            })->sortByDesc('timestamp')->values();

            $perPage = 12;
            $page = $request->get('page', 1);

            $paginated = new LengthAwarePaginator(
                $notifications->forPage($page, $perPage),
                $notifications->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('notifications.index', ['notifications' => $paginated]);
            
        } catch (\Exception $e) {
            Log::error('NotificationController index error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Unable to load notifications: ' . $e->getMessage());
        }
    }

    public function markAsRead(Request $request)
    {
        try {
            $notificationId = $request->input('id');
            
            if (!$notificationId) {
                return response()->json(['error' => 'Notification ID required'], 400);
            }

            $reference = $this->database->getReference('notifications/' . $notificationId);
            $reference->update(['read' => true, 'read_at' => now()->toISOString()]);

            return response()->json(['success' => 'Notification marked as read']);
            
        } catch (\Exception $e) {
            Log::error('NotificationController markAsRead error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to mark notification as read'], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $notifications = $this->getNotifications();
            
            foreach ($notifications as $key => $notification) {
                if (!isset($notification['read']) || !$notification['read']) {
                    $reference = $this->database->getReference('notifications/' . $key);
                    $reference->update(['read' => true, 'read_at' => now()->toISOString()]);
                }
            }

            return response()->json(['success' => 'All notifications marked as read']);
            
        } catch (\Exception $e) {
            Log::error('NotificationController markAllAsRead error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to mark all notifications as read'], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $notificationId = $request->input('id');
            
            if (!$notificationId) {
                return response()->json(['error' => 'Notification ID required'], 400);
            }

            $reference = $this->database->getReference('notifications/' . $notificationId);
            $reference->remove();

            return response()->json(['success' => 'Notification deleted']);
            
        } catch (\Exception $e) {
            Log::error('NotificationController delete error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete notification'], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $notifications = $this->getNotifications();
            $unreadCount = 0;
            
            foreach ($notifications as $notification) {
                if (!isset($notification['read']) || !$notification['read']) {
                    $unreadCount++;
                }
            }

            return response()->json(['unread_count' => $unreadCount]);
            
        } catch (\Exception $e) {
            Log::error('NotificationController getUnreadCount error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get unread count'], 500);
        }
    }

    public function latest()
    {
        try {
            $notifications = collect($this->getNotifications())->map(function ($notification, $key) {
                return [
                    'id' => $key,
                    'animal_name' => $notification['animal_name'] ?? 'Unknown',
                    'classification' => $notification['classification'] ?? 'N/A',
                    'camera' => $notification['camera'] ?? 'Unknown',
                    'type' => $notification['type'] ?? 'N/A',
                    'severity' => $notification['severity'] ?? 'info',
                    'message' => $notification['message'] ?? 'No message',
                    'timestamp' => $notification['timestamp'] ?? $notification['created_at'] ?? now(),
                    'read' => $notification['read'] ?? false,
                ];
            })->sortByDesc('timestamp')->take(10)->values();

            return response()->json(['notifications' => $notifications]);
            
        } catch (\Exception $e) {
            Log::error('NotificationController latest error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get latest notifications'], 500);
        }
    }
}
