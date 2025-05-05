<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Behavior Notifications') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
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
                        <tr class="border-b border-gray-200 dark:border-gray-600 text-sm">
                            <td class="px-4 py-2">{{ $note['timestamp'] }}</td>
                            <td class="px-4 py-2">{{ $note['animal_name'] }}</td>
                            <td class="px-4 py-2">{{ $note['camera'] }}</td>
                            <td class="px-4 py-2">{{ $note['classification'] }}</td>
                            <td class="px-4 py-2">{{ $note['type'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">No notifications found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
