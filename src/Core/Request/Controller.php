<?php

declare(strict_types=1);

namespace Simplicity\Core\Request;

use Simplicity\Core\Exception\SimplicityException;

abstract class Controller
{
    protected readonly Request $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    abstract public function resolve(): void;

    protected function dieWithException(SimplicityException $e): void
    {
        $contentType = $this->request->getContentType();

        if ($contentType === 'application/json') {
            header('Content-Type: application/json');
            die(json_encode([
                'error' => $e->getMessage()
            ]));
        }

        header('Content-Type: text/html');
        die($e->getMessage());
    }
}
