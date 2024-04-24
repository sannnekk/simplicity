<?php

declare(strict_types=1);

namespace Simplicity\Core;

use Simplicity\Admin\AdminController;
use Simplicity\Core\Request\Controller;
use Simplicity\Template\TemplateController;
use Simplicity\Api\ApiController;
use Simplicity\Core\Request\Request;

class RootController extends Controller
{
    private const ROUTES = [
        "admin" => AdminController::class,
        "api" => ApiController::class
    ];

    private const FALLBACK_ROUTE = TemplateController::class;

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function resolve(): void
    {
        $urlParts = $this->request->getUriParts();

        if (empty($urlParts)) {
            $urlParts = [""];
        }

        if (array_key_exists($urlParts[0], self::ROUTES)) {
            $subRequest = $this->request->subRequest();
            $controller = self::ROUTES[$urlParts[0]];
        } else {
            $subRequest = $this->request;
            $controller = self::FALLBACK_ROUTE;
        }

        $controller = new $controller($subRequest);
        $controller->resolve();
    }
}
