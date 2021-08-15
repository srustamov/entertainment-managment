<?php

namespace App\Exceptions;

use App\Components\Api;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
            ->setCode($this->isHttpException($e) ? $e->getStatusCode() : 400)
            ->setError([
                    'message' => $message = $this->isHttpException($e)
                        ? (Response::$statusTexts[$e->getStatusCode()] ?? "")
                        : $e->getMessage(),
                    'line' => $e->getLine(),
                    'code' => $this->isHttpException($e) ? $e->getStatusCode() : 400,
                    'exception' => class_basename($e),
                ] + (config('app.debug') ? [
                    'trace' => $e->getTrace(),
                    'file' => $e->getFile(),
                ] : []))
            ->setMessage($message);
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|Api|JsonResponse|Response
    {
        if (!$request->is('nova*')) {
            return $this->renderException($e);
        }
        return parent::render($request,$e);
    }
}
