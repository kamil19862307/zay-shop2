<?php

namespace App\States;

class NewOrderState extends OrderState
{
    // Новый заказ может перейти только в статус "В обработке" и в "Отменён"
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'new';
    }

    public function humanValue(): string
    {
        return 'Новый заказ';
    }
}
