<x-app-layout>
  

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Recent Notifications</h3>
                {{-- You can add a filter or refresh button here if needed --}}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2">Time</th>
                            <th class="px-4 py-2">Animal</th>
                            <th class="px-4 py-2">Camera</th>
                            <th class="px-4 py-2">Classification</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $note)
                            <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-900' : '' }} border-b border-gray-200 dark:border-gray-700 text-sm">
                                <td class="px-4 py-2">{{ $note['timestamp'] }}</td>
                                <td class="px-4 py-2">{{ $note['animal_name'] }}</td>
                                <td class="px-4 py-2">{{ $note['camera'] }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $note['classification'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if(strtolower($note['type']) === 'alert')
                                        <span class="inline-block px-2 py-1 rounded bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 font-semibold">
                                            {{ ucfirst($note['type']) }}
                                        </span>
                                    @elseif(strtolower($note['type']) === 'info')
                                        <span class="inline-block px-2 py-1 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold">
                                            {{ ucfirst($note['type']) }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            {{ ucfirst($note['type']) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No notifications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
