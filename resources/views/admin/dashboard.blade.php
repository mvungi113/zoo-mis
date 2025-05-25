<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto space-y-8">
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

        function fetchCharts() {
            fetch('/dashboard/charts')
                .then(res => res.json())
                .then(data => {
                    renderChart('normalChart', data.normal, 'Normal Situations');
                    renderChart('warningChart', data.warning, 'Warning Situations');
                    renderChart('hazardChart', data.hazard, 'Hazard Situations');
                    renderChart('summaryChart', data.summary, 'Overall Summary');
                });
        }

        fetchCharts();
        setInterval(fetchCharts, 5000); // Auto-refresh every 5 seconds
    </script>
</x-app-layout>
