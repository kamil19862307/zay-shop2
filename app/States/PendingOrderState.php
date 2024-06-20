<?php

namespace App\States;

class PendingOrderState extends OrderState
{
    // Этот стейт может быть оплачен и отменён
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pending';
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }
}
