<?php


use App\Components\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\Pure;

#[Pure]
function api($data = [], $success = true, $code = 200, array $extra = []): Api
{
    return Api::make(...func_get_args());
}
