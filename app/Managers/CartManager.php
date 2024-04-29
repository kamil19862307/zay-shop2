<?php

namespace App\Managers;

use App\Contracts\CartIdentityStorageContract;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Support\ValueObjects\Price;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class CartManager{

    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    )
    {
    }

    public function storedData(string $id): array
    {
        // По умолчанию, массив со сторажайди
        $data = [
            'storage_id' => $id
        ];

        // Если авторизованный пользователь, то добавим юзерайди
        if (auth()->check())
            $data['user_id'] = auth()->id();

        return $data;
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    // Товар, количество и массив с выбранными опциями (id =>value)
    public function add(Product $product, $quantity = 1, array $optionValues = []): Model|Builder
    {
        // Сначала получим сущность корзины, либо создадим, либо проабдейтим (чтобы при добавлении менять
        // тайстемпы на апдейтед и если придёт id аутентифицированного пользователя, мы её также
        // в последующем на одну из добавлений проставим)
        $cart = Cart::query()
            ->updateOrCreate(
                // storage_id у нас всегда присутствует, в отличии от пользователя (может быть и гостем)
                // Параметры на create и update это также сторажайди и юзерайди
                ['storage_id' => $this->identityStorage->get()],
                $this->storedData($this->identityStorage->get())
            );

        // Товар в корзине
        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ], [
            'price' => $product->price,
            'quantity' => DB::raw("quantity + $quantity"),
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ]);

        $cartItem->optionValues()->sync($optionValues);

        $this->forgetCache();

        return $cart;
    }

    public function updateStorageId(string $old, string $current): void
    {
        Cart::query()
            ->where('storage_id', $old)
            ->update($this->storedData($current));
    }

    public function items(): Collection
    {
        // Всегда будет коллекция
        if (!$this->get())
            return collect();

        return CartItem::query()
            ->with(['product', 'optionValues.option'])

            // Только товары текущей корзины
            ->whereBelongsTo($this->get())
            ->get();
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $item): void
    {
        $item->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

        $this->forgetCache();
    }

    // Получить текущую корзину
    private function get()
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function (){
            return Cart::query()

                // Все товары
                ->with('cartItems')

                // Где 'storage_id'это идентификатор $this->identityStorage->get()
                ->where('storage_id', $this->identityStorage->get())
                ->when(auth()->check(), fn(Builder $query) => $query->orWhere('user_id', auth()->id()))
                ->first() ?? false;
        });
    }

    public function cartItems(): Collection
    {
        // Если есть, то возвращаем cartItems, а если нет, то коллекцию, чтоб на выходе всегда была коллекция.
        return $this->get()?->cartItems ?? collect([]);
    }

    // Пройдётся по всем позициям и соберёт сумму
    public function count(): int
    {
        // Используем sum, а не count потому что у нас есть и quantity в таблице, может быть несколько
        // одинаковых товаров. В рамках коллекции мы указали что нам нужна сумма, а в анонимной
        // функции указали что будем считать по полю quantity
        return $this->cartItems()->sum(function ($item){
            return $item->quantity;
        });
    }

    // Сумма всех сумм товарных позиций
    public function amount()
    {
        return Price::make(
            $this->cartItems()->sum(function ($item){
                return $item->amount->raw();
            })
        );
    }

    public function cacheKey(): string
    {
        return str('cart_' . $this->identityStorage->get())

            // Преобразуем в слаг с нижним поддчёркиванием
            ->slug('_')

            // и вернём строку
            ->value();
    }

    private function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}
