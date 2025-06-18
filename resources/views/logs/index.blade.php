<x-app-layout>
    <!-- Add Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow-2xl rounded-2xl p-8 mb-8 border border-white/20">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- Title Section -->
                        <div class="mb-6 lg:mb-0">
                            <div class="flex items-center mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                                        <i class="bi bi-database-fill text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                            Detection Logs
                                        </h1>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                            <i class="bi bi-fire mr-1 text-orange-500"></i>
                                            Real-time Firebase data
                                            <span class="ml-2 px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-medium">
                                                <i class="bi bi-circle-fill animate-pulse"></i> Live
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Export Buttons -->
                        @if(Auth::user() && Auth::user()->role === 'admin')
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <a href="{{ route('logs.export', array_merge(request()->all(), ['type' => 'pdf'])) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <i class="bi bi-file-earmark-pdf mr-2"></i>
                                    Export PDF
                                </a>
                                <a href="{{ route('logs.export', array_merge(request()->all(), ['type' => 'csv'])) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <i class="bi bi-file-earmark-spreadsheet mr-2"></i>
                                    Export CSV
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Enhanced Filter Section -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow-xl rounded-2xl p-6 mb-8 border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-lg mr-3">
                            <i class="bi bi-funnel text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Filter Detection Logs</h3>
                        <div class="ml-auto flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="bi bi-clock mr-1"></i>
                            Auto-refresh every 5s
                        </div>
                    </div>

                    <form method="GET" action="{{ route('logs.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                        <!-- Date Range Filters -->
                        <div class="lg:col-span-2">
                            <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-calendar-date mr-1"></i>
                                From Date
                            </label>
                            <input type="date" id="from" name="from" value="{{ request('from') }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                        </div>
                        
                        <div class="lg:col-span-2">
                            <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-calendar-check mr-1"></i>
                                To Date
                            </label>
                            <input type="date" id="to" name="to" value="{{ request('to') }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                        </div>

                        <!-- Classification Filter -->
                        <div>
                            <label for="classification" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-tags mr-1"></i>
                                Classification
                            </label>
                            <select id="classification" name="classification"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                                <option value="">All Classifications</option>
                                <option value="eating" {{ request('classification') == 'eating' ? 'selected' : '' }}>Eating</option>
                                <option value="resting" {{ request('classification') == 'resting' ? 'selected' : '' }}>Resting</option>
                                <option value="walking" {{ request('classification') == 'walking' ? 'selected' : '' }}>Walking</option>
                                <option value="sleeping" {{ request('classification') == 'sleeping' ? 'selected' : '' }}>Sleeping</option>
                                <option value="visitor close" {{ request('classification') == 'visitor close' ? 'selected' : '' }}>Visitor Close</option>
                                <option value="user interacting with animal" {{ request('classification') == 'user interacting with animal' ? 'selected' : '' }}>User Interacting</option>
                                <option value="unusual behavior" {{ request('classification') == 'unusual behavior' ? 'selected' : '' }}>Unusual Behavior</option>
                                <option value="aggressive" {{ request('classification') == 'aggressive' ? 'selected' : '' }}>Aggressive</option>
                                <option value="attacking" {{ request('classification') == 'attacking' ? 'selected' : '' }}>Attacking</option>
                                <option value="animal escape attempt" {{ request('classification') == 'animal escape attempt' ? 'selected' : '' }}>Escape Attempt</option>
                            </select>
                        </div>

                        <!-- Apply Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="bi bi-search mr-2"></i>
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

              

                <!-- Main Content -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow-2xl rounded-2xl border border-white/20 overflow-hidden">
                    @if($logs->isEmpty())
                        <div class="text-center text-gray-500 dark:text-gray-400 py-16">
                            <div class="mx-auto mb-6 w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i class="bi bi-database text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">No Detection Logs Found</h3>
                            <p class="text-sm mb-6">No logs match your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('logs.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="bi bi-arrow-clockwise mr-2"></i>
                                Clear Filters
                            </a>
                        </div>
                    @else
                        <!-- Table Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <i class="bi bi-table mr-2"></i>
                                    Detection Results
                                    <span class="ml-3 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                        {{ $logs->total() }} records
                                    </span>
                                </h3>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <span>Live updates</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Content -->
                        <div id="logs-table" class="overflow-x-auto">
                            @include('logs.partials.table', ['logs' => $logs])
                        </div>

                        <!-- Pagination -->
                        @if($logs->hasPages())
                            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                                {{ $logs->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced refresh function with loading indicator
        function refreshLogsTable() {
            const table = document.getElementById('logs-table');
            
            // Show loading state
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'absolute inset-0 bg-white/50 dark:bg-gray-800/50 flex items-center justify-center z-10';
            loadingOverlay.innerHTML = `
                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                    <i class="bi bi-arrow-clockwise animate-spin"></i>
                    <span class="text-sm">Refreshing data...</span>
                </div>
            `;
            
            // Make table container relative for overlay
            table.style.position = 'relative';
            table.appendChild(loadingOverlay);

            // Fetch updated data
            fetch("{{ route('logs.table') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                // Remove loading overlay
                if (loadingOverlay.parentNode) {
                    loadingOverlay.remove();
                }
                
                // Update table content
                table.innerHTML = html;
                
                // Update statistics if they exist
                updateStatistics();
                
                console.log('✅ Logs table refreshed successfully');
            })
            .catch(error => {
                console.error('❌ Error refreshing logs:', error);
                
                // Remove loading overlay
                if (loadingOverlay.parentNode) {
                    loadingOverlay.remove();
                }
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 m-4';
                errorDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 dark:text-red-300 text-sm">Failed to refresh data. Please check your connection.</span>
                    </div>
                `;
                table.appendChild(errorDiv);
                
                // Remove error message after 5 seconds
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 5000);
            });
        }

        // Function to update statistics (placeholder - implement based on your needs)
        function updateStatistics() {
            // This would typically fetch updated statistics
            // For now, we'll just log that stats should be updated
            console.log('📊 Statistics should be updated here');
        }

        // Auto-refresh every 5 seconds
        setInterval(refreshLogsTable, 5000);

        // Initial load message
        console.log('🚀 Enhanced Detection Logs initialized');
        console.log('🔄 Auto-refresh active (5s intervals)');
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        
        /* Loading states */
        .loading {
            position: relative;
            overflow: hidden;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>
</x-app-layout>
