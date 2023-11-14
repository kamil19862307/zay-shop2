<?php

namespace App\Sorters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;

final class Sorter
{
    public const SORT_KEY = 'sort';

    public function __construct(
        protected array $columns = []
    )
    {}

    public function run(Builder $query)
    {
        $sortData = $this->sortData();

        return $query->when($sortData->contains($this->columns()), function(Builder $q) use ($sortData){
           // orderBy('price', 'ASC')
            $q->orderBy(
                (string) $sortData->remove('-'),
                $sortData->contains('-') ? 'DESC' : 'ASC'
            );
        });
    }

    public function key(): string
    {
        return self::SORT_KEY;
    }

    public function sortData(): Stringable
    {
        return request()->str($this->key());
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function isActive(string $column, string $direction = 'ASC'): bool
    {
        $column = trim($column, '-');

        if (strtolower($direction) === 'DESC'){
            $column = '-' . $column;
        }

        return request($this->key()) === $column;
    }
}
