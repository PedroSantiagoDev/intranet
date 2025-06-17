@props([
    "type" => "info",
    "title" => null,
    "content" => "",
    "class" => "",
])

@php
    $isAlert = $type === "alert";

    $baseClasses = "flex items-start gap-3 p-4 px-12 rounded-lg border";

    $typeClasses = $isAlert
        ? "bg-red-50 dark:bg-red-950/50 border-red-200 dark:border-red-800 text-red-800 dark:text-red-200"
        : "bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200";

    $iconClasses = $isAlert ? "text-red-500 dark:text-red-400" : "text-blue-500 dark:text-blue-400";

    $titleClasses = $isAlert ? "text-red-900 dark:text-red-100" : "text-blue-900 dark:text-blue-100";

    $iconName = $isAlert ? "alert-triangle" : "info";
@endphp

<div {{ $attributes->merge(["class" => $baseClasses . " " . $typeClasses . " " . $class]) }}>
    @if ($isAlert)
        <svg class="h-6 w-6 mt-0.5 flex-shrink-0 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
            />
        </svg>
    @else
        <svg class="h-6 w-6 mt-0.5 flex-shrink-0 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @endif

    <div class="flex-1">
        @if ($title)
            <h4 class="font-medium mb-1 {{ $titleClasses }}">
                {{ $title }}
            </h4>
        @endif

        <p class="text-sm leading-relaxed">
            {{ $content }}
        </p>
    </div>
</div>
