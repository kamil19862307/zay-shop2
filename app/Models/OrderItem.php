<?php

namespace App\Models;

use App\Support\Casts\PriceCast;
use App\Support\ValueObjects\Price;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'quantity'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function amount()
    {
        return Attribute::make(
            get: fn() => Price::make(
                $this->price->raw() * $this->quantity
            )
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
