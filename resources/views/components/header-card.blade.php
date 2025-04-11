@props(['url', 'icon', 'title', 'target' => '_blank'])

<a href="{{ $url }}" target="{{ $target }}" class="block h-full">
    <div
        class="p-4 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-950 shadow-sm transition-all duration-200 hover:bg-gray-100 dark:hover:bg-white/5 hover:border-primary-200 dark:hover:border-primary-800 hover:shadow-md h-full flex items-center justify-center flex-col text-center">
        <div class="mb-2">
            @svg($icon, 'w-7 h-7 text-primary-500')
        </div>
        <span class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $title }}</span>
    </div>
</a>
