<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("partials.head")
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
            <x-layouts.navigation.guest />

            <main>
                <div class="py-4">
                    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        @livewire("notifications")
        @livewireScripts
        @filamentScripts
    </body>
</html>
