<x-guest-layout>
    <!-- Enhanced Background with Floating Elements -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/40 dark:to-indigo-900/40 flex items-center justify-center p-6 relative">
        <!-- Floating Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 -right-40 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-8 left-20 w-80 h-80 bg-blue-200/30 dark:bg-blue-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-200/20 dark:bg-indigo-900/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Login Card -->
        <div class="w-full sm:max-w-md relative z-10">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-3">
                    <div class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                        Zoo Intelligence
                    </span>
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Sign in to access your dashboard</p>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-xl overflow-hidden transition-all duration-300">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 flex items-center justify-center">
                    <h2 class="text-white font-semibold text-lg">Welcome Back</h2>
                </div>
                
                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Login: Username or Email -->
                        <div>
                            <x-input-label for="login" :value="__('Email or Username')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="bi bi-person text-gray-400"></i>
                                </div>
                                <x-text-input 
                                    id="login" 
                                    class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500" 
                                    type="text" 
                                    name="login" 
                                    :value="old('login')" 
                                    required 
                                    autofocus 
                                    autocomplete="username" 
                                />
                            </div>
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-6">
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="bi bi-lock text-gray-400"></i>
                                </div>
                                <x-text-input 
                                    id="password" 
                                    class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-500 dark:focus:border-indigo-500" 
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="current-password" 
                                />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-6">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <!-- Log In Button -->
                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <i class="bi bi-box-arrow-in-right mr-2"></i>
                                {{ __('Sign In') }}
                            </button>
                        </div>

                        <!-- Forgot Password -->
                        <div class="flex items-center justify-center mt-6">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 focus:outline-none focus:underline transition-colors duration-200" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-8">
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
