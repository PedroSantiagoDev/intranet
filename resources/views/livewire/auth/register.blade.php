<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

   <form wire:submit="register" class="flex flex-col gap-6">
        {{ $this->form }}
        
        <div class="flex items-center justify-end">
            <x-filament::button type="submit" class="w-full">
                {{ __('Create account') }}
            </x-filament::button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <x-filament::link :href="route('login')" wire:navigate>{{ __('Log in') }}</x-filament::link>
    </div>
</div>
