<div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
    @if ($icon)
        <span>Ícone escolhido:</span>
        <x-filament::icon icon="heroicon-m-{{ $icon }}" class="h-5 w-5 text-gray-600 dark:text-gray-400" />
    @else
        <span class="text-gray-500 dark:text-gray-400">Nenhum ícone selecionado</span>
    @endif

    <a href="https://heroicons.com" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">Ver opções</a>
</div>
