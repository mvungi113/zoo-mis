<x-guest-layout>
    <!-- Enhanced Background with Floating Elements -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/40 dark:to-indigo-900/40 flex items-center justify-center p-6 relative">
        <!-- Floating Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 -right-40 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-8 left-20 w-80 h-80 bg-blue-200/30 dark:bg-blue-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-200/20 dark:bg-indigo-900/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Password Reset Card -->
        <div class="w-full sm:max-w-md relative z-10">
            <!-- Logo/Brand -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-3">
                    <div class="h-14 w-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                        Reset Your Password
                    </span>
                </h1>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-xl overflow-hidden transition-all duration-300">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-3 flex items-center">
                    <div class="bg-white/20 p-1.5 rounded-full mr-3">
                        <i class="bi bi-envelope text-white text-sm"></i>
                    </div>
                    <h2 class="text-white font-medium">Password Recovery</h2>
                </div>
                
                <div class="px-6 py-6">
                    <div class="mb-5 text-sm text-gray-600 dark:text-gray-300 bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg border border-indigo-100 dark:border-indigo-800/30">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="bi bi-envelope text-gray-400"></i>
                                </div>
                                <x-text-input 
                                    id="email" 
                                    class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autofocus 
                                />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <i class="bi bi-envelope-arrow-up mr-2"></i>
                                {{ __('Email Password Reset Link') }}
                            </button>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="flex items-center justify-center mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <a href="{{ route('login') }}" class="flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors duration-200">
                            <i class="bi bi-arrow-left mr-2"></i>
                            {{ __('Back to Login') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} Zoo Intelligence System. All rights reserved.</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</x-guest-layout>