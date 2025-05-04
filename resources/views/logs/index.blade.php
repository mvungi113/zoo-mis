<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Zoo Surveillance Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Detection Logs</h3>

                    @if($logs->isEmpty())
                        <p>No logs found.</p>
                    @else
                        <table class="table-auto w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">Timestamp</th>
                                    <th class="px-4 py-2 border">Animal</th>
                                    <th class="px-4 py-2 border">Confidence (%)</th>
                                    <th class="px-4 py-2 border">Status</th>
                                    <th class="px-4 py-2 border">Camera</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $log['created_at'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $log['animal_name'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $log['confidence'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $log['classification'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $log['camera'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- pagenation --}}
                        <div class="mt-4">

                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
