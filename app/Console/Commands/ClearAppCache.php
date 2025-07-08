<?php

namespace App\Console\Commands;

use App\Helpers\CacheHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Artisan, Cache};

//TODO verificar o real uso desse arquivo
class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache 
                            {--all : Clear all caches including Laravel caches}
                            {--app-only : Clear only application specific caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear application specific caches (visitor links, news alerts, etc.)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧹 Clearing application caches...');

        if ($this->option('all')) {
            $this->clearAllCaches();
        } elseif ($this->option('app-only')) {
            $this->clearAppSpecificCaches();
        } else {
            $this->clearAppSpecificCaches();
            $this->clearLaravelCaches();
        }

        $this->info('✅ Application caches cleared successfully!');

        return Command::SUCCESS;
    }

    private function clearAppSpecificCaches(): void
    {
        $this->line('Clearing visitor links cache...');
        CacheHelper::clearVisitorLinks();

        $this->line('Clearing news alerts cache...');
        // Clear all news alert caches (we could improve this to be more specific)
        $keys = Cache::tags(['news_alerts'])->flush();

        $this->line('Application specific caches cleared.');
    }

    private function clearLaravelCaches(): void
    {
        $this->line('Clearing Laravel caches...');

        Artisan::call('cache:clear');
        $this->line('✓ Cache cleared');

        Artisan::call('config:clear');
        $this->line('✓ Config cache cleared');

        Artisan::call('view:clear');
        $this->line('✓ View cache cleared');

        Artisan::call('route:clear');
        $this->line('✓ Route cache cleared');
    }

    private function clearAllCaches(): void
    {
        $this->line('Clearing ALL caches...');

        CacheHelper::clearAll();
        $this->clearLaravelCaches();

        $this->line('All caches cleared.');
    }
}
