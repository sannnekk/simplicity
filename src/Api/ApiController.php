<?php

declare(strict_types=1);

namespace Simplicity\Api;

use Simplicity\Core\Request\Controller;

class ApiController extends Controller
{
    public function __construct($request)
    {
        parent::__construct($request);
    }

    public function resolve(): void
    {
        echo "ApiController::resolve() called\n";
        echo "<hr><pre>";
        print_r($this->request);
        echo "</pre>";
    }
}
