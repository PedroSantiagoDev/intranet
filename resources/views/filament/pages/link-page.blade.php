<x-filament-panels::page>
    @if($links->isEmpty())
        <x-filament::card>
            <div class="flex flex-col items-center justify-center p-6 space-y-4 text-center">
                <x-filament::icon 
                    icon="heroicon-o-link" 
                    class="h-12 w-12 text-gray-400" 
                />
                <div class="space-y-1">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Nenhum link encontrado
                    </h3>
                </div>
            </div>
        </x-filament::card>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($links as $link)
                <a 
                    href="{{ $link->url }}" 
                    target="_blank"
                    class="block group"
                >
                    <x-filament::card 
                        class="hover:shadow-lg transition-shadow duration-200 hover:bg-primary-50/50 dark:hover:bg-gray-800"
                    >
                        <div class="flex items-center space-x-2">
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
            @endforeach
        </div>
    @endif
</x-filament-panels::page>