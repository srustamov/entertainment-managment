<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            return api([])
                ->setCode(Response::HTTP_PAYMENT_REQUIRED)
                ->notOk()
                ->setMessage(trans('app.subscription_expired'));
        }

        return $next($request);
    }
}
