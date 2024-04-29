<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(): Factory|Application|View
    {
        // если мы воспользуемся картАйтемс 'items' => cart()->cartItems(), а у нас там просто игерлоад с коллекцией,
        // то мы сталкнёмся с проблеммой. Нам потребуется вызывать также сам товар, отношения со всеми опциями,
        // и выпадит exception так как используем Строгий режим (strict mode), чтобы не плодить проблему
        // n + 1. Поэтому немного изменим подход и на корзину будем отправлять другой запрос.
        return view('cart.index', [
            'items' => cart()->items()
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add(
            $product,
            request('quantity', 1),
            request('options', [])
        );

        flash()->info('Товар добавлен в корзину');

        return redirect()->intended('cart');
    }

    public function quantity(CartItem $item): RedirectResponse
    {
        cart()->quantity($item, request('quantity', 1));

        flash()->info('Кол-во товаров изменено');

        return redirect()->intended('cart');
    }

    public function delete(CartItem $item): RedirectResponse
    {
        cart()->delete($item);

        flash()->info('Удалено из корзины');

        return redirect()->intended('cart');
    }

    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()->intended('cart');
    }
}
