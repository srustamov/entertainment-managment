<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

        Builder::macro('whereDateBetween',function ($column ,$date) {
            $column = Str::contains($column, '.') ? $column : new Expression($this->grammar->wrap($column));
            [$from, $to] = $date;
            $from = $from instanceof Carbon ? $from->format('Y-m-d') : $from;
            $to   = $to instanceof Carbon ? $to->format('Y-m-d'): $to;
            if ($from === $to) {
                $this->whereDate($column, $from);
            } else {
                $this->whereDate($column, '>=', $from)->whereDate($column, '<=', $to);
            }
            return $this;
        });

        Request::macro('getFilters',function (){

            $filters =  $this->get('filters',[]);

            if (is_string($filters)) {
                $filters = json_decode($filters,true);
            }

            if (Arr::accessible($filters) && Arr::isAssoc($filters)) {
                return $filters;
            }

            return [];
        });

    }
}
