<?php

declare(strict_types=1);

namespace Simplicity\Template\Service;

use Simplicity\Template\Context\TemplateContext;
use Simplicity\Template\Model\TemplateModel;

class TemplateService
{
    private TemplateContext $context;

    public function __construct()
    {
        $this->context = new TemplateContext();
    }

    public function getCurrentModel(): TemplateModel
    {
        return TemplateModel::getCurrent();
    }
}
