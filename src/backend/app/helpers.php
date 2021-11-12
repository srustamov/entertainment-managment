<?php


use App\Components\Api;
use JetBrains\PhpStorm\Pure;
use Illuminate\Redis\RedisManager;
use Predis\Client;

#[Pure]
function api($data = [], $success = true, $code = 200, array $extra = []): Api
{
    return Api::make(...func_get_args());
}


/**
 * @param null $key
 * @param null $value
 * @param null $expire
 * @return RedisManager|Client
 */
function redis($key = null, $value = null, $expire = null)
{
    if (func_num_args() == 3) {
        return app('redis')->set($key, $value, 'EX', $expire);
    } elseif ($key != null && $value != null) {
        return app('redis')->set($key, $value);
    } elseif (func_num_args() === 1) {
        return app('redis')->get($key);
    } else {
        return app('redis');
    }
}
