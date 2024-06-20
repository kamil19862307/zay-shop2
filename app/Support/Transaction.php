<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\DB;

class Transaction
{
    public static function run(
        // Что делать внутри транзакции
        Closure $callback,

        // Если транзакция успешно выполнилась
        Closure $finished,

        // Если выпало исключение
        Closure $onError
    )
    {
        try {
            DB::beginTransaction();

            $result = $callback();

            DB::commit();

            if (!is_null($finished)){
                $finished($result);
            }

            return $result;

        }catch (\Throwable $e){
            DB::rollBack();

            if (!is_null($onError)){
                $onError($e);
            }

            throw $e;
        }
    }
}
