<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Seus Links</h2>

        <x-filament::modal id="create-edit-link" width="lg" :close-by-clicking-away="false">
            <x-slot name="trigger">
                <x-filament::button>Criar Link</x-filament::button>
            </x-slot>

            {{-- Modal content --}}
            <form wire:submit="{{ $editingLink ? "update" : "store" }}" class="space-y-6">
                <x-slot name="heading">{{ $editingLink ? " Editar links" : "Criar links" }}</x-slot>

                {{ $this->form }}

                <div class="space-x-2">
                    <x-filament::button type="submit">{{ $editingLink ? "Salvar alterações" : "Criar" }}</x-filament::button>
                    <x-filament::button outlined wire:click="$dispatch('close-modal', { id: 'create-edit-link' })">Cancelar</x-filament::button>
                </div>
            </form>
        </x-filament::modal>
    </div>

    <section>
        {{ $this->table }}
    </section>
    <x-filament-actions::modals />
</div>
