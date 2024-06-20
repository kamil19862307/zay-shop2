<?php

namespace App\States;

class PaidOrderState extends OrderState
{
    // Этот стейт может быть отменён
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        // Может быть отменён заказ
        return true;
    }

    public function value(): string
    {
        return 'paid';
    }

    public function humanValue(): string
    {
        return 'Оплачен';
    }
}
