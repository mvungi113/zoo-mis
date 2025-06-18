let charts = {};
let trendChart = null;
let firebaseMetrics = {
    totalProcessed: 0,
    lastRefresh: new Date(),
    hasError: false
};

// Performance tracking
const performanceTracker = {
    timestamps: {},
    mark: function(component) {
        this.timestamps[component] = new Date();
        console.log(`🔍 ${component} updated at`, this.timestamps[component]);
    },
    getLastUpdate: function(component) {
        return this.timestamps[component] || null;
    }
};

// Function to refresh all components
function refreshAll() {
    refreshKPIs();
    refreshCharts();
    refreshTrends();
    refreshRecentActivity();
    refreshSystemStatus();

    const refreshBtn = document.getElementById('refreshBtn');
    refreshBtn.disabled = true;
    refreshBtn.classList.add('opacity-75');
    refreshBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-2"></i><span>Refreshing...</span>';

    setTimeout(() => {
        refreshBtn.disabled = false;
        refreshBtn.classList.remove('opacity-75');
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise mr-2"></i><span>Refresh All</span>';

        // Show a success notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-500 translate-y-0 opacity-100';
        notification.innerHTML = '<div class="flex items-center"><i class="bi bi-check-circle mr-2"></i>Dashboard refreshed successfully</div>';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('opacity-0', 'translate-y-[-20px]');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }, 1500);
}

// Fetch KPI data
function refreshKPIs() {
    fetch('/dashboard/kpis')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalDetections').textContent = data.total_detections;
            document.getElementById('activeCameras').textContent = data.active_cameras;
            document.getElementById('alertsToday').textContent = data.alerts_today;
            document.getElementById('criticalAlerts').textContent = data.critical_alerts;

            performanceTracker.mark('kpis');
        })
        .catch(error => {
            console.error('Error fetching KPIs:', error);
        });
}

