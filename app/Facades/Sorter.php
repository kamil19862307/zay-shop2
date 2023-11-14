<?php

namespace App\Facades;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder run(Builder $query)
 * @see \App\Sorters\Sorter
 */
class Sorter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Sorters\Sorter::class;
    }
}
