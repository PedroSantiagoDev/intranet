<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
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

            <!-- Auth Navigation -->
            @if (Route::has("login"))
                <nav class="flex items-center justify-end gap-2">
                    <!-- Theme Switch -->
                    <livewire:theme-switch />

                    @auth
                        <a
                            href="{{ url("/dashboard") }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>

                        <form method="POST" action="{{ route("logout") }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                            >
                                Log out
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route("login") }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            {{ __("Log in") }}
                        </a>

                        @if (Route::has("register"))
                            <a
                                href="{{ route("register") }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                            >
                                {{ __("Register") }}
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</nav>
