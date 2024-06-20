<?php

namespace App\Actions;

use App\Contracts\RegisterNewUserContract;
use App\DTOs\NewUserDTO;
use App\Http\Requests\OrderFormRequest;
use App\Models\Order;

final class NewOrderAction
{
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        $customer = $request->get('customer');

        if ($request->boolean('create_account')){
            $registerAction(NewUserDTO::make(
                $customer['first_name'] . '' . $customer['last_name'],
                $customer['email'],
                $request->get('password')
            ));
        }

        return Order::query()->create([
            'payment_method_id' => $request->get('payment_method_id'),
            'delivery_type_id' => $request->get('delivery_type_id')
        ]);
    }
}
