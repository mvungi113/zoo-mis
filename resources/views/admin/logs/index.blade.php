<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 md:mb-0">Detection Logs</h3>
                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <div class="flex space-x-2">
                            <a href="{{ route('logs.export', array_merge(request()->all(), ['type' => 'pdf'])) }}"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-red-500 transition">
                                Export PDF
                            </a>
                            <a href="{{ route('logs.export', array_merge(request()->all(), ['type' => 'csv'])) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-green-500 transition">
                                Export CSV
                            </a>
                        </div>
                    @endif
                </div>

                <form method="GET" action="{{ route('logs.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-200">From</label>
                        <input type="date" id="from" name="from" value="{{ request('from') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-200">To</label>
                        <input type="date" id="to" name="to" value="{{ request('to') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 w-auto">
                            Apply
                        </button>
                    </div>
                </form>

                @if($logs->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                        <svg class="mx-auto mb-2 w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20" stroke-width="4" stroke-dasharray="4 2"/>
                        </svg>
                        <p class="text-lg">No logs found.</p>
                    </div>
                @else
                    <div id="logs-table" class="overflow-x-auto rounded-lg shadow">
                        @include('logs.partials.table', ['logs' => $logs])
                    </div>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @endif
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
        setInterval(refreshLogsTable, 5000);
    </script>
</x-app-layout>
