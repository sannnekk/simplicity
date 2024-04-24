<?php

declare(strict_types=1);

namespace Simplicity\Core\Exception;

use Exception;

class SimplicityException extends Exception
{
    public function __construct(
        string $message = self::class,
        int $code = 500,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
