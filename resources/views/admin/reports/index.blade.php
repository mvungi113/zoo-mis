<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl font-bold mb-4 md:mb-0 text-gray-800 dark:text-gray-100">Reports Page</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('export'), ['export' => 'pdf'])) }}"
                           class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-red-500 transition">
                            Export PDF
                        </a>
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('export'), ['export' => 'csv'])) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-green-500 transition">
                            Export CSV
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-6 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                    <div>
                        <label for="behavior" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Filter by Behavior:</label>
                        <select name="behavior" id="behavior" onchange="this.form.submit()"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                            <option value="">-- All Behaviors --</option>
                            @foreach($behaviors as $behavior)
                                <option value="{{ $behavior }}" {{ request('behavior') == $behavior ? 'selected' : '' }}>
                                    {{ ucfirst($behavior) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">ID</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Animal</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Camera</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Behavior</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Confidence</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($reports as $report)
                                <tr class="hover:bg-indigo-50 dark:hover:bg-gray-900 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-800' : '' }}">
                                    <td class="px-4 py-2">{{ $report->id }}</td>
                                    <td class="px-4 py-2">{{ $report->animal_name }}</td>
                                    <td class="px-4 py-2">{{ $report->camera }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-block px-2 py-1 rounded bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            {{ $report->classification }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $report->confidence }}</td>
                                    <td class="px-4 py-2">{{ $report->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center">No reports found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>