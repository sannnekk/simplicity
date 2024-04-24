<?php

declare(strict_types=1);

namespace Simplicity\Template;

use Simplicity\Template\Model\TemplateModel;

class TemplateRouter
{
    private array $routes = [];
    private const RESERVED_ROUTES = [
        '.',
        '..',
        'header',
        'footer',
    ];

    private TemplateModel $model;
    private const TEMPLATE_DIR = __ROOT__ . "/src/Themes/";

    public function __construct()
    {
    }

    public function buildRoutes(TemplateModel $tempateModel)
    {
        $this->model = $tempateModel;

        $path = self::TEMPLATE_DIR . $this->model->getPath();
        $glob = $path . '/*.template.php';

        $files = glob($glob);

        if ($files === false) {
            return [];
        }

        foreach ($files as $file) {
            $filename = basename($file);
            $route = str_replace('.template.php', '', $filename);

            if (in_array($route, self::RESERVED_ROUTES)) {
                continue;
            }

            $this->routes[$route] = $file;
        }
    }

    public function getCurrentFile($request): string|null
    {
        $uri = $request->getUri();

        if ($uri === '') {
            $uri = 'index';
        }

        if (!array_key_exists($uri, $this->routes)) {
            return null;
        }

        $filename = $this->routes[$uri];

        return $filename;
    }
}
