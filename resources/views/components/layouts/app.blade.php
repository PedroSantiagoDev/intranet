<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" class="dark">
    <head>
        @include("partials.head")
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
            <x-layouts.navigation.app />

            <main>
                <div class="py-4">
                    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        @livewireScripts
        @filamentScripts
    </body>
</html>
