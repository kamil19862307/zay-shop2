<?php

namespace App\States;

class CancelledOrderState extends OrderState
{
    // Этот стейт никуда перейти не может
    protected array $allowedTransitions = [];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return 'cancelled';
    }

    public function humanValue(): string
    {
        return 'Отменён';
    }
}
