<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        {{ $this->form }}

        @if ($errors->any())
            <div class="text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="flex items-center justify-end">
            <x-filament::button type="submit" class="w-full">
                {{ __("Log in") }}
            </x-filament::button>
        </div>
    </form>

    @if (Route::has("register"))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <x-filament::link :href="route('register')" wire:navigate>{{ __("Sign up") }}</x-filament::link>
        </div>
    @endif

    <x-filament-actions::modals />
</div>
