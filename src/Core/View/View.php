<?php

declare(strict_types=1);

namespace Simplicity\Core\View;

abstract class View
{
    public function render(object $context, string $template): void
    {
        $this->renderHeader();
        $this->renderBody($context, $template);
        $this->renderFooter();
    }
}
