<?php

use App\Filters\FilterManager;
use App\Managers\CartManager;
use App\Models\Category;
use App\Sorters\Sorter;
use App\Support\Flash\Flash;

if (!function_exists('cart')) {
    function cart(): CartManager
    {
        return app(CartManager::class);
    }
}

if (!function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}

if (!function_exists('sorter')) {
    function sorter(): Sorter
    {
        return app(Sorter::class);
    }
}

if (!function_exists('is_catalog_view')) {
    function is_catalog_view(string $type, string $default = 'grid'): bool
    {
        return session('view', $default) === $type;
    }
}

if (!function_exists('filter_url')){
    function filter_url(?Category $category, array $params = []): string
    {
        return route('catalog', [
            ...request()->only(['filters', 'sort']),
            ...$params,
            'category' => $category
        ]);
    }
}

if (!function_exists('flash')){
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
