<?php

namespace oblegation\container\exception;

use Exception;
use Throwable;

class TypeMatchException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}