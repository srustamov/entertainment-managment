<?php

namespace App\Exceptions;

use App\Components\Api;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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


    public function render($request, Throwable $e): Api
    {
        return $this->renderException($e);
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
                'file' => $e->getFile(),
                'exception' => class_basename($e),
                'trace' => $e->getTrace(),
            ])
            ->setMessage($message);
    }
}
