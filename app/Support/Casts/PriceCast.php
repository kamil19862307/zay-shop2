<?php

namespace App\Support\Casts;

use App\Support\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): Price
    {
        return Price::make($value);
    }

    public function set($model, string $key, mixed $value, array $attributes): int
    {
        if (!$value instanceof Price){
            $value = Price::make($value);
        }
        return $value->raw();
    }
}
