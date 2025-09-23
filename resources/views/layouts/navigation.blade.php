<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-slate-700 to-teal-700 dark:from-gray-800 dark:to-indigo-900 border-b border-emerald-500 dark:border-indigo-500 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="text-2xl font-bold bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-indigo-400 dark:to-purple-500 bg-clip-text text-transparent">
                        ByteBarber
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-gray-50 hover:text-emerald-300 dark:hover:text-indigo-300 transition-colors duration-200">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            <!-- Theme Toggle and Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-50 bg-teal-600 dark:bg-indigo-600 hover:bg-emerald-700 dark:hover:bg-indigo-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')"
                                class="text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-indigo-800">
                                Profile
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-indigo-800">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Theme Toggle Mobile -->
                <div class="mr-2">
                    <x-theme-toggle />
                </div>

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-emerald-400 dark:text-indigo-400 hover:text-emerald-500 dark:hover:text-indigo-300 hover:bg-slate-200 dark:hover:bg-indigo-800 focus:outline-none focus:bg-slate-200 dark:focus:bg-indigo-800 focus:text-emerald-500 dark:focus:text-indigo-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden bg-gradient-to-r from-slate-600 to-teal-700 dark:from-gray-700 dark:to-indigo-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="text-gray-50 hover:text-emerald-300 dark:hover:text-indigo-300">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-400 dark:border-indigo-500">
            <div class="px-4">
                <div class="font-medium text-base text-gray-50">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-emerald-300 dark:text-indigo-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="text-gray-50 hover:text-emerald-300 dark:hover:text-indigo-300">
                    Profile
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-gray-50 hover:text-emerald-300 dark:hover:text-indigo-300">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>