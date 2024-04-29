<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Внешний ключ на корзину
            $table->foreignIdFor(Cart::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Внешний ключ на товар, он всегда есть
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('price');

            $table->integer('quantity');

            // Чтоб уменьшить запросы к базе
            $table->string('string_option_values')
                ->nullable();

            $table->timestamps();
        });

        // Связующая таблица между cart_item и вариациями (цвет, размер и тд.)
        Schema::create('cart_item_option_value', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(CartItem::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if(!app()->isProduction()){
            Schema::dropIfExists('cart_items');
        }
    }
};
