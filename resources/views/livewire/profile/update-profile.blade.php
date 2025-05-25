<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __("Profile Information") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        {{ $this->form }}

        <div class="flex items-center gap-4">
            <x-filament::button type="submit">
                {{ __("Save") }}
            </x-filament::button>
        </div>
    </form>
</section>
