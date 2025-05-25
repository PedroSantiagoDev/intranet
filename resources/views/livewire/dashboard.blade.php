<div class="space-y-4">
    {{-- Seção de Links da Unidade --}}
    <section>
        <div class="p-2 sm:p-4 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Sistemas</h2>

            @if ($unitLinks->isEmpty())
                <div class="flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <p class="text-gray-500 dark:text-gray-400 text-center">Sua unidade não possui links ativos.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-6">
                    @foreach ($unitLinks as $link)
                        <x-header-link :title="$link->name" :url="$link->url" :icon="$link->icon" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Seção de Links Pessoais e Notícias --}}
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Links Pessoais --}}
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Links</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Seus links pessoais</p>
                </div>
                <x-filament::button color="gray" href="/links" tag="a" icon="heroicon-m-pencil-square" tooltip="Edite os seus links">Editar</x-filament::button>
            </div>

            <div>
                @if ($userLinks->isEmpty())
                    <div class="flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800">
                        <p class="text-gray-500 dark:text-gray-400 text-center">Você não possui links personalizados ativos.</p>
                    </div>
                @else
                    <div class="space-y-2 h-[500px] p-3 overflow-y-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-md">
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
                init() {
                    if (this.slides && this.slides.length > 0) {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length
                        }, 8000)
                    }
                },
            }"
        >
            <div class="flex flex-col items-center justify-center m-auto mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Destaques</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Notícias e palestras</p>
            </div>

            <template x-if="slides.length === 0">
                <div class="flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <p class="text-gray-500 dark:text-gray-400 text-center">Você não possui links personalizados ativos.</p>
                </div>
            </template>

            <template x-if="slides.length > 0">
                <div class="h-[500px] relative overflow-hidden rounded-xl shadow-lg">
                    <div class="flex items-center">
                        {{-- Botão Anterior --}}
                        <button
                            @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length"
                            class="absolute left-4 z-10 rounded-full bg-white/80 p-2.5 text-slate-700 shadow-md backdrop-blur-sm hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 dark:bg-slate-800/80 dark:text-slate-200"
                            aria-label="Slide anterior"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        {{-- Slides --}}
                        <div class="relative h-[500px] w-full overflow-hidden rounded-xl bg-transparent">
                            <template x-for="(slide, index) in slides" :key="slide.id">
                                <div
                                    x-show="activeSlide === index"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-x-full"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform translate-x-0"
                                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                                    class="absolute inset-0"
                                >
                                    <img :src="slide.file" :alt="slide.title" class="h-full w-full object-contain bg-transparent" />
                                </div>
                            </template>
                        </div>

                        {{-- Botão Próximo --}}
                        <button
                            @click="activeSlide = (activeSlide + 1) % slides.length"
                            class="absolute right-4 z-10 rounded-full bg-white/80 p-2.5 text-slate-700 shadow-md backdrop-blur-sm hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 dark:bg-slate-800/80 dark:text-slate-200"
                            aria-label="Próximo slide"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    {{-- Navegação por bolinhas --}}
                    <div class="flex justify-center space-x-3 mt-4">
                        <template x-for="(slide, index) in slides" :key="slide.id">
                            <button
                                type="button"
                                class="h-2 w-2 rounded-full transition-all duration-300 ease-in-out"
                                :class="activeSlide === index ? 'bg-blue-500 w-4' : 'bg-slate-300 dark:bg-slate-600'"
                                @click="activeSlide = index"
                                :aria-label="`Ir para slide ${index + 1}`"
                            ></button>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </section>
</div>
