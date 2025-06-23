<div class="w-full flex items-center justify-center">
    <div class="w-full space-y-4">
        @if ($newsAlert)
            <section>
                <x-info-alert :type="$newsAlert->type" :title="$newsAlert->title" :content="$newsAlert->content" />
            </section>
        @endif

        {{-- Seção de Links da Unidade --}}
        <section class="p-2 sm:p-4">
            <div class="bg-white dark:bg-gray-900 sm:rounded-xl border border-gray-200 dark:border-gray-700">
                @if ($visitorLinksHeader->isEmpty())
                    <div class="flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800">
                        <p class="text-gray-500 dark:text-gray-400 text-center">No momento, sua unidade não possui links ativos. Confira novamente mais tarde.</p>
                    </div>
                @else
                    <div class="p-2 sm:p-4">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-6">
                            @foreach ($visitorLinksHeader as $link)
                                <x-header-link :title="$link->name" :url="$link->url" :icon="$link->icon" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
