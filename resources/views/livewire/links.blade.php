<div>
    <x-filament::modal>
        <x-slot name="trigger">
            <x-filament::button>Criar</x-filament::button>
        </x-slot>

        {{-- Modal content --}}
        <form wire:submit="store" class="space-y-6">
            <x-slot name="heading">Link</x-slot>

            {{ $this->form }}

            <x-filament::button type="store">Criar</x-filament::button>
        </form>

        <x-filament-actions::modals />
    </x-filament::modal>
</div>
