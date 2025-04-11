<x-filament-panels::page>
    {{-- Header Section --}}
    <x-filament::card>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <x-header-card title="E-CODEVASF" url="https://www.php.net/" icon="heroicon-o-document-text" />
            <x-header-card title="E-mail" url="https://www.php.net/" icon="heroicon-o-envelope" />
            <x-header-card title="Ponto" url="https://www.php.net/" icon="heroicon-o-clock" />
            <x-header-card title="WhatsApp" url="https://www.php.net/" icon="heroicon-o-chat-bubble-left-right" />
            <x-header-card title="Intranet" url="https://www.php.net/" icon="heroicon-o-home" />
            <x-header-card title="Sistemas" url="https://www.php.net/" icon="heroicon-o-cog" />
        </div>
    </x-filament::card>

    <section class="flex flex-col lg:flex-row gap-4">
        <!-- Card de Links -->
        <div class="flex-1">
            <x-filament::card class="h-80 flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        @svg('heroicon-o-bookmark', 'w-5 h-5 mr-2 text-primary-500')
                        Links Personalizados
                    </h3>
                    <a href="{{ route('filament.auth.resources.links.index') }}">
                        <x-filament::button icon="heroicon-o-plus-circle">
                            Adicionar
                        </x-filament::button>
                    </a>
                </div>

                <!-- Lista de links com scroll e preenchendo o espaço restante -->
                <div class="flex-1 overflow-y-auto pr-2">
                    <div class="flex flex-col gap-2">
                        @foreach ($links as $link)
                            <x-link-card title="{{ $link->title }}" url="{{ $link->url }}" />
                        @endforeach
                    </div>
                </div>
            </x-filament::card>
        </div>

        <!-- Card de Imagem -->
        <div class="flex-1">
            <x-filament::card class="h-80 p-0 overflow-hidden">
                <img src="{{ asset('assets/images/image_test.jpeg') }}" alt="Imagem de exemplo"
                    class="w-full h-full object-cover">
            </x-filament::card>
        </div>
    </section>



</x-filament-panels::page>
