<?php

namespace App\Contracts;

interface CartIdentityStorageContract
{
    // Идентификатор стораджа
    public function get(): string;
}
