<x-app-layout>
    <!-- Enhanced Background with Real-time Indicators -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 relative">
        <!-- Live Connection Status Bar -->
        <div id="connectionStatus" class="relative top-0 left-0 right-0 z-40 bg-green-500 text-white text-center py-2 text-sm font-medium transition-all duration-300 mb-4 rounded-lg mx-4">
            <span><i class="bi bi-check-circle me-1"></i>System Online: Real-time monitoring active</span>
        </div>

        <!-- Floating Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-purple-200 to-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob dark:from-blue-900 dark:to-purple-900"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-gradient-to-br from-blue-200 to-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 dark:from-indigo-900 dark:to-purple-900"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-gradient-to-br from-cyan-200 to-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000 dark:from-purple-900 dark:to-blue-900"></div>
        </div>

        <div class="relative z-10 py-8 max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                            Zoo Intelligence
                        </span>
                        <span class="text-gray-900 dark:text-white">Dashboard</span>
                    </h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Monitoring animal behaviors and activity patterns in real-time.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div id="refreshIndicator" class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-semibold px-3 py-1 rounded-full flex items-center">
                        <i class="bi bi-arrow-repeat mr-1"></i>
                        <span>Auto refreshing</span>
                    </div>
                    <div class="relative">
                        <button id="refreshBtn" class="bg-white dark:bg-gray-800 shadow-md hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-800 dark:text-white font-semibold py-2 px-4 border border-gray-200 dark:border-gray-700 rounded-lg inline-flex items-center transition-all duration-200">
                            <i class="bi bi-arrow-clockwise mr-2"></i>
                            <span>Refresh All</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Status Panel -->
            <div id="systemStatus" class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center mb-4 lg:mb-0">
                    <div class="bg-green-500 h-16 w-16 rounded-full flex items-center justify-center mr-4">
                        <i class="bi bi-shield-check text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">System Status</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">All systems operational</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3">
                            <i class="bi bi-database text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Firebase</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="firebaseStatus">Connected</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3">
                            <i class="bi bi-camera-video text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Live Cameras</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="cameraStatus">4 active</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3">
                            <i class="bi bi-cpu text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Detection Engine</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="detectionEngineStatus">Processing</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-12 h-32 w-32 bg-yellow-500 opacity-10 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                        <i class="bi bi-camera mr-2 text-yellow-500"></i> Total Detections
                    </h2>
                    <div class="flex items-baseline">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white" id="totalDetections">Loading...</p>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">events</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Across all cameras and animals
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-12 h-32 w-32 bg-blue-500 opacity-10 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                        <i class="bi bi-camera-video mr-2 text-blue-500"></i> Active Cameras
                    </h2>
                    <div class="flex items-baseline">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white" id="activeCameras">Loading...</p>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">cameras</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Reporting in last 24 hours
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-12 h-32 w-32 bg-indigo-500 opacity-10 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                        <i class="bi bi-bell mr-2 text-indigo-500"></i> Alerts Today
                    </h2>
                    <div class="flex items-baseline">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white" id="alertsToday">Loading...</p>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">alerts</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Generated in the last 24h
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-12 h-32 w-32 bg-red-500 opacity-10 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                        <i class="bi bi-exclamation-triangle mr-2 text-red-500"></i> Critical Alerts
                    </h2>
                    <div class="flex items-baseline">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white" id="criticalAlerts">Loading...</p>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">incidents</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        High-priority issues to address
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Detection Trends Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden lg:col-span-2">
                    <div class="absolute top-2 right-2">
                        <span id="trendDataSource" class="text-xs text-indigo-500 dark:text-indigo-400 font-medium bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded-full">
                            Firebase Data
                        </span>
                    </div>
                    
                    <h2 class="text-xl font-bold mb-1 text-gray-900 dark:text-white flex items-center">
                        <i class="bi bi-graph-up-arrow mr-2 text-indigo-500"></i> Detection Trends
                    </h2>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Animal behavior detection patterns over time
                    </p>
                    
                    <div class="flex justify-end mb-4">
                        <select id="trendFilter" class="rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm py-1 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="24h">Last 24 Hours</option>
                            <option value="7d">Last 7 Days</option>
                            <option value="30d">Last 30 Days</option>
                            <option value="90d">Last 90 Days</option>
                        </select>
                    </div>
                    
                    <div id="trendChartContainer" class="relative h-64 transition-opacity duration-300">
                        <canvas id="trendChart"></canvas>
                    </div>
                    
                    <div class="flex justify-between mt-4 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-3">
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                            <span>Normal</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>
                            <span>Warning</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span>
                            <span>Hazard</span>
                        </div>
                    </div>
                </div>

                <!-- Distribution Chart Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden col-span-1">
                    <h2 class="text-xl font-bold mb-1 text-gray-900 dark:text-white flex items-center">
                        <i class="bi bi-pie-chart mr-2 text-purple-500"></i> Behavior Distribution
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Classification breakdown by type
                    </p>
                    
                    <div class="relative h-48 mb-4">
                        <canvas id="donutChart"></canvas>
                    </div>

                    <div id="chartLegend" class="space-y-3 pt-2">
                        <!-- Generated dynamically -->
                    </div>
                </div>

                <!-- Recent Activity Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden lg:col-span-2">
                    <h2 class="text-xl font-bold mb-1 text-gray-900 dark:text-white flex items-center">
                        <i class="bi bi-activity mr-2 text-green-500"></i> Recent Activity
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Latest animal detections and behaviors
                    </p>
                    
                    <div class="overflow-hidden">
                        <div class="align-middle inline-block min-w-full">
                            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Animal</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Camera</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Behavior</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentActivityBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white" colspan="4">
                                                <div class="flex items-center justify-center">
                                                    <i class="bi bi-hourglass animate-spin mr-2"></i>
                                                    Loading recent activity...
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Behavior Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 relative overflow-hidden col-span-1">
                    <h2 class="text-xl font-bold mb-1 text-gray-900 dark:text-white flex items-center">
                        <i class="bi bi-list-check mr-2 text-blue-500"></i> Behavior Categories
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Detected behaviors by type
                    </p>

                    <div id="categoryAccordion" class="space-y-3">
                        <!-- Normal Behaviors -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <h2>
                                <button type="button" class="flex w-full items-center justify-between p-4 text-left" data-accordion-target="#normal-behaviors">
                                    <span class="flex items-center">
                                        <span class="bg-green-100 dark:bg-green-900/30 p-1.5 rounded-full mr-2">
                                            <i class="bi bi-emoji-smile text-green-500"></i>
                                        </span>
                                        <span class="font-medium text-gray-900 dark:text-white">Normal Behaviors</span>
                                    </span>
                                    <i class="bi bi-chevron-down text-gray-500"></i>
                                </button>
                            </h2>
                            <div id="normal-behaviors" class="p-4 pt-0">
                                <ul id="normalBehaviorsList" class="space-y-2">
                                    <li class="text-sm text-gray-500 dark:text-gray-400">Loading...</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Warning Behaviors -->
                        <div class="bg-yellow-50 dark:bg-yellow-900/10 rounded-lg overflow-hidden">
                            <h2>
                                <button type="button" class="flex w-full items-center justify-between p-4 text-left" data-accordion-target="#warning-behaviors">
                                    <span class="flex items-center">
                                        <span class="bg-yellow-100 dark:bg-yellow-900/30 p-1.5 rounded-full mr-2">
                                            <i class="bi bi-exclamation text-yellow-500"></i>
                                        </span>
                                        <span class="font-medium text-gray-900 dark:text-white">Warning Behaviors</span>
                                    </span>
                                    <i class="bi bi-chevron-down text-gray-500"></i>
                                </button>
                            </h2>
                            <div id="warning-behaviors" class="p-4 pt-0">
                                <ul id="warningBehaviorsList" class="space-y-2">
                                    <li class="text-sm text-gray-500 dark:text-gray-400">Loading...</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Hazard Behaviors -->
                        <div class="bg-red-50 dark:bg-red-900/10 rounded-lg overflow-hidden">
                            <h2>
                                <button type="button" class="flex w-full items-center justify-between p-4 text-left" data-accordion-target="#hazard-behaviors">
                                    <span class="flex items-center">
                                        <span class="bg-red-100 dark:bg-red-900/30 p-1.5 rounded-full mr-2">
                                            <i class="bi bi-exclamation-triangle text-red-500"></i>
                                        </span>
                                        <span class="font-medium text-gray-900 dark:text-white">Hazard Behaviors</span>
                                    </span>
                                    <i class="bi bi-chevron-down text-gray-500"></i>
                                </button>
                            </h2>
                            <div id="hazard-behaviors" class="p-4 pt-0">
                                <ul id="hazardBehaviorsList" class="space-y-2">
                                    <li class="text-sm text-gray-500 dark:text-gray-400">Loading...</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/dashboard.js"></script>
</x-app-layout>