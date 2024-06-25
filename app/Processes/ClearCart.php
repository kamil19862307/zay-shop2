<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order;

final class ClearCart implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        cart()->truncate();

        return $next($order);
    }
}
