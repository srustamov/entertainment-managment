<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NoActiveContractException extends Exception
{
    public function __construct(
        ?string $message = null,
        int $code = Response::HTTP_PAYMENT_REQUIRED,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            $message ?? trans('app.subscription_expired'),
            $code,
            $previous
        );
    }
}
