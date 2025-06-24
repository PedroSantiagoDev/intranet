<div class="space-y-8 lg:space-y-10">
    {{-- Seção de Links da Unidade --}}
    <section x-data="{ expanded: false }">
        <div class="relative bg-white dark:bg-gray-900 sm:rounded-xl border border-gray-200 dark:border-gray-700">
            @if ($unitLinks->isEmpty())
                <div class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 m-4">
                    <div class="text-gray-400 mb-3">
                        <x-filament::icon icon="heroicon-o-link" class="h-12 w-12" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Nenhum link disponível</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-center text-sm max-w-md">No momento, sua unidade não possui links ativos disponíveis para acesso rápido.</p>
                </div>
            @else
                <div class="p-2 sm:p-4">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                        @foreach ($unitLinks as $index => $link)
                            <div
                                x-show="expanded || {{ $index }} < 6"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                            >
                                <x-header-link :title="$link->name" :url="$link->url" :icon="$link->icon" />
                            </div>
                        @endforeach
                    </div>

                    {{-- Botão absoluto com mesma cor e sombra do card --}}
                    @if ($unitLinks->count() > 6)
                        <div class="absolute mt-1 left-1/2 -translate-x-1/2 z-10">
                            <button
                                @click="expanded = !expanded"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:bg-white dark:hover:bg-gray-900 rounded-full border border-gray-200 dark:border-gray-700 transition-all duration-200"
                            >
                                <span x-show="!expanded" x-transition class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-chevron-down" class="h-3 w-3" />
                                    + {{ $unitLinks->count() - 6 }} links
                                </span>
                                <span x-show="expanded" x-transition class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-chevron-up" class="h-3 w-3" />
                                    Menos
                                </span>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @if ($newsAlert)
        <section>
            <x-info-alert :type="$newsAlert->type" :title="$newsAlert->title" :content="$newsAlert->content" />
        </section>
    @endif

    {{-- Seção de Links Pessoais e Notícias --}}
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Links Pessoais --}}
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Meus Favoritos</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Acesse rapidamente seus links personalizados</p>
                </div>
                <x-filament::button color="gray" href="/links" tag="a" icon="heroicon-m-pencil-square" class="shrink-0 text-xs" wire:navigate>Editar</x-filament::button>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                @if ($userLinks->isEmpty())
                    <div class="flex flex-col items-center justify-center h-40 p-4">
                        <div class="text-gray-400 mb-2">
                            <x-filament::icon icon="heroicon-o-star" class="h-10 w-10" />
                        </div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-1">Nenhum link favorito</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-center text-xs max-w-sm">Adicione seus links mais utilizados para acesso rápido.</p>
                    </div>
                @else
                    <div class="p-3 space-y-2 h-[280px] sm:h-[320px] md:h-[360px] lg:h-[430px] overflow-y-auto">
                        @foreach ($userLinks as $link)
                            <x-user-link :title="$link->name" :url="$link->url" :icon="$link->icon" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Notícias (Carrossel) --}}
        <div
            x-data="{
                activeSlide: 0,
                slides: {{ $news }},
                autoPlay: true,
                autoPlayInterval: null,
                init() {
                    if (this.slides && this.slides.length > 1) {
                        this.startAutoPlay()
                    }
                },
                startAutoPlay() {
                    this.autoPlayInterval = setInterval(() => {
                        if (this.autoPlay) {
                            this.nextSlide()
                        }
                    }, 8000)
                },
                stopAutoPlay() {
                    if (this.autoPlayInterval) {
                        clearInterval(this.autoPlayInterval)
                    }
                },
                nextSlide() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length
                },
                prevSlide() {
                    this.activeSlide =
                        (this.activeSlide - 1 + this.slides.length) % this.slides.length
                },
                goToSlide(index) {
                    this.activeSlide = index
                },
                getCurrentSlide() {
                    return this.slides[this.activeSlide] || null
                },
            }"
            @mouseenter="autoPlay = false"
            @mouseleave="autoPlay = true"
            class="relative h-full"
        >
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 h-[280px] sm:h-[320px] md:h-[360px] lg:h-[500px]">
                <template x-if="slides.length === 0">
                    <div class="flex flex-col items-center justify-center h-full p-6">
                        <div class="text-gray-400 mb-3">
                            <x-filament::icon icon="heroicon-o-newspaper" class="h-10 w-10" />
                        </div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">Nenhum destaque disponível</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-center text-xs max-w-sm">No momento não há notícias para exibir.</p>
                    </div>
                </template>

                <template x-if="slides.length > 0">
                    <div class="relative h-full">
                        {{-- Container do Carrossel - Mesma altura dos links --}}
                        <div class="relative h-full overflow-hidden">
                            <template x-for="(slide, index) in slides" :key="slide.id">
                                <div
                                    x-show="activeSlide === index"
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 translate-x-full"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 translate-x-0"
                                    x-transition:leave-end="opacity-0 -translate-x-full"
                                    class="absolute inset-0 flex items-center justify-center"
                                >
                                    {{-- Link condicional --}}
                                    <template x-if="slide.url && slide.url.trim() !== ''">
                                        <a :href="slide.url" target="__black" class="relative h-full w-full cursor-pointer">
                                            <img
                                                :src="slide.file_url"
                                                :alt="slide.title"
                                                class="h-full w-full object-fill rounded-xl border border-gray-200 dark:border-gray-700"
                                                loading="lazy"
                                            />

                                            {{-- Mensagem de clique apenas se houver link --}}
                                            <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 rounded-xl bg-gradient-to-t from-black/80 to-transparent">
                                                <div class="flex items-center gap-2 text-white/90">
                                                    <x-filament::icon icon="heroicon-m-cursor-arrow-rays" class="h-4 w-4" />
                                                    <p class="text-xs sm:text-sm">Clique para mais detalhes</p>
                                                </div>
                                            </div>
                                        </a>
                                    </template>

                                    {{-- Imagem sem link --}}
                                    <template x-if="! slide.url || slide.url.trim() === ''">
                                        <div class="relative h-full w-full flex items-center justify-center">
                                            <img
                                                :src="slide.file_url"
                                                :alt="slide.title"
                                                class="h-full w-full object-fill rounded-xl border border-gray-200 dark:border-gray-700"
                                                loading="lazy"
                                            />
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        {{-- Controles de Navegação --}}
                        <template x-if="slides.length > 1">
                            <div>
                                <button
                                    @click="prevSlide()"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 p-2 rounded-full transition-all duration-200 z-10"
                                    aria-label="Slide anterior"
                                >
                                    <x-filament::icon icon="heroicon-m-chevron-left" class="h-5 w-5" />
                                </button>
                                <button
                                    @click="nextSlide()"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full transition-all duration-200 z-10"
                                    aria-label="Próximo slide"
                                >
                                    <x-filament::icon icon="heroicon-m-chevron-right" class="h-5 w-5" />
                                </button>
                            </div>
                        </template>

                        {{-- Indicadores de Navegação --}}
                        <template x-if="slides.length > 1">
                            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1.5">
                                <template x-for="(slide, index) in slides" :key="slide.id">
                                    <button
                                        type="button"
                                        class="h-1.5 rounded-full transition-all duration-300"
                                        :class="activeSlide === index ? 'w-4 bg-blue-500' : 'w-1.5 bg-gray-300 dark:bg-gray-600'"
                                        @click="goToSlide(index)"
                                        :aria-label="`Ir para slide ${index + 1}`"
                                    ></button>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </section>
</div>
