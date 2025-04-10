@props([
    'url',
    'icon',
    'title',
    'target' => '_blank'
])

<a href="{{ $url }}" target="{{ $target }}" class="block">
    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-950 shadow-sm transition-all duration-200 hover:bg-gray-50 dark:hover:bg-white/5">
        <div class="flex gap-2 items-center">
            @svg($icon, 'w-6 h-6')
            <span class="font-medium">{{ $title }}</span>
        </div>
    </div>
</a>