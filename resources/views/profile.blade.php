<x-layouts.app>
    <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __("Profile") }}
    </h2>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <livewire:profile.update-profile />
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <livewire:profile.update-password />
        </div>
    </div>
</x-layouts.app>
