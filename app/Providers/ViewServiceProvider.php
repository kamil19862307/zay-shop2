<?php

namespace App\Providers;

use App\View\Components\NavigationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot(): void
    {
        View::composer('*', NavigationComposer::class);
    }
}
