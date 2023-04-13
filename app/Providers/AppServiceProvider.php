<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()){
            //Сообщит, если запрос (один имеется ввиду) к базе дольше чем указанное количество миллисекунд.
            //Не забыть узы (use) добавить (3шт)
//            DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
//                logger()
//                    ->channel('telegram')
//                    ->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
//            });

            DB::listen(function ($query)
            {
//                $query->sql;
//                $query->bindings;
//                $query->time;

                if ($query->time > 100){
                    logger()
                        ->channel('telegram')
                        ->debug('DB::listen - запрос дольше указанного времени: ' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function (){
                    logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan' . request()->url());
                }
            );
        }
    }
}
