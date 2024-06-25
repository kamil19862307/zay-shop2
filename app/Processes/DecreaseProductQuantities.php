<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order;
use DB;

final class DecreaseProductQuantities implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            $item->product()->update([
                'quantity' => DB::raw('quantity - ' . $item->quantity)
            ]);
        }

        return $next($order);
    }
}
