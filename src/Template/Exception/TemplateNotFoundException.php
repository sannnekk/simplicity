<?php

declare(strict_types=1);

namespace Simplicity\Template\Exception;

use Simplicity\Core\Exception\NotFoundException;

class TemplateNotFoundException extends NotFoundException
{
    public function __construct(
        string $message = self::class,
        int $code = 404,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
