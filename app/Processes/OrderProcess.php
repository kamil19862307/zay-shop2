<?php

namespace App\Processes;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Support\Transaction;
use DomainException;
use Illuminate\Pipeline\Pipeline;
use Throwable;

final class OrderProcess
{
    // Все процессы, которые будут передаваться
    protected array $processes = [];

    // Новый заказ со статусом new
    public function __construct(protected Order $order)
    {
    }

    public function processes(array $processes): self
    {
        $this->processes = $processes;

        return $this;
    }

    // Метод будет запускать процессы и вернёт трансформированный заказ

    /**
     * @throws Throwable
     */
    public function run(): Order
    {
        return Transaction::run(function (){
            return app(Pipeline::class)
                ->send($this->order)
                ->through($this->processes)
                ->thenReturn();
            },

            // Если все процессы выполнились, транзакции прошли
            function(Order $order){
                flash()->info('Good #' . $order->id);

                event(new OrderCreated($order));
            },

            // Если выпало исключение
            function(Throwable $e){
                throw new DomainException($e->getMessage());
            }
        );
    }
}
