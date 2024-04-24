<?php

declare(strict_types=1);

namespace Simplicity\Template\Model;

use Simplicity\Core\DataAbstraction\Model;

class TemplateModel extends Model
{
    protected string $name;
    protected string $path;
    protected bool $active;

    private function __construct(int $id = 0)
    {
        parent::__construct('template');

        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    protected function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'active' => $this->active
        ];
    }

    protected function fromArray(array $data): void
    {
        $this->name = $data['name'];
        $this->path = $data['path'];
        $this->active = $data['active'] === 1;
    }

    protected function load(): void
    {
        $this->fromArray(parent::loadOrCreate());
    }

    public static function getCurrent(): self
    {
        $data = parent::findOne(['active' => true], 'theme');

        $model = new self((int)$data['id']);
        $model->fromArray($data);

        return $model;
    }
}
