<?php

namespace App\Exceptions;

use App\Support\Api;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            return $this->renderException($e);
        });
    }

    private function renderException($e): Api
    {
        return api([])
            ->notOk()
            ->setCode($this->getCode($e))
            ->setError([
                    'message' => $message = $this->isHttpException($e)
                        ? (Response::$statusTexts[$e->getStatusCode()] ?? "")
                        : $e->getMessage(),
                ] + (config('app.debug') ? [
                    'line' => $e->getLine(),
                    'code' => $this->getCode($e),
                    'exception' => class_basename($e),
                    //'trace' => $e->getTrace(),
                    'file' => $e->getFile(),
                ] : []))
            ->setMessage($message);
    }

    public function render($request, Throwable $e): Api|JsonResponse|Response
    {
        if (!$this->isNovaEndpoint($request)) {
            return $this->renderException($e);
        }
        return parent::render($request,$e);
    }



    private function isNovaEndpoint($request): bool
    {
        return Str::startsWith($request->url(),'nova');
    }

    public function getCode($e): int
    {
        if ($this->isHttpException($e)) {
            return $e->getStatusCode();
        }

        if ($e instanceof UnauthorizedHttpException) {
            return 403;
        }

        if ($e instanceof AuthenticationException) {
            return 401;
        }

        return 400;
    }
}
