<div>
    <x-filament::modal id="create-edit-link">
        <x-slot name="trigger">
            <x-filament::button>Criar</x-filament::button>
        </x-slot>

        {{-- Modal content --}}
        <form wire:submit="{{ $editingLink ? "update" : "store" }}" class="space-y-6">
            <x-slot name="heading">Link</x-slot>

            {{ $this->form }}

            <x-filament::button type="store">{{ $editingLink ? "Atualizar" : "Criar" }}</x-filament::button>
        </form>
    </x-filament::modal>

    <section>
        {{ $this->table }}
    </section>
    <x-filament-actions::modals />
</div>
