<?php

namespace App\Enums;

use App\Models\Order;
use App\States\CancelledOrderState;
use App\States\NewOrderState;
use App\States\OrderState;
use App\States\PaidOrderState;
use App\States\PendingOrderState;

enum OrderStatuses: string
{
    case New = 'new';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Paid = 'paid';

    public function createState(Order $order): OrderState
    {
        return match ($this){
            OrderStatuses::New => new NewOrderState($order),
            OrderStatuses::Pending => new PendingOrderState($order),
            OrderStatuses::Paid => new PaidOrderState($order),
            OrderStatuses::Cancelled =>new CancelledOrderState($order)
        };
    }
}
