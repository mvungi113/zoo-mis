<nav x-data="{ open: false, manageUserOpen: false }" class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-40 transition-all duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center transition-transform duration-200 hover:scale-105">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <span class="ml-2 text-lg font-semibold text-indigo-600 dark:text-indigo-400">ZooMIS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                    <x-nav-link 
                        :href="route('admin.dashboard')" 
                        :active="request()->routeIs('admin.dashboard')"
                        class="flex items-center px-3"
                    >
                        <i class="bi bi-speedometer2 mr-1.5 text-gray-500 dark:text-gray-400"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')" class="flex items-center px-3">
                        <i class="bi bi-journal-text mr-1.5 text-gray-500 dark:text-gray-400"></i>
                        {{ __('Logs') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="flex items-center px-3">
                        <i class="bi bi-bell mr-1.5 text-gray-500 dark:text-gray-400"></i>
                        {{ __('Notifications') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <!-- Manage User Dropdown -->
                        <div class="relative flex items-center h-full" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                @keydown.escape="open = false"
                                type="button"
                                class="inline-flex items-center h-full px-3 border-b-2 border-transparent text-sm leading-5 font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out"
                                :class="{'border-indigo-400 text-gray-900 dark:text-gray-100 focus:border-indigo-700': open}"
                            >
                                <i class="bi bi-people mr-1.5"></i>
                                {{ __('Manage User') }}
                                <svg class="ml-1.5 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute top-full left-0 z-50 mt-1 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700"
                                style="display: none;"
                            >
                                <div class="py-1">
                                    <a href="{{ route('admin.users.manage') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700">
                                        <i class="bi bi-people-fill mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                        {{ __('Manage Users') }}
                                    </a>
                                    <a href="{{ route('admin.users.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700">
                                        <i class="bi bi-person-plus mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                        {{ __('Register User') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex items-center px-3">
                            <i class="bi bi-file-earmark-bar-graph mr-1.5 text-gray-500 dark:text-gray-400"></i>
                            {{ __('Reports') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-200 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:border-indigo-300 dark:focus:border-indigo-600 transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <div class="h-7 w-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-2 text-indigo-600 dark:text-indigo-400">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>{{ Auth::user()->username }}</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Signed in as</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <i class="bi bi-person-gear mr-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="bi bi-box-arrow-right mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center">
                <i class="bi bi-speedometer2 mr-2 text-indigo-600 dark:text-indigo-400"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')" class="flex items-center">
                <i class="bi bi-journal-text mr-2 text-indigo-600 dark:text-indigo-400"></i>
                {{ __('Logs') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="flex items-center">
                <i class="bi bi-bell mr-2 text-indigo-600 dark:text-indigo-400"></i>
                {{ __('Notifications') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <div class="border-l-4 border-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-3 py-2 text-sm font-medium text-indigo-700 dark:text-indigo-300">
                    <span class="flex items-center">
                        <i class="bi bi-people-fill mr-2"></i>
                        {{ __('Admin Options') }}
                    </span>
                </div>
                
                <x-responsive-nav-link :href="route('admin.users.manage')" :active="request()->routeIs('users.index')" class="flex items-center pl-6">
                    <i class="bi bi-people mr-2 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('Manage Users') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.users.create')" :active="request()->routeIs('register')" class="flex items-center pl-6">
                    <i class="bi bi-person-plus mr-2 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('Register User') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex items-center">
                    <i class="bi bi-file-earmark-bar-graph mr-2 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('Reports') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg mx-2 my-2">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-3 text-indigo-600 dark:text-indigo-400">
                        <i class="bi bi-person-fill text-xl"></i>
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
                        <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center">
                    <i class="bi bi-person-gear mr-2 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center text-red-600 dark:text-red-400">
                        <i class="bi bi-box-arrow-right mr-2"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
