
@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h2 class="text-3xl font-bold mb-2 text-white">{{ $title }}</h1>
    <p class="text-sm text-gray-600">{{ $description }}</p>
</div>