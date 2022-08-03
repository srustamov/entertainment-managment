<?php

use App\Eloquent\Traits\Filterable;
use App\Enums\Casts;
use App\Models\User;
use App\Support\Api;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\Pure;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\Includes\IncludeInterface;

#[Pure]
function api($data = [], bool $success = true, int $code = 200): Api
{
    return Api::make(...func_get_args());
}

/** @noinspection PhpIncompatibleReturnTypeInspection */
function user(): ?User
{
    return auth('api')->user();
}


function isFilterable($model): bool
{
    try {
        return in_array(
            Filterable::class,
            class_uses_recursive($model)
        );
    } catch (Exception) {
        return false;
    }
}


/**
 * @throws ValidationException
 */
function validationException(array $messages = [])
{
    throw ValidationException::withMessages($messages);
}

function responseException($response)
{
    if (is_object($response) && method_exists($response, 'toResponse')) {
        $response = $response->toResponse();
    }
    throw new HttpResponseException($response);
}


function cast(mixed $value, Casts|string $type): mixed
{
    $stringCaster = function ($value): string {
        if ((is_array($value) || is_object($value))) {
            return json_encode($value);
        }

        if ($value === true) return 'true';
        if ($value === false) return 'false';

        return (string)$value;
    };

    $arrayCaster = function ($value): array {
        if (is_string($value)) {
            $result = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return (array)$result;
            }
            $result = json_decode("[$value]", true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return (array)$result;
            }
        }
        return (array)$value;
    };


    $result = match ($type) {
        Casts::INT, Casts::INTEGER => (int)$value,
        Casts::DECIMAL, Casts::DOUBLE, Casts::FLOAT => (float)$value,
        Casts::STRING => $stringCaster($value),
        Casts::ARRAY => $arrayCaster($value),
        Casts::OBJECT => (object)$value,
        Casts::BOOL, Casts::BOOLEAN => (bool)$value,
        default => $value
    };


    if (is_string($type) && str_starts_with($type, 'datetime')) {

        [, $format] = explode(':', $type, 2);

        $date = Carbon::parse($result);

        return $format ? $date->format($format) : $date->toDateTimeString();

    }

    return $result;

}

function multi_cast(array $values, Casts|string $type): array
{
    foreach ($values as $key => $value) {
        $values[$key] = cast($value, $type);
    }

    return $values;
}



function useIncludeFilter($name,Closure $callback): Collection
{
    return AllowedInclude::custom($name,new class($callback) implements IncludeInterface{

        public function __construct(private $callback){}

        public function __invoke($query, string $include)
        {
            $callback  = $this->callback;

            return $callback($query,$include);
        }
    });
}
