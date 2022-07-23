<?php
namespace App\Support;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;
use function auth;
use function config;
use function request;
use function response;

class Api implements Arrayable, JsonSerializable, Jsonable, Responsable
{
    public bool $success = true;

    public int $code = 200;

    public ?string $message;

    public mixed $data;

    public mixed $error;

    public Authenticatable $user;

    private bool $debug;


    public function __construct($data = [], $success = true, $code = 200)
    {
        $this->data = $data;

        $this->success = $success;

        $this->code = $code;
    }


    /**
     * @return static
     */
    #[Pure]
    public static function make() : self
    {
        return new static(...func_get_args());
    }

    public function setMessage($message) : static
    {
        $this->message = $message;

        return $this;
    }

    public function setCode($code): static
    {
        $this->code = $code;

        return $this;
    }

    public function ok($bool = true): static
    {
        $this->success = (bool) $bool;

        return $this;
    }

    public function notOk(): static
    {
        $this->success = false;

        return $this;
    }

    public function setError($error): static
    {
        $this->error   = $error;
        $this->success = false;

        return $this;
    }

    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }

    public function setUser($user): static
    {
        $this->user = $user;

        return $this;
    }

    public function enableDebug(): static
    {
        $this->debug = true;

        return $this;
    }


    public function toArray(): array
    {

        $debug = $this->debug ?? config('app.debug');

        $response =  [
            'success' => $this->success,
            'code' => $this->code,
            'data' => $this->data,
            'message' => $this->message ?? "",
            'user' => $this->user ?? auth('api')->user(),
            'error' => $this->error ?? false,
        ];


        if ($debug) {
            $response['debug'] = [
                'request' => [
                    'method' => request()->method(),
                    'params' => request()->all(),
                ],
                'query' => DB::getQueryLog(),
                'route' => Route::getCurrentRoute()?->getAction() ? : request()->path(),
            ];
        }

        return $response;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(),$options);
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json($this->toArray(),$this->code);
    }
}
