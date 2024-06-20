<?php

namespace App\Events;

use App\Models\Order;
use App\States\OrderState;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Order $order, public OrderState $old, public OrderState $current)
    {
    }
}
