<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PriceFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Цена';
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when(request('filters.price'), function (Builder $q){
            $q->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 1000000) *100,
            ]);
        });
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to' => 1000000
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
