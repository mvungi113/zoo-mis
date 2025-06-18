<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    private $database;
    
    // Cache duration in seconds
    const CACHE_DURATION = 30; // 30 seconds for real-time feel
    const NOTIFICATIONS_PER_PAGE = 15;

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

    /**
     * Enhanced Firebase data fetching with smart notification generation
     */
    private function getNotifications($limit = null)
    {
        try {
            $cacheKey = 'firebase_notifications_' . md5(($limit ?? 'all'));
            
            return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($limit) {
                // First, try to get from dedicated notifications table
                $notificationsRef = $this->database->getReference('notifications');
                $existingNotifications = $notificationsRef->getValue() ?? [];
                
                // Also get critical/warning logs from zoo_logs to auto-generate notifications
                $logsRef = $this->database->getReference('zoo_logs');
                $logs = $logsRef->getValue() ?? [];
                
                $notifications = [];
                
                // Add existing notifications
                foreach ($existingNotifications as $key => $notification) {
                    $notifications[] = [
                        'id' => $key,
                        'type' => $notification['type'] ?? 'info',
                        'animal_name' => $notification['animal_name'] ?? 'Unknown',
                        'camera' => $notification['camera'] ?? 'Unknown',
                        'classification' => $notification['classification'] ?? 'N/A',
                        'confidence' => $notification['confidence'] ?? 'N/A',
                        'message' => $notification['message'] ?? 'No message',
                        'timestamp' => $notification['timestamp'] ?? $notification['created_at'] ?? now()->toISOString(),
                        'read' => $notification['read'] ?? false,
                        'severity' => $notification['severity'] ?? $this->determineSeverity($notification['classification'] ?? ''),
                        'source' => 'notification'
                    ];
                }
                
                // Auto-generate notifications from critical/warning logs
                foreach ($logs as $logKey => $log) {
                    $classification = strtolower($log['classification'] ?? '');
                    $severity = $this->determineSeverity($classification);
                    
                    // Only create notifications for critical/warning classifications
                    if ($severity === 'critical' || $severity === 'warning') {
                        // Check if we already have a notification for this log
                        $existsInNotifications = false;
                        foreach ($notifications as $notification) {
                            if ($notification['source'] === 'notification' && 
                                isset($notification['log_id']) && 
                                $notification['log_id'] === $logKey) {
                                $existsInNotifications = true;
                                break;
                            }
                        }
                        
                        if (!$existsInNotifications) {
                            $notifications[] = [
                                'id' => 'log_' . $logKey,
                                'log_id' => $logKey,
                                'type' => $severity === 'critical' ? 'alert' : 'warning',
                                'animal_name' => $log['animal_name'] ?? 'Unknown Animal',
                                'camera' => $log['camera'] ?? 'Unknown Camera',
                                'classification' => $log['classification'] ?? 'Unknown',
                                'confidence' => $log['confidence'] ?? 'N/A',
                                'message' => $this->generateNotificationMessage($log),
                                'timestamp' => $log['created_at'] ?? $log['timestamp'] ?? now()->toISOString(),
                                'read' => false,
                                'severity' => $severity,
                                'source' => 'auto_generated'
                            ];
                        }
                    }
                }
                
                // Sort by timestamp (newest first)
                usort($notifications, function ($a, $b) {
                    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
                });
                
                if ($limit) {
                    $notifications = array_slice($notifications, 0, $limit);
                }
                
                Log::info('🔔 Firebase notifications fetched', [
                    'total_count' => count($notifications),
                    'existing_notifications' => count($existingNotifications),
                    'auto_generated' => count($notifications) - count($existingNotifications),
                    'limit' => $limit
                ]);
                
                return $notifications;
            });
            
        } catch (\Exception $e) {
            Log::error('🔔 Firebase getNotifications error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Determine severity level based on classification
     */
    private function determineSeverity($classification)
    {
        $classification = strtolower($classification);
        
        $critical = ['aggressive', 'attacking', 'cage scratching', 'restricted zone', 'animal escape attempt'];
        $warning = ['visitor close', 'user interacting with animal', 'unusual behavior'];
        $normal = ['eating', 'resting', 'walking', 'sleeping'];

        if (in_array($classification, $critical)) return 'critical';
        if (in_array($classification, $warning)) return 'warning';
        if (in_array($classification, $normal)) return 'normal';
        
        return 'unknown';
    }

    /**
     * Generate intelligent notification messages
     */
    private function generateNotificationMessage($log)
    {
        $animal = $log['animal_name'] ?? 'Unknown animal';
        $classification = $log['classification'] ?? 'unknown behavior';
        $camera = $log['camera'] ?? 'unknown camera';
        $confidence = $log['confidence'] ?? 0;
        
        $severity = $this->determineSeverity($classification);
        
        switch ($severity) {
            case 'critical':
                $icons = ['🚨', '⚠️', '🔴'];
                $icon = $icons[array_rand($icons)];
                return "{$icon} CRITICAL ALERT: {$animal} showing {$classification} behavior detected by {$camera} (confidence: {$confidence}%)";
                
            case 'warning':
                $icons = ['⚠️', '🟡', '📢'];
                $icon = $icons[array_rand($icons)];
                return "{$icon} WARNING: {$animal} - {$classification} detected by {$camera} (confidence: {$confidence}%)";
                
            default:
                return "ℹ️ {$animal} - {$classification} detected by {$camera}";
        }
    }

    /**
     * Enhanced index with validation and filtering
     */
    public function index(Request $request)
    {
        try {
            // Validate request parameters
            $validated = $request->validate([
                'type' => [
                    'nullable',
                    Rule::in(['alert', 'warning', 'info'])
                ],
                'animal' => 'nullable|string|max:100',
                'camera' => 'nullable|string|max:100',
                'severity' => [
                    'nullable',
                    Rule::in(['critical', 'warning', 'normal', 'unknown'])
                ],
                'read' => 'nullable|boolean',
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:5|max:50'
            ]);

            $startTime = microtime(true);
            Log::info('🔔 NotificationController index called', $validated);
            
            // Get all notifications
            $allNotifications = $this->getNotifications();
            
            // Apply filters
            $filteredNotifications = $this->applyFilters($allNotifications, $validated);
            
            // Apply pagination
            $perPage = $validated['per_page'] ?? self::NOTIFICATIONS_PER_PAGE;
            $page = $validated['page'] ?? 1;
            
            $paginatedNotifications = new LengthAwarePaginator(
                array_slice($filteredNotifications, ($page - 1) * $perPage, $perPage),
                count($filteredNotifications),
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query()
                ]
            );

            // Calculate statistics
            $stats = $this->calculateStats($allNotifications);
            
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("✅ Notifications loaded successfully in {$executionTime}ms", [
                'total_notifications' => count($allNotifications),
                'filtered_count' => count($filteredNotifications),
                'page' => $page,
                'per_page' => $perPage
            ]);

            return view('notifications.index', [
                'notifications' => $paginatedNotifications,
                'stats' => $stats,
                'filters' => $validated,
                'execution_time' => $executionTime
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed in NotificationController index', $e->errors());
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('NotificationController index error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Unable to load notifications. Please try again.');
        }
    }

    /**
     * Apply filters to notifications
     */
    private function applyFilters($notifications, $filters)
    {
        $filtered = $notifications;

        if (!empty($filters['type'])) {
            $filtered = array_filter($filtered, function ($notification) use ($filters) {
                return strtolower($notification['type']) === strtolower($filters['type']);
            });
        }

        if (!empty($filters['animal'])) {
            $filtered = array_filter($filtered, function ($notification) use ($filters) {
                return stripos($notification['animal_name'], $filters['animal']) !== false;
            });
        }

        if (!empty($filters['camera'])) {
            $filtered = array_filter($filtered, function ($notification) use ($filters) {
                return stripos($notification['camera'], $filters['camera']) !== false;
            });
        }

        if (!empty($filters['severity'])) {
            $filtered = array_filter($filtered, function ($notification) use ($filters) {
                return strtolower($notification['severity']) === strtolower($filters['severity']);
            });
        }

        if (isset($filters['read'])) {
            $filtered = array_filter($filtered, function ($notification) use ($filters) {
                return (bool)($notification['read'] ?? false) === (bool)$filters['read'];
            });
        }

        return array_values($filtered); // Re-index array
    }

    /**
     * Calculate comprehensive statistics
     */
    private function calculateStats($notifications)
    {
        $total = count($notifications);
        $stats = [
            'total' => $total,
            'critical' => 0,
            'warning' => 0,
            'info' => 0,
            'today' => 0,
            'this_week' => 0,
            'unread' => 0,
            'read' => 0,
            'by_animal' => [],
            'by_camera' => [],
            'by_hour' => []
        ];

        if ($total === 0) return $stats;

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();

        foreach ($notifications as $notification) {
            // Count by type
            switch (strtolower($notification['type'])) {
                case 'alert':
                    $stats['critical']++;
                    break;
                case 'warning':
                    $stats['warning']++;
                    break;
                case 'info':
                    $stats['info']++;
                    break;
            }

            // Time-based stats
            try {
                $notificationDate = Carbon::parse($notification['timestamp']);
                if ($notificationDate->isToday()) $stats['today']++;
                if ($notificationDate->gte($weekStart)) $stats['this_week']++;
                
                // Hour distribution
                $hour = $notificationDate->format('H:00');
                $stats['by_hour'][$hour] = ($stats['by_hour'][$hour] ?? 0) + 1;
            } catch (\Exception $e) {
                Log::warning('Failed to parse notification timestamp: ' . $notification['timestamp']);
            }

            // Read status
            if ($notification['read'] ?? false) {
                $stats['read']++;
            } else {
                $stats['unread']++;
            }

            // By animal
            $animal = $notification['animal_name'] ?? 'Unknown';
            $stats['by_animal'][$animal] = ($stats['by_animal'][$animal] ?? 0) + 1;

            // By camera
            $camera = $notification['camera'] ?? 'Unknown';
            $stats['by_camera'][$camera] = ($stats['by_camera'][$camera] ?? 0) + 1;
        }

        // Sort by count (descending)
        arsort($stats['by_animal']);
        arsort($stats['by_camera']);
        ksort($stats['by_hour']);

        return $stats;
    }

    /**
     * Enhanced refresh method with cache invalidation
     */
    public function refresh(Request $request)
    {
        try {
            $startTime = microtime(true);
            
            // Clear cache to get fresh data
            Cache::forget('firebase_notifications_' . md5('all'));
            
            $notifications = $this->getNotifications();
            $stats = $this->calculateStats($notifications);
            
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            Log::info("🔄 Notifications refreshed in {$executionTime}ms", [
                'count' => count($notifications),
                'unread' => $stats['unread']
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'stats' => $stats,
                    'execution_time' => $executionTime,
                    'message' => 'Notifications refreshed successfully',
                    'timestamp' => now()->toISOString()
                ]);
            }

            return redirect()->route('notifications.index')->with('success', 'Notifications refreshed');
            
        } catch (\Exception $e) {
            Log::error('NotificationController refresh error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to refresh notifications',
                    'message' => config('app.debug') ? $e->getMessage() : 'Please try again'
                ], 500);
            }
            
            return back()->with('error', 'Failed to refresh notifications');
        }
    }

    /**
     * Enhanced mark as read with Firebase update
     */
    public function markAsRead(Request $request, $id)
    {
        try {
            Log::info("🔔 Marking notification {$id} as read");

            // Handle auto-generated notifications differently
            if (strpos($id, 'log_') === 0) {
                // For auto-generated notifications, we can't mark them as read in Firebase logs
                // Instead, we could create a read_notifications table or handle in cache
                Log::info("Auto-generated notification {$id} marked as read (in memory)");
            } else {
                // Update in Firebase for actual notifications
                $reference = $this->database->getReference('notifications/' . $id);
                $reference->update([
                    'read' => true,
                    'read_at' => now()->toISOString()
                ]);
            }

            // Clear cache to force refresh
            Cache::forget('firebase_notifications_' . md5('all'));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification marked as read'
                ]);
            }

            return redirect()->route('notifications.index')->with('success', 'Notification marked as read');
            
        } catch (\Exception $e) {
            Log::error("NotificationController markAsRead error for {$id}: " . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to mark notification as read'
                ], 500);
            }
            
            return back()->with('error', 'Failed to mark notification as read');
        }
    }

    /**
     * Enhanced mark all as read
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $notifications = $this->getNotifications();
            $updatedCount = 0;
            
            foreach ($notifications as $notification) {
                if (!($notification['read'] ?? false)) {
                    $id = $notification['id'];
                    
                    // Skip auto-generated notifications
                    if (strpos($id, 'log_') !== 0) {
                        $reference = $this->database->getReference('notifications/' . $id);
                        $reference->update([
                            'read' => true,
                            'read_at' => now()->toISOString()
                        ]);
                        $updatedCount++;
                    }
                }
            }

            // Clear cache
            Cache::forget('firebase_notifications_' . md5('all'));
            
            Log::info("🔔 Marked {$updatedCount} notifications as read");

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Marked {$updatedCount} notifications as read",
                    'updated_count' => $updatedCount
                ]);
            }

            return redirect()->route('notifications.index')->with('success', "Marked {$updatedCount} notifications as read");
            
        } catch (\Exception $e) {
            Log::error('NotificationController markAllAsRead error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to mark notifications as read'
                ], 500);
            }
            
            return back()->with('error', 'Failed to mark notifications as read');
        }
    }

    /**
     * Enhanced clear all notifications
     */
    public function clear(Request $request)
    {
        try {
            $notifications = $this->getNotifications();
            $deletedCount = 0;
            
            foreach ($notifications as $notification) {
                $id = $notification['id'];
                
                // Only delete actual notifications, not auto-generated ones
                if (strpos($id, 'log_') !== 0) {
                    $reference = $this->database->getReference('notifications/' . $id);
                    $reference->remove();
                    $deletedCount++;
                }
            }

            // Clear cache
            Cache::forget('firebase_notifications_' . md5('all'));
            
            Log::info("🔔 Deleted {$deletedCount} notifications");

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Deleted {$deletedCount} notifications",
                    'deleted_count' => $deletedCount
                ]);
            }

            return redirect()->route('notifications.index')->with('success', "Deleted {$deletedCount} notifications");
            
        } catch (\Exception $e) {
            Log::error('NotificationController clear error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to clear notifications'
                ], 500);
            }
            
            return back()->with('error', 'Failed to clear notifications');
        }
    }

    /**
     * Delete single notification
     */
    public function destroy(Request $request, $id)
    {
        try {
            Log::info("🔔 Deleting notification {$id}");

            // Skip auto-generated notifications
            if (strpos($id, 'log_') === 0) {
                Log::info("Cannot delete auto-generated notification {$id}");
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Cannot delete auto-generated notifications'
                    ], 400);
                }
                
                return back()->with('error', 'Cannot delete auto-generated notifications');
            }

            // Delete from Firebase
            $reference = $this->database->getReference('notifications/' . $id);
            $reference->remove();

            // Clear cache
            Cache::forget('firebase_notifications_' . md5('all'));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification deleted'
                ]);
            }

            return redirect()->route('notifications.index')->with('success', 'Notification deleted');
            
        } catch (\Exception $e) {
            Log::error("NotificationController destroy error for {$id}: " . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to delete notification'
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete notification');
        }
    }

    /**
     * Get unread count for nav badge
     */
    public function getUnreadCount(Request $request)
    {
        try {
            $notifications = $this->getNotifications();
            $unreadCount = 0;
            
            foreach ($notifications as $notification) {
                if (!($notification['read'] ?? false)) {
                    $unreadCount++;
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'unread_count' => $unreadCount
                ]);
            }

            return response()->json(['unread_count' => $unreadCount]);
            
        } catch (\Exception $e) {
            Log::error('NotificationController getUnreadCount error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get unread count'], 500);
        }
    }

    /**
     * Get latest notifications for widgets/popups
     */
    public function latest(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            $notifications = $this->getNotifications($limit);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'notifications' => $notifications,
                    'count' => count($notifications)
                ]);
            }

            return response()->json(['notifications' => $notifications]);
            
        } catch (\Exception $e) {
            Log::error('NotificationController latest error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get latest notifications'], 500);
        }
    }

    /**
     * Clear cache manually (for admin)
     */
    public function clearCache(Request $request)
    {
        try {
            Cache::forget('firebase_notifications_' . md5('all'));
            
            Log::info('🗑️ Notifications cache cleared manually');
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cache cleared successfully'
                ]);
            }
            
            return redirect()->route('notifications.index')->with('success', 'Cache cleared successfully');
            
        } catch (\Exception $e) {
            Log::error('Notifications cache clear error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to clear cache'
                ], 500);
            }
            
            return back()->with('error', 'Failed to clear cache');
        }
    }
}
