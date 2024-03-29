<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    public function __invoke(Builder $query, $next)
    {
        $this->apply($query);

        $next($query);
    }

    abstract public function title(): string;

    abstract public function key(): string;

    abstract public function apply(Builder $query): Builder;

    abstract public function values(): array;

    abstract public function view(): string;

    public function requestValue(string $index = null, mixed $default = null): mixed
    {
        return request('filters.' . $this->key() . ($index ? ".$index" : ""), $default);
    }

    public function name(string $index = null): string
    {
        // name="filters[key]?[index]"
        return (string) str($this->key())
            ->wrap('[', ']')
            ->prepend('filters')
            ->when($index, fn($str) => $str->append("[$index]"));
    }

    public function id(string $name = null): string
    {
        return (string) str($this->name($name))
            ->replace(
                ['[', ']'],
                ['_', '']
            );
    }

    public function __toString(): string
    {
        return view($this->view(), [
            'filter' => $this
            ])->render();
    }
}
