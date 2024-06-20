<?php

namespace App\Support;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerator
{
    public static function run(Closure $callback = null): void
    {
        $old = session()->getId();

//        request()->session()->invalidate();
        session()->invalidate();

//        request()->session()->regenerateToken();
        session()->regenerateToken();

        if (!is_null($callback))
            $callback();

        event(new AfterSessionRegenerated($old, session()->getId()));
    }
}
