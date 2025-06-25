<div class="space-y-4">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Reservas</h2>
        <div class="space-x-2">
            <x-filament::button href="{{ route('reservations.create') }}" tag="a" wire:navigate>Criar</x-filament::button>
        </div>
    </div>

    {{ $this->table }}

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copyToClipboard', ({ text }) => {
                const input = document.createElement('textarea');
                input.value = text;
                document.body.appendChild(input);
                input.select();

                navigator.clipboard
                    .writeText(text)
                    .then(() => {
                        console.log('Link copiado com sucesso');
                    })
                    .catch((err) => {
                        console.warn('Erro ao copiar', err);
                        document.execCommand('copy');
                    });

                document.body.removeChild(input);
            });
        });
    </script>
</div>
