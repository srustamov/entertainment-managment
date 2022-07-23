<?php


use App\Support\Api;
use JetBrains\PhpStorm\Pure;

#[Pure]
function api($data = [], $success = true, $code = 200): Api
{
    return Api::make(...func_get_args());
}


/** @noinspection PhpIncompatibleReturnTypeInspection */
function user() : ?\App\Models\User
{
    return auth('api')->user();
}
