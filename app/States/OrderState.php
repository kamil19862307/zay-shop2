<?php

namespace App\States;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [];

    // Сущность заказа
    public function __construct(protected Order $order)
    {
    }

    abstract public function canBeChanged(): bool;

    // Значения, которые будут сохраняться в базе - new, pending, paid, cancelled
    abstract public function value(): string;

    // Чтоб в админке, верстке и где надо на человеческом отображалось
    abstract public function humanValue(): string;

    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()){
            throw new InvalidArgumentException('Status can`t be changed');
        }

        if (!in_array(get_class($state), $this->allowedTransitions)){
            throw new InvalidArgumentException(
                "No transition for {$this->order->status->value()} to {$state->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStatusChanged(
            $this->order,
            $this->order->status,
            $state
        ));
    }
}
