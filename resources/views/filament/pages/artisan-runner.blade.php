<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Formulário --}}
        <x-filament::section>
            <x-slot name="heading">Executar Comandos Artisan</x-slot>

            <x-slot name="description">Execute comandos Artisan diretamente pelo painel administrativo</x-slot>

            <form wire:submit="executeCommand">
                {{ $this->form }}

                <div class="mt-6 flex gap-3">
                    <x-filament::button type="submit" icon="heroicon-o-play">Executar Comando</x-filament::button>

                    <x-filament::button type="button" color="info" icon="heroicon-o-information-circle" wire:click="getMigrationStatus">Status das Migrations</x-filament::button>

                    @if ($output)
                        <x-filament::button type="button" color="gray" icon="heroicon-o-trash" wire:click="clearOutput">Limpar Output</x-filament::button>
                    @endif
                </div>
            </form>
        </x-filament::section>

        {{-- Output --}}
        @if ($output)
            <x-filament::section>
                <x-slot name="heading">Resultado da Execução</x-slot>

                <div class="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm overflow-x-auto">
                    <pre>{{ $output }}</pre>
                </div>
            </x-filament::section>
        @endif

        {{-- Comandos Úteis --}}
        <x-filament::section>
            <x-slot name="heading">Comandos Mais Utilizados</x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-blue-800">Migrations</h4>
                    <ul class="text-sm text-blue-600 mt-2 space-y-1">
                        <li>• migrate - Executar migrations</li>
                        <li>• migrate:status - Status das migrations</li>
                        <li>• migrate:rollback - Reverter última migration</li>
                    </ul>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-green-800">Cache</h4>
                    <ul class="text-sm text-green-600 mt-2 space-y-1">
                        <li>• cache:clear - Limpar cache</li>
                        <li>• config:clear - Limpar config cache</li>
                        <li>• view:clear - Limpar view cache</li>
                    </ul>
                </div>

                <div class="bg-purple-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-purple-800">Otimização</h4>
                    <ul class="text-sm text-purple-600 mt-2 space-y-1">
                        <li>• optimize - Otimizar aplicação</li>
                        <li>• optimize:clear - Limpar otimizações</li>
                        <li>• storage:link - Link simbólico storage</li>
                    </ul>
                </div>
            </div>
        </x-filament::section>

        {{-- Avisos de Segurança --}}
        <x-filament::section>
            <x-slot name="heading">⚠️ Avisos Importantes</x-slot>

            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                <ul class="text-sm text-yellow-800 space-y-2">
                    <li>
                        •
                        <strong>Sempre faça backup</strong>
                        antes de executar migrations
                    </li>
                    <li>
                        •
                        <strong>Teste em ambiente de desenvolvimento</strong>
                        primeiro
                    </li>
                    <li>
                        •
                        <strong>Comandos destrutivos</strong>
                        (fresh, reset) apagam dados
                    </li>
                    <li>
                        •
                        <strong>Use --force apenas em produção</strong>
                        quando necessário
                    </li>
                    <li>
                        •
                        <strong>Monitore os logs</strong>
                        após execução de comandos
                    </li>
                </ul>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
