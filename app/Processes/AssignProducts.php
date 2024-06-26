<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order;

final class AssignProducts implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        $order->orderItems()
            ->createMany(
                cart()->items()->map(function ($item){
                    return [
                        'product_id' => $item->product_id,
                        'price' => $item->price,
                        'quantity' => $item->quantity
                    ];
                })->toArray()
            );

        return $next($order);
    }
}
