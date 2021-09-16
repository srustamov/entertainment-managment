<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }

        Request::macro('getFilters',function (){

            $filters =  $this->get('filters',[]);

            if (is_string($filters)) {
                $filters = json_decode($filters,true);
            }

            if (Arr::accessible($filters) && Arr::isAssoc($filters)) {
                return $filters;
            }
        });

    }
}
