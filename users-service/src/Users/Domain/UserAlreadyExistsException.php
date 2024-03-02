<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\DomainException;
use Throwable;

final class UserAlreadyExistsException extends DomainException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "" === $message ? "User already exists" : $message;

        parent::__construct($message, $code, $previous);
    }
}
