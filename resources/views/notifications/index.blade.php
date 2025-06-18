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
                                    <div class="p-3 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl shadow-lg">
                                        <i class="bi bi-bell-fill text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
                                            Notifications Center
                                        </h1>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                            <i class="bi bi-fire mr-1 text-orange-500"></i>
                                            Real-time alerts and updates
                                            <span class="ml-2 px-2 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full text-xs font-medium">
                                                <i class="bi bi-circle-fill animate-pulse"></i> Live
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            <button onclick="refreshNotifications()" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="bi bi-arrow-clockwise mr-2" id="refreshIcon"></i>
                                Refresh
                            </button>
                           
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow-xl rounded-2xl p-6 mb-8 border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-lg mr-3">
                            <i class="bi bi-funnel text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Filter Notifications</h3>
                        <div class="ml-auto flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="bi bi-clock mr-1"></i>
                            Auto-refresh every 10s
                        </div>
                    </div>

                    <form method="GET" action="{{ route('notifications.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-tags mr-1"></i>
                                Type
                            </label>
                            <select id="type" name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                                <option value="">All Types</option>
                                <option value="alert" {{ request('type') == 'alert' ? 'selected' : '' }}>Danger</option>
                                <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                            </select>
                        </div>

                        <div>
                            <label for="animal" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-search mr-1"></i>
                                Animal
                            </label>
                            <input type="text" id="animal" name="animal" value="{{ request('animal') }}" 
                                placeholder="Search by animal name..."
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="camera" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                <i class="bi bi-camera mr-1"></i>
                                Camera
                            </label>
                            <input type="text" id="camera" name="camera" value="{{ request('camera') }}" 
                                placeholder="Search by camera..."
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="bi bi-search mr-2"></i>
                                Apply Filters
                            </button>
                        </div>
                    </form>

                
                </div>

                <!-- Enhanced Notifications List -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow-2xl rounded-2xl border border-white/20 overflow-hidden">
                    @if($notifications->isEmpty())
                        <div class="text-center text-gray-500 dark:text-gray-400 py-16">
                            <div class="mx-auto mb-6 w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i class="bi bi-bell text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">No Notifications Found</h3>
                            <p class="text-sm mb-6">No notifications match your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('notifications.index') }}" 
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
                                    <i class="bi bi-bell mr-2"></i>
                                    Recent Notifications
                                    <span class="ml-3 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                        {{ $notifications->total() }} total
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

                        <!-- Enhanced Table -->
                        <div id="notifications-table" class="overflow-x-auto">
                            <div class="min-w-full">
                                @foreach ($notifications as $index => $note)
                                    <div class="flex items-center p-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group {{ $index % 2 == 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50/50 dark:bg-gray-900/50' }}">
                                        <!-- Priority Indicator -->
                                        <div class="flex-shrink-0 mr-4">
                                            @if(strtolower($note['type']) === 'alert')
                                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                                    <i class="bi bi-exclamation-triangle text-white text-lg"></i>
                                                </div>
                                            @elseif(strtolower($note['type']) === 'info')
                                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                                    <i class="bi bi-info-circle text-white text-lg"></i>
                                                </div>
                                            @elseif(strtolower($note['type']) === 'warning')
                                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                                    <i class="bi bi-exclamation-circle text-white text-lg"></i>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl flex items-center justify-center shadow-lg">
                                                    <i class="bi bi-bell text-white text-lg"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Notification Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-3">
                                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $note['animal_name'] ?? 'Unknown Animal' }}
                                                    </h4>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        <i class="bi bi-camera mr-1"></i>
                                                        {{ $note['camera'] ?? 'Unknown Camera' }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <!-- Classification Badge -->
                                                    @if(isset($note['classification']))
                                                        @php
                                                            $classificationLower = strtolower($note['classification']);
                                                            $badgeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                                            
                                                            if (in_array($classificationLower, ['aggressive', 'attacking', 'animal escape attempt'])) {
                                                                $badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                                            } elseif (in_array($classificationLower, ['visitor close', 'user interacting with animal', 'unusual behavior'])) {
                                                                $badgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                                            } elseif (in_array($classificationLower, ['eating', 'resting', 'walking', 'sleeping'])) {
                                                                $badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                            }
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                                            {{ $note['classification'] }}
                                                        </span>
                                                    @endif

                                                    <!-- Status Badge -->
                                                    @if(strtolower($note['type']) === 'alert')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                            <i class="bi bi-exclamation-triangle mr-1"></i>
                                                            Alert
                                                        </span>
                                                    @elseif(strtolower($note['type']) === 'info')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            <i class="bi bi-info-circle mr-1"></i>
                                                            Info
                                                        </span>
                                                    @elseif(strtolower($note['type']) === 'warning')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            <i class="bi bi-exclamation-circle mr-1"></i>
                                                            Warning
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                            {{ ucfirst($note['type']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Message and Timestamp -->
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    @if(isset($note['message']))
                                                        {{ $note['message'] }}
                                                    @else
                                                        Detection alert for {{ $note['animal_name'] ?? 'unknown animal' }} - {{ $note['classification'] ?? 'unknown behavior' }}
                                                    @endif
                                                </p>
                                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                    <i class="bi bi-clock mr-1"></i>
                                                    <span>{{ \Carbon\Carbon::parse($note['timestamp'])->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($notifications->hasPages())
                            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                                {{ $notifications->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced JavaScript functionality
        let notificationMetrics = {
            responseTime: 0,
            lastUpdate: null,
            connectionStatus: 'connecting'
        };

        // Refresh notifications function
        function refreshNotifications() {
            const refreshIcon = document.getElementById('refreshIcon');
            const startTime = performance.now();
            
            // Show loading state
            refreshIcon.classList.add('animate-spin');
            
            fetch("{{ route('notifications.refresh') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const endTime = performance.now();
                const responseTime = Math.round(endTime - startTime);
                
                // Update response time display
                document.getElementById('notificationResponseTime').textContent = `Response: ${responseTime}ms`;
                
                // Update statistics
                if (data.stats) {
                    document.getElementById('totalNotifications').textContent = data.stats.total || 0;
                    document.getElementById('criticalAlerts').textContent = data.stats.critical || 0;
                    document.getElementById('infoMessages').textContent = data.stats.info || 0;
                    document.getElementById('todayCount').textContent = data.stats.today || 0;
                }
                
                // Update table content if provided
                if (data.html) {
                    document.getElementById('notifications-table').innerHTML = data.html;
                }
                
                console.log('✅ Notifications refreshed successfully');
                
                // Show success feedback
                showNotification('Notifications updated successfully', 'success');
                
            })
            .catch(error => {
                console.error('❌ Error refreshing notifications:', error);
                showNotification('Failed to refresh notifications', 'error');
            })
            .finally(() => {
                // Remove loading state
                setTimeout(() => {
                    refreshIcon.classList.remove('animate-spin');
                }, 500);
            });
        }

        // Mark all as read function
        function markAllAsRead() {
            if (!confirm('Mark all notifications as read?')) return;
            
            fetch("{{ route('notifications.markAllRead') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All notifications marked as read', 'success');
                    refreshNotifications();
                } else {
                    showNotification('Failed to mark notifications as read', 'error');
                }
            })
            .catch(error => {
                console.error('Error marking notifications as read:', error);
                showNotification('Failed to mark notifications as read', 'error');
            });
        }

        // Clear all notifications function
        function clearNotifications() {
            if (!confirm('Clear all notifications? This action cannot be undone.')) return;
            
            fetch("{{ route('notifications.clear') }}", {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then data => {
                if (data.success) {
                    showNotification('All notifications cleared', 'success');
                    location.reload();
                } else {
                    showNotification('Failed to clear notifications', 'error');
                }
            })
            .catch(error => {
                console.error('Error clearing notifications:', error);
                showNotification('Failed to clear notifications', 'error');
            });
        }

        // Mark single notification as read
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Notification marked as read', 'success');
                    refreshNotifications();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }

        // Delete single notification
        function deleteNotification(notificationId) {
            if (!confirm('Delete this notification?')) return;
            
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Notification deleted', 'success');
                    refreshNotifications();
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
        }

        // Show notification feedback
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
            
            const bgClass = type === 'success' ? 'bg-green-500' : 
                           type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            notification.classList.add(bgClass, 'text-white');
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Auto-refresh every 10 seconds
        setInterval(refreshNotifications, 10000);

        // Initial load message
        console.log('🚀 Enhanced Notifications Center initialized');
        console.log('🔄 Auto-refresh active (10s intervals)');
    </script>

    <style>
        /* Custom animations */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        /* Hover effects */
        .notification-item:hover {
            transform: translateX(2px);
        }
        
        /* Loading states */
        .loading-overlay {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</x-app-layout>
