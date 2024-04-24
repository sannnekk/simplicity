<?php

declare(strict_types=1);

namespace Simplicity\Core;

use Simplicity\Core\Request\Request;
use Simplicity\Core\Request\HttpMethod;

class Core
{
    private readonly Request $request;
    private RootController $controller;

    public function __construct()
    {
        $this->request = new Request(
            $_SERVER['REQUEST_URI'],
            $this->getRequestMethod(),
            $_GET,
            $_POST,
            getallheaders(),
            json_decode(file_get_contents('php://input'))
        );

        $this->controller = new RootController($this->request);
        $this->controller->resolve();
    }

    private function getRequestMethod(): HttpMethod
    {
        return match ($_SERVER['REQUEST_METHOD']) {
            'GET' => HttpMethod::GET,
            'POST' => HttpMethod::POST,
            'PUT' => HttpMethod::PUT,
            'DELETE' => HttpMethod::DELETE,
            'PATCH' => HttpMethod::PATCH,
            'OPTIONS' => HttpMethod::OPTIONS,
            'HEAD' => HttpMethod::HEAD,
            default => HttpMethod::UNKNOWN,
        };
    }
}
