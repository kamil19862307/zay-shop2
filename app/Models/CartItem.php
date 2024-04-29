<?php

namespace App\Models;

use App\Support\Casts\PriceCast;
use App\Support\ValueObjects\Price;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'price',
        'quantity',
        'string_option_values'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function amount(): Attribute
    {
        // ->raw() Чтобы вернуть integer
        return Attribute::make(
            get: fn() => Price::make(
                $this->price->raw() * $this->quantity
            )
        );
    }

    // Связь на родителькую корзину
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    // И связь на товар
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // И связь на option_values
    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
