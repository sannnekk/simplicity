<?php

declare(strict_types=1);

namespace Simplicity\Template\Context;

class TemplateContextFactory
{
    public function createTemplateContext(): TemplateContext
    {
        return new TemplateContext();
    }
}
