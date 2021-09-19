<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscribeContractCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth('api')->user()->location->activeContract()->exists()) {
            return api([])->setCode(400)->notOk()->setMessage('Abunəliyiniz bitmişdir');
        }
        return $next($request);
    }
}
