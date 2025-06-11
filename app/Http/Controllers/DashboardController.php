<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class DashboardController extends Controller
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
            Log::error('Firebase initialization failed in DashboardController: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getLogs()
    {
        try {
            $reference = $this->database->getReference('zoo_logs');
            $data = $reference->getValue();
            
            Log::info('Dashboard getLogs called, data retrieved: ' . (is_array($data) ? count($data) : 'null'));
            
            return $data ?? [];
        } catch (\Exception $e) {
            Log::error('Firebase getLogs error in Dashboard: ' . $e->getMessage());
            return [];
        }
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function getCharts()
    {
        try {
            $logs = $this->getLogs();
            
            Log::info('Dashboard getCharts: Processing ' . count($logs) . ' logs');

            $normal = ['eating', 'resting', 'walking', 'sleeping'];
            $warning = ['visitor close', 'user interacting with animal', 'unusual behavior'];
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

            $result = [
                'normal' => $categories['normal'],
                'warning' => $categories['warning'],
                'hazard' => $categories['hazard'],
                'summary' => [
                    'Normal' => array_sum($categories['normal']),
                    'Warning' => array_sum($categories['warning']),
                    'Hazard' => array_sum($categories['hazard']),
                ],
            ];
            
            Log::info('Dashboard getCharts result: ' . json_encode($result));
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Dashboard getCharts error: ' . $e->getMessage());
            return response()->json([
                'normal' => [],
                'warning' => [],
                'hazard' => [],
                'summary' => ['Normal' => 0, 'Warning' => 0, 'Hazard' => 0]
            ], 500);
        }
    }

    public function getKPIs()
    {
        try {
            $logs = $this->getLogs();
            $today = now()->format('Y-m-d');
            
            Log::info('Dashboard getKPIs: Processing ' . count($logs) . ' logs for date: ' . $today);
            
            $totalDetections = count($logs);
            
            // Get active cameras (cameras that sent data in last 24 hours)
            $activeCameras = collect($logs)->filter(function($log) {
                try {
                    return Carbon::parse($log['created_at'])->isAfter(now()->subDay());
                } catch (\Exception $e) {
                    return false;
                }
            })->pluck('camera')->unique()->count();
            
            // Get alerts today
            $alertsToday = collect($logs)->filter(function($log) use ($today) {
                try {
                    return Carbon::parse($log['created_at'])->format('Y-m-d') === $today;
                } catch (\Exception $e) {
                    return false;
                }
            })->count();
            
            // Get critical alerts
            $criticalAlerts = collect($logs)->filter(function($log) {
                $classification = strtolower($log['classification'] ?? '');
                return in_array($classification, ['aggressive', 'attacking', 'animal escape attempt']);
            })->count();
            
            $result = [
                'total_detections' => $totalDetections,
                'active_cameras' => $activeCameras,
                'alerts_today' => $alertsToday,
                'critical_alerts' => $criticalAlerts
            ];
            
            Log::info('Dashboard getKPIs result: ' . json_encode($result));
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Dashboard getKPIs error: ' . $e->getMessage());
            return response()->json([
                'total_detections' => 0,
                'active_cameras' => 0,
                'alerts_today' => 0,
                'critical_alerts' => 0
            ], 500);
        }
    }

    public function getRecentActivity()
    {
        try {
            $logs = collect($this->getLogs())
                ->map(function ($log, $key) {
                    return [
                        'id' => $key,
                        'animal_name' => $log['animal_name'] ?? 'Unknown',
                        'camera' => $log['camera'] ?? 'Unknown',
                        'confidence' => $log['confidence'] ?? 'N/A',
                        'classification' => $log['classification'] ?? 'N/A',
                        'created_at' => $log['created_at'] ?? now(),
                    ];
                })
                ->sortByDesc('created_at')
                ->take(10)
                ->values()
                ->toArray();
            
            Log::info('Dashboard getRecentActivity: Returning ' . count($logs) . ' activities');
            
            return response()->json($logs);
        } catch (\Exception $e) {
            Log::error('Dashboard getRecentActivity error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function getTrends(Request $request)
    {
        try {
            $period = $request->get('period', '24h');
            $logs = collect($this->getLogs());
            
            Log::info('Dashboard getTrends: Processing ' . $logs->count() . ' logs for period: ' . $period);
            
            // Generate sample trend data based on period - you can make this more sophisticated later
            switch ($period) {
                case '24h':
                    $labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'];
                    $normal = [5, 8, 12, 15, 10, 7];
                    $warning = [2, 3, 5, 8, 6, 4];
                    $hazard = [0, 1, 2, 3, 2, 1];
                    break;
                case '7d':
                    $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $normal = [25, 30, 28, 35, 32, 20, 18];
                    $warning = [8, 12, 10, 15, 12, 6, 5];
                    $hazard = [2, 3, 1, 4, 3, 1, 0];
                    break;
                case '30d':
                    $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    $normal = [180, 210, 195, 220];
                    $warning = [65, 78, 72, 85];
                    $hazard = [12, 18, 15, 22];
                    break;
                default:
                    $labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'];
                    $normal = [5, 8, 12, 15, 10, 7];
                    $warning = [2, 3, 5, 8, 6, 4];
                    $hazard = [0, 1, 2, 3, 2, 1];
            }
            
            return response()->json([
                'labels' => $labels,
                'normal' => $normal,
                'warning' => $warning,
                'hazard' => $hazard
            ]);
        } catch (\Exception $e) {
            Log::error('Dashboard getTrends error: ' . $e->getMessage());
            return response()->json([
                'labels' => [],
                'normal' => [],
                'warning' => [],
                'hazard' => []
            ], 500);
        }
    }

    public function getSystemStatus()
    {
        try {
            // Test Firebase connection
            $firebaseConnected = true;
            try {
                $this->database->getReference('zoo_logs')->getValue();
            } catch (\Exception $e) {
                $firebaseConnected = false;
                Log::error('Firebase connection test failed: ' . $e->getMessage());
            }
            
            // Check detection engine (if logs were added recently)
            $recentLogs = collect($this->getLogs())->filter(function($log) {
                try {
                    return Carbon::parse($log['created_at'])->isAfter(now()->subHour());
                } catch (\Exception $e) {
                    return false;
                }
            });
            
            $detectionEngineActive = $recentLogs->count() > 0;
            
            // Count active cameras
            $activeCameras = collect($this->getLogs())->filter(function($log) {
                try {
                    return Carbon::parse($log['created_at'])->isAfter(now()->subDay());
                } catch (\Exception $e) {
                    return false;
                }
            })->pluck('camera')->unique()->count();
            
            $result = [
                'firebase' => $firebaseConnected,
                'detection_engine' => $detectionEngineActive,
                'cameras' => $activeCameras
            ];
            
            Log::info('Dashboard getSystemStatus result: ' . json_encode($result));
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Dashboard getSystemStatus error: ' . $e->getMessage());
            return response()->json([
                'firebase' => false,
                'detection_engine' => false,
                'cameras' => 0
            ], 500);
        }
    }
}
