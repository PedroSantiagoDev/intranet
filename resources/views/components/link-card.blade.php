@props(['url', 'title', 'target' => '_blank'])

<a href="{{ $url }}" target="{{ $target }}" class="block h-full">
    <div
        class="
            p-3 rounded-lg border border-gray-200 dark:border-gray-600 
            bg-white dark:bg-gray-950 shadow-sm transition-all duration-200 hover:bg-gray-100 
            dark:hover:bg-white/5 hover:border-primary-200 dark:hover:border-primary-800 hover:shadow-md 
            h-full flex items-center justify-start flex-row gap-x-2
        ">
        @svg('heroicon-o-link', 'w-5 h-5 text-primary-500')
        <span class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $title }}</span>
    </div>
</a>
