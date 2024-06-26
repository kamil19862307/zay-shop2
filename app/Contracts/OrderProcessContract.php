<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderProcessContract
{
    public function handle(Order $order, $next);
}
