<?php

declare(strict_types=1);

namespace Simplicity\Template\Context;

use Simplicity\Template\Data\TemplateInjector;

class TemplateContext
{
    private array $injectors = [];

    public function __construct()
    {
    }

    public function addInjector(string $key, TemplateInjector $value): void
    {
        $this->injectors[$key] = $value;
    }

    public function inject(): void
    {
        foreach ($this->injectors as $key => $value) {
            $this->$key = $value();
        }
    }

    public function dump()
    {
        var_dump($this);
    }
}
