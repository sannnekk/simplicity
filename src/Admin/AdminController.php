<?php

declare(strict_types=1);

namespace Simplicity\Admin;

use Simplicity\Core\Request\Controller;
use Simplicity\Core\Request\Request;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function resolve(): void
    {
        echo "AdminController::resolve() called\n";
        echo "<hr><pre>";
        print_r($this->request);
        echo "</pre>";
    }
}
