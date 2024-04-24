<?php

declare(strict_types=1);

namespace Simplicity\Core\Exception;

class NotFoundException extends SimplicityException
{
    public function __construct(
        string $message = self::class,
        int $code = 404,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
