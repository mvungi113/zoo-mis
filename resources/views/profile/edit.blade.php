<x-app-layout>
 

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Editable Profile Information Section -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-6 text-gray-800 dark:text-gray-100">Edit Profile Information</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="first_name">First Name</label>
                            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', Auth::user()->first_name) }}"
                                class="p-2 bg-gray-50 dark:bg-gray-900 rounded text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200" required>
                            @error('first_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="last_name">Last Name</label>
                            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', Auth::user()->last_name) }}"
                                class="p-2 bg-gray-50 dark:bg-gray-900 rounded text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200" required>
                            @error('last_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="username">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username', Auth::user()->username) }}"
                                class="p-2 bg-gray-50 dark:bg-gray-900 rounded text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200" required>
                            @error('username')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}"
                                class="p-2 bg-gray-50 dark:bg-gray-900 rounded text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200" required>
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded font-semibold hover:bg-indigo-500 transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Editable Profile Information Section -->

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
