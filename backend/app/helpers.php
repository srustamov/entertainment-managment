<?php


use App\Components\Api;
use JetBrains\PhpStorm\Pure;

#[Pure]
function api($data = [], $success = true, $code = 200, array $extra = []): Api
{
    return Api::make(...func_get_args());
}
