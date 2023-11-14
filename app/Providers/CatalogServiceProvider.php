<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\FilterManager;
use App\Filters\PriceFilter;
use App\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);

        $this->app->bind(Sorter::class, function(){
            return new Sorter([
                'title',
                'price'
            ]);
        });
    }
}
