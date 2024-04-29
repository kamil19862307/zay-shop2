<?php

namespace App\Providers;

use App\Managers\CartManager;
use App\Models\Cart;
use App\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Singleton с айди
        $this->app->singleton(CartManager::class, function (){
            return new CartManager(new SessionIdentityStorage());
        });
    }

    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }
}
