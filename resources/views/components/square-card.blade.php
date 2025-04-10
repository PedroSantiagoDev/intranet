@props([
    'url',
    'icon',
    'title',
    'target' => '_blank'
])

<a href="{{ $url }}" target="{{ $target }}" class="block">
    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-300">
        <div class="flex gap-2 items-center">
            @svg($icon, 'w-6 h-6 text-primary-500')
            <span class="font-medium">{{ $title }}</span>
        </div>
    </div>
</a>