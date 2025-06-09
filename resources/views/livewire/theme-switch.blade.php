<div
    class="relative"
    x-data="{
        open: false,
        theme: '{{ $theme }}',
        loading: false,
        setTheme(newTheme) {
            this.loading = true
            this.theme = newTheme
            $wire.setTheme(newTheme).then(() => {
                this.loading = false
                this.open = false
            })
        },
    }"
>
    <!-- Compact Theme Button -->
    <button
        @click="open = !open"
        @click.away="open = false"
        class="group relative inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-label="Tema"
        :disabled="loading"
    >
        <!-- Loading -->
        <div x-show="loading" class="absolute inset-0 flex items-center justify-center">
            <svg class="animate-spin h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>

        <!-- Icons -->
        <div x-show="!loading" class="transition-transform duration-200 group-hover:scale-110">
            @if ($theme === "light")
                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"
                    />
                </svg>
            @elseif ($theme === "dark")
                <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"
                    />
                </svg>
            @else
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5z"
                    />
                </svg>
            @endif
        </div>
    </button>

    <!-- Compact Dropdown -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black/5 dark:ring-white/10 z-50 border border-gray-200 dark:border-gray-700"
        style="display: none"
        @keydown.escape="open = false"
    >
        <div class="py-1">
            <!-- System -->
            <button
                @click="setTheme('system')"
                :disabled="loading"
                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50"
                :class="{ 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300': theme === 'system' }"
            >
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5z"
                    />
                </svg>
                Sistema
            </button>

            <!-- Light -->
            <button
                @click="setTheme('light')"
                :disabled="loading"
                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50"
                :class="{ 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300': theme === 'light' }"
            >
                <svg class="w-4 h-4 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"
                    />
                </svg>
                Claro
            </button>

            <!-- Dark -->
            <button
                @click="setTheme('dark')"
                :disabled="loading"
                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50"
                :class="{ 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300': theme === 'dark' }"
            >
                <svg class="w-4 h-4 mr-2 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"
                    />
                </svg>
                Escuro
            </button>
        </div>
    </div>
</div>
<script>
    function initThemeManager() {
        const systemThemeMedia = window.matchMedia('(prefers-color-scheme: dark)');

        function handleSystemThemeChange(e) {
            if ('{{ $theme }}' === 'system') {
                applyTheme('system');
            }
        }

        function applyTheme(theme) {
            const htmlElement = document.documentElement;
            if (theme === 'system') {
                htmlElement.classList.toggle('dark', systemThemeMedia.matches);
            } else {
                htmlElement.classList.toggle('dark', theme === 'dark');
            }
        }

        applyTheme('{{ $theme }}');

        systemThemeMedia.addEventListener('change', handleSystemThemeChange);

        Livewire.on('theme-changed', (event) => {
            applyTheme(event.theme);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeManager);
    } else {
        initThemeManager();
    }

    document.addEventListener('livewire:navigated', () => {
        const systemThemeMedia = window.matchMedia('(prefers-color-scheme: dark)');
        systemThemeMedia.removeEventListener('change', handleSystemThemeChange);
        initThemeManager();
    });
</script>
