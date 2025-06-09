<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route("home") }}">
                    <span class="flex w-44 items-center justify-center rounded-md">
                        <x-app-logo />
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            @if (Route::has("login"))
                <div class="hidden sm:flex sm:items-center sm:justify-end sm:gap-2">
                    <!-- Theme Switch -->
                    <livewire:theme-switch />

                    @auth
                        <!-- Dashboard Link -->
                        <a
                            href="{{ url("/dashboard") }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors duration-200"
                        >
                            <x-filament::icon icon="heroicon-m-squares-2x2" class="h-4 w-4 mr-2" />
                            Dashboard
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ userOpen: false }">
                            <button
                                @click="userOpen = !userOpen"
                                @click.away="userOpen = false"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                            >
                                <x-filament::icon icon="heroicon-m-user-circle" class="h-5 w-5 mr-2" />
                                <span class="hidden md:inline">{{ auth()->user()->name ?? "Usuário" }}</span>
                                <x-filament::icon icon="heroicon-m-chevron-down" class="h-4 w-4 ml-1" />
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                x-show="userOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700"
                                style="display: none"
                            >
                                <a
                                    href="{{ route("profile") ?? "#" }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <x-filament::icon icon="heroicon-m-user" class="h-4 w-4 mr-2" />
                                    Perfil
                                </a>

                                @if (auth()->user()->hasRole("admin") ?? false)
                                    <a href="/admin" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <x-filament::icon icon="heroicon-m-shield-check" class="h-4 w-4 mr-2" />
                                        Admin
                                    </a>
                                @endif

                                <div class="border-t border-gray-100 dark:border-gray-600"></div>

                                <form method="POST" action="{{ route("logout") }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-left"
                                    >
                                        <x-filament::icon icon="heroicon-m-arrow-left-start-on-rectangle" class="h-4 w-4 mr-2" />
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Login Link -->
                        <a
                            href="{{ route("login") }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors duration-200"
                        >
                            <x-filament::icon icon="heroicon-m-arrow-right-end-on-rectangle" class="h-4 w-4 mr-2" />
                            {{ __("Entrar") }}
                        </a>

                        @if (Route::has("register"))
                            <!-- Register Link -->
                            <a
                                href="{{ route("register") }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-md transition-colors duration-200"
                            >
                                <x-filament::icon icon="heroicon-m-user-plus" class="h-4 w-4 mr-2" />
                                {{ __("Registrar") }}
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 focus:text-gray-500 dark:focus:text-gray-200 transition duration-200 ease-in-out"
                        aria-label="Toggle mobile menu"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{'hidden': open, 'inline-flex': !open}"
                                class="inline-flex"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{'hidden': !open, 'inline-flex': open}"
                                class="hidden"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden transition-all duration-300 ease-in-out">
        @auth
            <!-- User Info Section -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                <div class="px-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <x-filament::icon icon="heroicon-m-user" class="h-6 w-6 text-gray-600 dark:text-gray-300" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200 truncate">
                                {{ auth()->user()->name ?? "Usuário" }}
                            </div>
                            <div class="font-medium text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ auth()->user()->email ?? "" }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-900">
                <!-- Dashboard -->
                <a
                    href="{{ url("/dashboard") }}"
                    class="flex items-center px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                >
                    <x-filament::icon icon="heroicon-m-squares-2x2" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                    Dashboard
                </a>

                <!-- Profile -->
                <a
                    href="{{ route("profile") ?? "#" }}"
                    class="flex items-center px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                >
                    <x-filament::icon icon="heroicon-m-user" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                    Perfil
                </a>

                @if (auth()->user()->hasRole("admin") ?? false)
                    <!-- Admin -->
                    <a
                        href="/admin"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <x-filament::icon icon="heroicon-m-shield-check" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                        Admin
                    </a>
                @endif

                <!-- Theme Switch Mobile -->
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-200 flex items-center">
                            <x-filament::icon icon="heroicon-m-swatch" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                            Tema
                        </span>
                        <div class="scale-90">
                            <livewire:theme-switch />
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route("logout") }}" class="w-full">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center w-full px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 text-left"
                    >
                        <x-filament::icon icon="heroicon-m-arrow-left-start-on-rectangle" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                        Sair
                    </button>
                </form>
            </div>
        @else
            <!-- Guest Navigation -->
            <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-900">
                <!-- Theme Switch Mobile -->
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-200 flex items-center">
                            <x-filament::icon icon="heroicon-m-swatch" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                            Tema
                        </span>
                        <div class="scale-90">
                            <livewire:theme-switch />
                        </div>
                    </div>
                </div>

                <!-- Login -->
                <a
                    href="{{ route("login") }}"
                    class="flex items-center px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                >
                    <x-filament::icon icon="heroicon-m-arrow-right-end-on-rectangle" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400" />
                    {{ __("Entrar") }}
                </a>

                @if (Route::has("register"))
                    <!-- Register -->
                    <a
                        href="{{ route("register") }}"
                        class="flex items-center px-4 py-3 text-base font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200"
                    >
                        <x-filament::icon icon="heroicon-m-user-plus" class="h-5 w-5 mr-3" />
                        {{ __("Registrar") }}
                    </a>
                @endif
            </div>
        @endauth
    </div>
</nav>
