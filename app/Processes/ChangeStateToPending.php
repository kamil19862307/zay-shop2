<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order;
use App\States\PendingOrderState;

final class ChangeStateToPending implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->status->transitionTo(new PendingOrderState($order));

        return $next($order);
    }
}
