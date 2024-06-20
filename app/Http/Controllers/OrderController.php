<?php

namespace App\Http\Controllers;

use App\Actions\NewOrderAction;
use App\Http\Requests\OrderFormRequest;
use App\Models\DeliveryType;
use App\Models\PaymentMethod;
use DomainException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        return redirect()->route('home');
    }
}
