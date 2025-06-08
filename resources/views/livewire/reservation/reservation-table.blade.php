<div class="space-y-4">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Reservas do Auditório</h2>
        <div class="space-x-2">
            <x-filament::button href="{{ route('reservations.create') }}" tag="a">Criar</x-filament::button>
        </div>
    </div>

    {{ $this->table }}
</div>
