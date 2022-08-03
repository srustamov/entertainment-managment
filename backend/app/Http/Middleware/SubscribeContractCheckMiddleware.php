<?php

namespace App\Http\Middleware;

use App\Exceptions\NoActiveContractException;
use Closure;
use Illuminate\Http\Request;

class SubscribeContractCheckMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! user()?->location?->activeContract()?->exists()) {
            throw new NoActiveContractException();
        }

        return $next($request);
    }
}