// Function to fetch trends based on period
function refreshTrends() {
    const period = document.getElementById('trendFilter').value;

    // Show loading state
    document.getElementById('trendChartContainer').classList.add('opacity-50');
    document.getElementById('trendDataSource').textContent = 'Loading...';

    // Fetch trends data from Firebase through our controller
    fetch(`/dashboard/trends?period=${period}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Trends data received:', data);
            renderTrendChart(data);
            document.getElementById('trendDataSource').textContent = `Firebase Data (${period})`;
            document.getElementById('trendChartContainer').classList.remove('opacity-50');

            // Update performance tracker
            performanceTracker.mark('trends');
        })
        .catch(error => {
            console.error('Error fetching trends:', error);
            document.getElementById('trendDataSource').textContent = 'Error loading data';
            document.getElementById('trendChartContainer').classList.remove('opacity-50');
        });
}

// Function to render the trend chart
function renderTrendChart(data) {
    const ctx = document.getElementById('trendChart').getContext('2d');

    // Destroy existing chart if it exists
    if (trendChart) {
        trendChart.destroy();
    }

    // Create new chart
    trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: [
                {
                    label: 'Normal',
                    data: data.normal || [],
                    borderColor: 'rgba(34, 197, 94, 1)',
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Warning',
                    data: data.warning || [],
                    borderColor: 'rgba(234, 179, 8, 1)',
                    backgroundColor: 'rgba(234, 179, 8, 0.2)',
                    pointBackgroundColor: 'rgba(234, 179, 8, 1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Hazard',
                    data: data.hazard || [],
                    borderColor: 'rgba(239, 68, 68, 1)',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(107, 114, 128, 0.2)',
                    borderWidth: 1,
                    padding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    boxPadding: 3,
                    usePointStyle: true,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(75, 85, 99, 0.2)' : 'rgba(243, 244, 246, 0.7)'
                    },
                    ticks: {
                        precision: 0,
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                intersect: false,
                axis: 'x'
            },
            animation: {
                duration: 1000
            }
        }
    });
}

// Fetch chart data
function refreshCharts() {
    fetch('/dashboard/charts')
        .then(response => response.json())
        .then(data => {
            renderDonutChart(data.summary);
            renderBehaviorLists(data);

            performanceTracker.mark('charts');
        })
        .catch(error => {
            console.error('Error fetching charts:', error);
        });
}

// Render the donut chart with Firebase data
function renderDonutChart(data) {
    const ctx = document.getElementById('donutChart').getContext('2d');

    // Destroy any existing chart
    if (charts.donut) {
        charts.donut.destroy();
    }

    const chartData = {
        labels: Object.keys(data),
        datasets: [{
            data: Object.values(data),
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(234, 179, 8, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ],
            borderColor: [
                'rgba(34, 197, 94, 1)',
                'rgba(234, 179, 8, 1)',
                'rgba(239, 68, 68, 1)'
            ],
            borderWidth: 1
        }]
    };

    charts.donut = new Chart(ctx, {
        type: 'doughnut',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Generate chart legend
    const legendContainer = document.getElementById('chartLegend');
    legendContainer.innerHTML = '';

    const colors = ['bg-green-500', 'bg-yellow-500', 'bg-red-500'];
    const labels = Object.keys(data);
    const values = Object.values(data);
    const total = values.reduce((a, b) => a + b, 0);

    labels.forEach((label, i) => {
        const percentage = Math.round((values[i] / total) * 100);
        const legendItem = document.createElement('div');
        legendItem.className = 'flex items-center justify-between';
        legendItem.innerHTML = `
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 ${colors[i]} rounded-full mr-2"></span>
                <span class="text-sm text-gray-600 dark:text-gray-300">${label}</span>
            </div>
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-800 dark:text-gray-200 mr-2">${values[i]}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">${percentage}%</span>
            </div>
        `;
        legendContainer.appendChild(legendItem);
    });
}

// Render behavior lists
function renderBehaviorLists(data) {
    const normalList = document.getElementById('normalBehaviorsList');
    const warningList = document.getElementById('warningBehaviorsList');
    const hazardList = document.getElementById('hazardBehaviorsList');

    normalList.innerHTML = '';
    warningList.innerHTML = '';
    hazardList.innerHTML = '';

    // Normal behaviors
    if (Object.keys(data.normal).length === 0) {
        normalList.innerHTML = '<li class="text-sm text-gray-500 dark:text-gray-400">No normal behaviors detected</li>';
    } else {
        Object.entries(data.normal).forEach(([behavior, count]) => {
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between text-sm';
            li.innerHTML = `
                <span class="text-gray-800 dark:text-gray-200 capitalize">${behavior}</span>
                <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-0.5 rounded-full text-xs font-medium">${count}</span>
            `;
            normalList.appendChild(li);
        });
    }

    // Warning behaviors
    if (Object.keys(data.warning).length === 0) {
        warningList.innerHTML = '<li class="text-sm text-gray-500 dark:text-gray-400">No warning behaviors detected</li>';
    } else {
        Object.entries(data.warning).forEach(([behavior, count]) => {
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between text-sm';
            li.innerHTML = `
                <span class="text-gray-800 dark:text-gray-200 capitalize">${behavior}</span>
                <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 px-2 py-0.5 rounded-full text-xs font-medium">${count}</span>
            `;
            warningList.appendChild(li);
        });
    }

    // Hazard behaviors
    if (Object.keys(data.hazard).length === 0) {
        hazardList.innerHTML = '<li class="text-sm text-gray-500 dark:text-gray-400">No hazard behaviors detected</li>';
    } else {
        Object.entries(data.hazard).forEach(([behavior, count]) => {
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between text-sm';
            li.innerHTML = `
                <span class="text-gray-800 dark:text-gray-200 capitalize">${behavior}</span>
                <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-0.5 rounded-full text-xs font-medium">${count}</span>
            `;
            hazardList.appendChild(li);
        });
    }
}

// Fetch recent activity
function refreshRecentActivity() {
    fetch('/dashboard/recent-activity')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('recentActivityBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" colspan="4">
                            No recent activity found
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';

                // Determine badge class based on classification
                let badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                if (['visitor close', 'user interacting with animal', 'unusual behavior'].includes(item.classification.toLowerCase())) {
                    badgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                } else if (['aggressive', 'attacking', 'cage scratching', 'restricted zone', 'animal escape attempt'].includes(item.classification.toLowerCase())) {
                    badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                }

                row.innerHTML = `
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-3">
                                <i class="bi bi-paw-fill text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            ${item.animal_name}
                        </div>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center">
                            <i class="bi bi-camera text-purple-500 mr-2"></i>
                            ${item.camera}
                        </div>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${badgeClass}">
                            ${item.classification}
                        </span>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${formatTimeAgo(item.created_at)}
                    </td>
                `;

                tbody.appendChild(row);
            });

            performanceTracker.mark('recentActivity');
        })
        .catch(error => {
            console.error('Error fetching recent activity:', error);
        });
}

// Fetch system status
function refreshSystemStatus() {
    fetch('/dashboard/system-status')
        .then(response => response.json())
        .then(data => {
            // Update connection status bar
            const statusBar = document.getElementById('connectionStatus');
            if (data.firebase && data.detection_engine) {
                statusBar.className = 'relative top-0 left-0 right-0 z-40 bg-green-500 text-white text-center py-2 text-sm font-medium transition-all duration-300 mb-4 rounded-lg mx-4';
                statusBar.innerHTML = '<span><i class="bi bi-check-circle me-1"></i>System Online: Real-time monitoring active</span>';
            } else {
                statusBar.className = 'relative top-0 left-0 right-0 z-40 bg-red-500 text-white text-center py-2 text-sm font-medium transition-all duration-300 mb-4 rounded-lg mx-4';
                statusBar.innerHTML = '<span><i class="bi bi-exclamation-triangle me-1"></i>System Issue Detected: Check status below</span>';
            }

            // Update system status panel
            const firebaseStatus = document.getElementById('firebaseStatus');
            firebaseStatus.textContent = data.firebase ? 'Connected' : 'Disconnected';
            firebaseStatus.parentElement.parentElement.querySelector('div:first-child').className = data.firebase 
                ? 'bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3' 
                : 'bg-red-100 dark:bg-red-900/30 p-3 rounded-full mr-3';
            firebaseStatus.parentElement.parentElement.querySelector('div:first-child i').className = data.firebase 
                ? 'bi bi-database text-green-600 dark:text-green-400' 
                : 'bi bi-database-x text-red-600 dark:text-red-400';

            const cameraStatus = document.getElementById('cameraStatus');
            cameraStatus.textContent = data.cameras > 0 ? `${data.cameras} active` : 'None active';
            cameraStatus.parentElement.parentElement.querySelector('div:first-child').className = data.cameras > 0 
                ? 'bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3' 
                : 'bg-yellow-100 dark:bg-yellow-900/30 p-3 rounded-full mr-3';
            cameraStatus.parentElement.parentElement.querySelector('div:first-child i').className = data.cameras > 0 
                ? 'bi bi-camera-video text-green-600 dark:text-green-400' 
                : 'bi bi-camera-video-off text-yellow-600 dark:text-yellow-400';

            const detectionEngineStatus = document.getElementById('detectionEngineStatus');
            detectionEngineStatus.textContent = data.detection_engine ? 'Processing' : 'Inactive';
            detectionEngineStatus.parentElement.parentElement.querySelector('div:first-child').className = data.detection_engine 
                ? 'bg-green-100 dark:bg-green-900/30 p-3 rounded-full mr-3' 
                : 'bg-red-100 dark:bg-red-900/30 p-3 rounded-full mr-3';
            detectionEngineStatus.parentElement.parentElement.querySelector('div:first-child i').className = data.detection_engine 
                ? 'bi bi-cpu text-green-600 dark:text-green-400' 
                : 'bi bi-cpu text-red-600 dark:text-red-400';

            performanceTracker.mark('systemStatus');
        })
        .catch(error => {
            console.error('Error fetching system status:', error);
        });
}

// Helper function to format time
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (isNaN(seconds)) {
        return 'Invalid date';
    }

    if (seconds < 60) {
        return 'just now';
    }

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) {
        return `${minutes}m ago`;
    }

    const hours = Math.floor(minutes / 60);
    if (hours < 24) {
        return `${hours}h ago`;
    }

    const days = Math.floor(hours / 24);
    if (days < 7) {
        return `${days}d ago`;
    }

    return date.toLocaleDateString();
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all data fetching
    refreshAll();

    // Add event listener for refresh button
    document.getElementById('refreshBtn').addEventListener('click', refreshAll);

    // Add event listener for trend filter
    document.getElementById('trendFilter').addEventListener('change', refreshTrends);

    // Accordion behavior for category lists
    document.querySelectorAll('[data-accordion-target]').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-accordion-target');
            const targetElement = document.querySelector(targetId);

            if (targetElement.style.maxHeight) {
                targetElement.style.maxHeight = null;
                this.querySelector('i.bi').classList.remove('bi-chevron-up');
                this.querySelector('i.bi').classList.add('bi-chevron-down');
            } else {
                targetElement.style.maxHeight = targetElement.scrollHeight + 'px';
                this.querySelector('i.bi').classList.remove('bi-chevron-down');
                this.querySelector('i.bi').classList.add('bi-chevron-up');
            }
        });
    });

    // Auto refresh every 60 seconds
    setInterval(refreshAll, 60000);
});