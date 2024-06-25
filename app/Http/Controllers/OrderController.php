<?php

namespace App\Http\Controllers;

use App\Actions\NewOrderAction;
use App\Http\Requests\OrderFormRequest;
use App\Models\DeliveryType;
use App\Models\PaymentMethod;
use App\Processes\AssignCustomer;
use App\Processes\AssignProducts;
use App\Processes\ChangeStateToPending;
use App\Processes\CheckProductQuantities;
use App\Processes\ClearCart;
use App\Processes\DecreaseProductQuantities;
use App\Processes\OrderProcess;
use DomainException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index(): Factory|Application|View
    {
        // Все товары из корзины
        $items = cart()->items();

        if ($items->isEmpty()){
            throw new DomainException('Корзина пуста');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get()
        ]);
    }

    public function handle(OrderFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $order = $action($request);

        (new OrderProcess($order))->processes([

            // Хватает-ли товара на складе
            new CheckProductQuantities(),

            // Данные заказчика
            new AssignCustomer(request('customer')),

            // Заказанные товары
            new AssignProducts(),

            // Поменять статус заказа
            new ChangeStateToPending(),

            // Уменьшить количество товара на складе
            new DecreaseProductQuantities(),

            // Очистить корзину с товарами
            new ClearCart()

        ])->run();

        return redirect()->route('home');
    }
}
