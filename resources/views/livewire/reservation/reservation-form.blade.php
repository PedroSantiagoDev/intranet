<div>
    <form wire:submit.prevent="save({{ $reservation->id ?? "null" }})" class="space-y-4">
        {{ $this->form }}

        <div class="space-x-2">
            <x-filament::button type="submit" wire:loading.attr="disabled">{{ $reservation ? "Atualizar Reserva" : "Criar Reserva" }}</x-filament::button>
            <x-filament::button color="gray" href="{{ route('reservations.index') }}" tag="a">Voltar</x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
