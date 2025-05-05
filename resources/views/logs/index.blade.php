<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Detection Logs</h3>

                    @if($logs->isEmpty())
                        <p>No logs found.</p>
                    @else
                        <div id="logs-table">
                            @include('logs.partials.table', ['logs' => $logs])
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to refresh the logs table every 5 seconds
        function refreshLogsTable() {
            fetch("{{ route('logs.table') }}")
                .then(response => response.text())
                .then(html => {
                    document.getElementById('logs-table').innerHTML = html;
                });
        }

        // Set an interval to refresh the logs table every 5 seconds (adjust as needed)
        setInterval(refreshLogsTable, 5000); // Refresh every 5 seconds
    </script>
</x-app-layout>
