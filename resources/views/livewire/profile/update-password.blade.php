<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __("Update Password") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        {{ $this->form }}

        <div class="flex items-center gap-4">
            <x-filament::button type="submit">
                {{ __("Save") }}
            </x-filament::button>
        </div>
    </form>
</section>
