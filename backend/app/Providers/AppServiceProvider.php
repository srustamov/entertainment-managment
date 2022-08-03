<?php

namespace App\Providers;

use App\Models\Setting;
use App\Support\Api;
use App\Support\Interfaces\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrentUser::class, fn () => user());

        if (!$this->app->runningInConsole()) {
            $this->app->bind('api', function () {
                return Api::make()
                    ->setRequest($this->app->make(Request::class))
                    ->setDebug(config('app.debug'));
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //$settings = Setting::all()->pluck('value','key');

        //app()->setLocale($settings['default_locale'] ?? 'en');

        if (config('app.debug')) {
            DB::enableQueryLog();
        }

        Request::macro('getFilters', function () {
            $filters = $this->get('filters', []);

            if (is_string($filters)) {
                $filters = json_decode($filters, true);
            }

            if (Arr::accessible($filters) && Arr::isAssoc($filters)) {
                return $filters;
            }

            return [];
        });
    }
}
