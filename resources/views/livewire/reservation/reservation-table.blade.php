<div class="space-y-4">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Reservas</h2>
        <div class="space-x-2">
            <x-filament::button href="{{ route('reservations.create') }}" tag="a">Criar</x-filament::button>
        </div>
    </div>

    {{ $this->table }}

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copyToClipboard', (event) => {
                const text = event.text;

                const input = document.createElement('textarea');
                input.value = text;
                document.body.appendChild(input);
                input.select();

                try {
                    navigator.clipboard.writeText(text).then(() => {
                        console.log('Link copiado com sucesso');
                    });
                } catch (err) {
                    document.execCommand('copy');
                }

                document.body.removeChild(input);
            });
        });
    </script>
</div>
