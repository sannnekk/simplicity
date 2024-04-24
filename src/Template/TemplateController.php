<?php

declare(strict_types=1);

namespace Simplicity\Template;

use Simplicity\Core\Request\Controller;
use Simplicity\Template\Service\TemplateService;
use Simplicity\Template\Context\TemplateContextFactory;
use Simplicity\Template\Context\TemplateContext;
use Simplicity\Template\Model\TemplateModel;
use Simplicity\Template\Exception\TemplateNotFoundException;

class TemplateController extends Controller
{
    private TemplateModel $templateModel;

    private TemplateRouter $router;
    private TemplateService $templateService;
    private TemplateContext $templateContext;
    private TemplateContextFactory $templateContextFactory;

    public function __construct($request)
    {
        parent::__construct($request);

        $this->templateService = new TemplateService();
        $this->router = new TemplateRouter();
        $this->templateContextFactory = new TemplateContextFactory();
    }

    public function resolve(): void
    {
        $this->templateModel = $this->templateService->getCurrentModel();
        $this->router->buildRoutes($this->templateModel);

        $route = $this->router->getCurrentFile($this->request);

        if ($route === null) {
            $this->dieWithException(new TemplateNotFoundException('Template not found'));
        }

        $this->templateContext = $this->templateContextFactory->createTemplateContext();
        $this->render($route);
    }

    private function render(string $route): void
    {
        ob_start();

        $context = $this->templateContext;

        include $route;

        ob_flush();
    }
}
