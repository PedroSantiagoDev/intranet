<div class="w-full flex items-center justify-center">
    <div class="w-full space-y-4">
        {{-- Seção de Links da Unidade --}}
        <section>
            <div class="p-2 sm:p-4 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Sistemas</h2>

                @if ($visitorLinksHeader->isEmpty())
                    <div class="flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800">
                        <p class="text-gray-500 dark:text-gray-400 text-center">No momento, sua unidade não possui links ativos. Confira novamente mais tarde.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-6">
                        @foreach ($visitorLinksHeader as $link)
                            <x-header-link :title="$link->name" :url="$link->url" :icon="$link->icon" />
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
