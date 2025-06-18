<x-app-layout>
    <!-- Enhanced Background with Floating Elements -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 relative py-12">
        <!-- Floating Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-purple-200 to-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob dark:from-blue-900 dark:to-purple-900"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-gradient-to-br from-blue-200 to-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 dark:from-indigo-900 dark:to-purple-900"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Page Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                        Your Profile
                    </span>
                </h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Manage your account information and security settings</p>
            </div>

            <!-- Editable Profile Information Section -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 p-4 flex items-center">
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-full mr-3">
                        <i class="bi bi-person text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">User Information</h3>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="first_name">
                                    First Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="bi bi-person-badge text-gray-400"></i>
                                    </div>
                                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name', Auth::user()->first_name) }}"
                                        class="pl-10 p-2.5 bg-gray-50 dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500 transition-all duration-200" 
                                        required>
                                </div>
                                @error('first_name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="last_name">
                                    Last Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="bi bi-person-badge text-gray-400"></i>
                                    </div>
                                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name', Auth::user()->last_name) }}"
                                        class="pl-10 p-2.5 bg-gray-50 dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500 transition-all duration-200" 
                                        required>
                                </div>
                                @error('last_name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="username">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="bi bi-at text-gray-400"></i>
                                    </div>
                                    <input id="username" name="username" type="text" value="{{ old('username', Auth::user()->username) }}"
                                        class="pl-10 p-2.5 bg-gray-50 dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500 transition-all duration-200" 
                                        required>
                                </div>
                                @error('username')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1" for="email">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="bi bi-envelope text-gray-400"></i>
                                    </div>
                                    <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}"
                                        class="pl-10 p-2.5 bg-gray-50 dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-100 w-full border border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500 transition-all duration-200" 
                                        required>
                                </div>
                                @error('email')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit"
                                class="flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                                <i class="bi bi-check2-circle mr-2"></i>
                                Save Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 p-4 flex items-center">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-full mr-3">
                        <i class="bi bi-shield-lock text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Security Settings</h3>
                </div>
                
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Deletion Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 p-4 flex items-center">
                    <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-full mr-3">
                        <i class="bi bi-exclamation-triangle text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Danger Zone</h3>
                </div>
                
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
