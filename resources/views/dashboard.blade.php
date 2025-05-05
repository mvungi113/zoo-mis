<x-app-layout>


    <div class="bg-white dark:bg-gray-800 py-8 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
        <div class="flex flex-col items-center">
            <h3 class="font-bold mb-2">Normal Situations</h3>
            <div class="w-[250px] h-[250px]">
                <canvas id="normalChart" width="250" height="250"></canvas>
            </div>
        </div>
        <div class="flex flex-col items-center">
            <h3 class="font-bold mb-2">Warning Situations</h3>
            <div class="w-[250px] h-[250px]">
                <canvas id="warningChart" width="250" height="250"></canvas>
            </div>
        </div>
        <div class="flex flex-col items-center">
            <h3 class="font-bold mb-2">Hazard Situations</h3>
            <div class="w-[250px] h-[250px]">
                <canvas id="hazardChart" width="250" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Add summary chart in another row if necessary -->
    <div class="py-8 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-1 gap-6 px-4">
        <div class="flex flex-col items-center">
            <h3 class="font-bold mb-2">Overall Summary</h3>
            <div class="w-[250px] h-[250px]">
                <canvas id="summaryChart" width="250" height="250"></canvas>
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
