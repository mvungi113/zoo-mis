<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <h1 class="text-3xl font-bold mb-4 md:mb-0 text-gray-900 dark:text-gray-100">
                        <i class="bi bi-clipboard-data me-2 text-blue-600"></i>Animal Behavior Reports
                    </h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('export'), ['export' => 'pdf'])) }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide hover:from-red-500 hover:to-red-600 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="bi bi-file-pdf me-2"></i>Export PDF
                        </a>
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('export'), ['export' => 'csv'])) }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide hover:from-green-500 hover:to-green-600 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="bi bi-filetype-csv me-2"></i>Export CSV
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-8">
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label for="behavior" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                            <i class="bi bi-funnel me-2 text-indigo-600"></i>Filter by Behavior:
                        </label>
                        <select name="behavior" id="behavior" onchange="this.form.submit()"
                                class="w-full md:w-1/3 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3 px-4 transition-all duration-200">
                            <option value="">All Behaviors</option>
                            @foreach($behaviors as $behavior)
                                <option value="{{ $behavior }}" {{ request('behavior') == $behavior ? 'selected' : '' }}>
                                    {{ ucfirst($behavior) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="overflow-x-auto rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-hash me-2"></i>ID
                                </th>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-paw me-2 text-amber-600"></i>Animal
                                </th>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-camera-video me-2 text-purple-600"></i>Camera
                                </th>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-activity me-2 text-blue-600"></i>Behavior
                                </th>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-speedometer2 me-2 text-green-600"></i>Confidence
                                </th>
                                <th class="px-6 py-4 text-left font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider text-xs border-b-2 border-gray-300 dark:border-gray-600">
                                    <i class="bi bi-clock me-2 text-gray-600"></i>Created At
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($reports as $report)
                                <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 dark:hover:from-gray-900 dark:hover:to-gray-800 transition-all duration-200 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-850' : 'bg-white dark:bg-gray-800' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            {{ $report->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        <i class="bi bi-dot text-green-500 me-1"></i>{{ $report->animal_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <span class="inline-flex items-center">
                                            <i class="bi bi-camera text-purple-500 me-2"></i>{{ $report->camera }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 text-blue-800 dark:text-blue-200 font-semibold shadow-sm">
                                            <i class="bi bi-tag me-2"></i>{{ $report->classification }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center">
                                            <i class="bi bi-graph-up text-green-500 me-2"></i>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $report->confidence }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="bi bi-calendar3 me-2"></i>{{ $report->created_at }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                            <i class="bi bi-inbox text-4xl mb-4 text-gray-300"></i>
                                            <h3 class="text-lg font-medium mb-2">No reports found</h3>
                                            <p class="text-sm">Try adjusting your filters or check back later.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($reports->hasPages())
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between">
                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300 mb-4 sm:mb-0">
                            <i class="bi bi-info-circle me-2 text-blue-500"></i>
                            Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $reports->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>