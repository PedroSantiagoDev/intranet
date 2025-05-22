@props([
    "title",
    "url",
    "icon",
])

<a href="{{ $url }}" target="_blank">
    <div
        class="flex flex-col items-center p-6 gap-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-wide shadow-md hover:shadow-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 group"
    >
        <x-filament::icon
            icon="heroicon-m-{{ $icon }}"
            class="h-8 w-8 text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors"
        />
        <h2 class="group-hover:scale-110 transition-transform">{{ $title }}</h2>
    </div>
</a>
