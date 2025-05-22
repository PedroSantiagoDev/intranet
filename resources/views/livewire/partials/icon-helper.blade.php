<div class="flex items-center space-x-2">
    @if ($icon)
        <span class="text-gray-500">Ícone escolhido:</span>
        <x-filament::icon icon="heroicon-m-{{ $icon }}" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
    @else
        <span class="text-sm text-gray-500">Nenhum ícone selecionado</span>
    @endif
    <a href="https://heroicons.com" target="_blank" class="text-blue-500 underline text-sm">Opções</a>
</div>
