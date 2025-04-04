<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Base\Entities\MemberPointHistories;
use Modules\Base\Observers\MemberPointHistoryObserve;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $observerMapping = [
            MemberPointHistories::class => MemberPointHistoryObserve::class,
        ];

        foreach ($observerMapping as $model => $observer) {
            $model::observe($observer);
        }
    }
}
