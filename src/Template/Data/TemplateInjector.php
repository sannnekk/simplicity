<?php

declare(strict_types=1);

namespace Simplicity\Template\Data;

use Simplicity\Template\Context\TemplateContext;

interface TemplateInjector
{
    public function inject(TemplateContext $context): mixed;
}
