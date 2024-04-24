<?php

declare(strict_types=1);

namespace Simplicity\Template\View;

interface Component
{
    public function render(): string;
}
