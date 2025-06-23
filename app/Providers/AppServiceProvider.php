<?php

namespace App\Providers;

use App\Models\VisitorLinksHeader;
use App\Observers\VisitorLinksHeaderObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\NewsService::class);
        $this->app->singleton(\App\Services\DashboardService::class);
        $this->app->singleton(\App\Services\HomeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VisitorLinksHeader::observe(VisitorLinksHeaderObserver::class);

        FilamentColor::register([
            'danger'  => Color::Rose,
            'gray'    => Color::Gray,
            'info'    => Color::Sky,
            'primary' => Color::Blue,
            'success' => Color::Emerald,
            'warning' => Color::Orange,
        ]);
    }
}
