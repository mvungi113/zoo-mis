<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto space-y-8">
        <!-- Key Metrics Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Key Metrics</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Detections</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="totalDetections">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Cameras</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="activeCameras">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Alerts Today</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="alertsToday">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Critical Alerts</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="criticalAlerts">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and System Status Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Recent Activity</h2>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                    <div class="p-6">
                        <div class="space-y-4" id="recentActivity">
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                Loading recent activities...
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('logs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View All Activities →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">System Status</h2>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Firebase Connection</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="firebaseStatus">
                                Connected
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Detection Engine</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="detectionStatus">
                                Active
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Camera Network</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="cameraStatus">
                                Online
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Last Update</span>
                            <span class="text-gray-700 dark:text-gray-300 text-sm" id="lastUpdate">
                                Just now
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detection Trends Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Detection Trends</h2>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Activity Over Time</h3>
                    <select id="trendFilter" class="rounded-md border-gray-300 text-sm">
                        <option value="24h">Last 24 Hours</option>
                        <option value="7d">Last 7 Days</option>
                        <option value="30d">Last 30 Days</option>
                    </select>
                </div>
                <div class="h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Situational Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 flex flex-col items-center">
                    <h3 class="font-bold text-lg mb-2 text-gray-700 dark:text-gray-200">Normal Situations</h3>
                    <div class="w-[220px] h-[220px]">
                        <canvas id="normalChart" width="220" height="220"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 flex flex-col items-center">
                    <h3 class="font-bold text-lg mb-2 text-gray-700 dark:text-gray-200">Warning Situations</h3>
                    <div class="w-[220px] h-[220px]">
                        <canvas id="warningChart" width="220" height="220"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 flex flex-col items-center">
                    <h3 class="font-bold text-lg mb-2 text-gray-700 dark:text-gray-200">Hazard Situations</h3>
                    <div class="w-[220px] h-[220px]">
                        <canvas id="hazardChart" width="220" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Overall Summary</h2>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 flex flex-col items-center">
                <div class="w-[260px] h-[260px]">
                    <canvas id="summaryChart" width="260" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let charts = {};
        let trendChart = null;

        function renderChart(id, data, label) {
            const ctx = document.getElementById(id).getContext('2d');
            const backgroundColors = [
                '#4CAF50', '#2196F3', '#FF9800', '#F44336', '#9C27B0', '#00BCD4', '#8BC34A'
            ];

            if (charts[id]) {
                charts[id].data = {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: backgroundColors
                    }]
                };
                charts[id].options.plugins.title.text = label;
                charts[id].update();
            } else {
                charts[id] = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            label: label,
                            data: Object.values(data),
                            backgroundColor: backgroundColors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: label
                            }
                        }
                    }
                });
            }
        }

        function renderTrendChart(data) {
            const ctx = document.getElementById('trendChart').getContext('2d');
            
            if (trendChart) {
                trendChart.destroy();
            }

            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Normal',
                        data: data.normal,
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Warning',
                        data: data.warning,
                        borderColor: '#FF9800',
                        backgroundColor: 'rgba(255, 152, 0, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Hazard',
                        data: data.hazard,
                        borderColor: '#F44336',
                        backgroundColor: 'rgba(244, 67, 54, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }

        function updateKPIs(data) {
            document.getElementById('totalDetections').textContent = data.total_detections || 0;
            document.getElementById('activeCameras').textContent = data.active_cameras || 0;
            document.getElementById('alertsToday').textContent = data.alerts_today || 0;
            document.getElementById('criticalAlerts').textContent = data.critical_alerts || 0;
        }

        function updateRecentActivity(activities) {
            const container = document.getElementById('recentActivity');
            container.innerHTML = '';
            
            if (!activities || activities.length === 0) {
                container.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-8">No recent activities</div>';
                return;
            }

            activities.slice(0, 5).forEach(activity => {
                const activityElement = document.createElement('div');
                activityElement.className = 'flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg';
                
                const severityColor = activity.classification === 'attacking' ? 'text-red-600' : 
                                    activity.classification === 'visitor close' ? 'text-yellow-600' : 'text-green-600';
                
                activityElement.innerHTML = `
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            ${activity.animal_name} - ${activity.classification}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Camera: ${activity.camera} | Confidence: ${activity.confidence}%
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                        ${new Date(activity.created_at).toLocaleTimeString()}
                    </div>
                `;
                
                container.appendChild(activityElement);
            });
        }

        function updateSystemStatus(status) {
            // Update Firebase status
            const firebaseStatus = document.getElementById('firebaseStatus');
            firebaseStatus.textContent = status.firebase ? 'Connected' : 'Disconnected';
            firebaseStatus.className = status.firebase ? 
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800' :
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';

            // Update detection engine status
            const detectionStatus = document.getElementById('detectionStatus');
            detectionStatus.textContent = status.detection_engine ? 'Active' : 'Inactive';
            detectionStatus.className = status.detection_engine ?
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800' :
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';

            // Update camera network status
            const cameraStatus = document.getElementById('cameraStatus');
            cameraStatus.textContent = status.cameras > 0 ? 'Online' : 'Offline';
            cameraStatus.className = status.cameras > 0 ?
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800' :
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
        }

        function fetchDashboardData() {
            Promise.all([
                fetch('/dashboard/charts').then(res => res.json()),
                fetch('/dashboard/kpis').then(res => res.json()),
                fetch('/dashboard/recent-activity').then(res => res.json()),
                fetch('/dashboard/trends').then(res => res.json()),
                fetch('/dashboard/system-status').then(res => res.json())
            ]).then(([charts, kpis, activity, trends, systemStatus]) => {
                // Update charts
                renderChart('normalChart', charts.normal, 'Normal Situations');
                renderChart('warningChart', charts.warning, 'Warning Situations');
                renderChart('hazardChart', charts.hazard, 'Hazard Situations');
                renderChart('summaryChart', charts.summary, 'Overall Summary');
                
                // Update KPIs
                updateKPIs(kpis);
                
                // Update recent activity
                updateRecentActivity(activity);
                
                // Update trend chart
                renderTrendChart(trends);
                
                // Update system status
                updateSystemStatus(systemStatus);
                
                // Update last update time
                document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString();
            }).catch(error => {
                console.error('Dashboard update failed:', error);
            });
        }

        // Event listeners
        document.getElementById('trendFilter').addEventListener('change', function() {
            fetch(`/dashboard/trends?period=${this.value}`)
                .then(res => res.json())
                .then(trends => renderTrendChart(trends));
        });

        // Initial load and auto-refresh
        fetchDashboardData();
        setInterval(fetchDashboardData, 30000); // Auto-refresh every 30 seconds
    </script>
</x-app-layout>
