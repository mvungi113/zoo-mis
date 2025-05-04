<x-guest-layout>
    <!-- Centering the form -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Email Password Reset Link Button -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="bg-purple-600 hover:bg-purple-700 focus:ring-purple-500">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Centered Back to Login Link -->
            <div class="flex items-center justify-center mt-4">
                @if (Route::has('login'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Already have an account? Log in here') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>