<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 sm:px-2 lg:px-4">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 min-h-[70vh]">
            <h1 class="text-2xl font-bold mb-6 text-center">Manage Users</h1>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.users.manage') }}" class="mb-6 flex flex-col space-y-4">
                <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-200">From</label>
                        <input type="date" id="from" name="from" value="{{ request('from') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                    </div>
                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-200">To</label>
                        <input type="date" id="to" name="to" value="{{ request('to') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                            <option value="">All</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="security" {{ request('role') == 'security' ? 'selected' : '' }}>Security Personnel</option>
                        </select>
                    </div>
                    <div class="flex flex-col w-full md:w-auto">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 invisible h-0">Apply</label>
                        <button type="submit" class="inline-flex items-center px-3 h-10 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition mt-1">
                            Apply
                        </button>
                    </div>
                    <div class="flex flex-col w-full">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 invisible h-0">Export</label>
                        <div class="flex space-x-2 mt-1">
                            <a href="{{ route('admin.users.export', array_merge(request()->all(), ['type' => 'pdf'])) }}"
                                class="inline-flex items-center px-3 h-10 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                                Export PDF
                            </a>
                            <a href="{{ route('admin.users.export', array_merge(request()->all(), ['type' => 'csv'])) }}"
                                class="inline-flex items-center px-3 h-10 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition">
                                Export CSV
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">#</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Name</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Username</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Email</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Role</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-indigo-50 dark:hover:bg-gray-900 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-800' : '' }}">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="px-4 py-2">{{ $user->username }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                                <td class="px-4 py-2 flex space-x-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>