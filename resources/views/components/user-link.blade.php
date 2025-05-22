@props([
    "title",
    "url",
])

<a href="{{ $url }}" class="block" target="_blank">
    <div
        class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 group"
    >
        <x-filament::icon
            icon="heroicon-m-link"
            class="h-5 w-5 text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors flex-shrink-0"
        />
        <h2 class="font-semibold group-hover:scale-105 transition-transform">{{ $title }}</h2>
    </div>
</a>
