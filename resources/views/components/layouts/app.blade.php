<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
            <x-layouts.navigations.app-navigation />

            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        @filamentScripts
    </body>
</html>
