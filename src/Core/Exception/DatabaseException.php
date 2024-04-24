<?php

declare(strict_types=1);

namespace Simplicity\Core\Exception;

class DatabaseException extends SimplicityException
{
    public function __construct(string $message, int $code = 500, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
