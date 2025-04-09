<x-filament-panels::page>
    @if($links->isEmpty())
        <x-filament::card>
            <div class="flex items-center justify-center p-6 space-y-4 text-center">
                <div class="flex gap-2 justify-center">
                    <x-filament::icon
                        icon="heroicon-o-link"
                        class="h-5 w-5 text-primary-500"
                    />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Nenhum link encontrado
                    </h3>
                </div>
            </div>
        </x-filament::card>
    @else
        <!-- Container com altura máxima e rolagem vertical, centralizando os elementos -->
        <div class="flex flex-col gap-2 max-h-80 overflow-y-auto items-start">
            @foreach($links as $link)
                <!-- Container para limitar a largura do link -->
                <div class="w-full max-w-md">
                    <a 
                        href="{{ $link->url }}" 
                        target="_blank"
                        class="block group text-sm"
                    >
                        <x-filament::card 
                            class="hover:shadow-lg transition-shadow duration-200 hover:bg-primary-50/50 dark:hover:bg-gray-800 p-2"
                        >
                            <div class="flex items-center gap-3">
                                <x-filament::icon
                                    icon="heroicon-o-link"
                                    class="h-5 w-5 text-primary-500"
                                />
                                <span class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">
                                    {{ $link->title }}
                                </span>
                            </div>
                        </x-filament::card>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</x-filament-panels::page>
