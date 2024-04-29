<?php

namespace App\StorageIdentities;

use App\Contracts\CartIdentityStorageContract;

final class SessionIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return session()->getId();
    }
}
