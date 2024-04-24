<?php

declare(strict_types=1);

namespace Simplicity\Core\DataAbstraction;

use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use Simplicity\Core\Exception\NotFoundException;
use Simplicity\Core\Exception\SimplicityException;
use Simplicity\Core\Exception\DatabaseException;

abstract class Model
{
    protected int $id;
    protected string $__entityName;

    private OODBBean $bean;

    public function __construct(string $entityName)
    {
        $this->id = 0;
        $this->__entityName = $entityName;
    }

    public function store(): void
    {
        try {
            if ($this->id === 0) {
                $this->bean = R::dispense($this->__entityName);
            }

            $this->bean->import($this->toArray());
            $this->id = R::store($this->bean);
        } catch (\Exception $e) {
            if ($e instanceof SimplicityException) {
                throw $e;
            } else {
                throw new DatabaseException('Database error');
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract protected function toArray(): array;

    abstract protected function load(): void;

    protected static function findOne(array $where, string $entityName): array
    {
        try {
            $condition = self::getCondition($where);
            $bean = R::findOne($entityName, $condition['where'], $condition['values']);

            if ($bean === null) {
                throw new NotFoundException();
            }

            return $bean->export();
        } catch (\Exception $e) {
            if ($e instanceof SimplicityException) {
                throw $e;
            } else {
                throw new DatabaseException('Database error');
            }
        }
    }

    protected static function findAll(array $where, string $entityName): array
    {
        try {
            $condition = self::getCondition($where);
            $beans = R::find($entityName, $condition['where'], $condition['values']);

            if ($beans === null) {
                throw new NotFoundException();
            }

            return R::exportAll($beans);
        } catch (\Exception $e) {
            if ($e instanceof SimplicityException) {
                throw $e;
            } else {
                throw new DatabaseException('Database error');
            }
        }
    }

    protected function loadOrCreate(): array
    {
        try {
            $bean = R::load($this->__entityName, $this->id);

            if ($bean === null) {
                throw new NotFoundException();
            }

            $this->bean = $bean;

            return $this->bean->export();
        } catch (\Exception $e) {
            if ($e instanceof SimplicityException) {
                throw $e;
            } else {
                throw new DatabaseException('Database error');
            }
        }
    }

    private static function getCondition(array $where): array
    {
        $conditions = [];

        foreach ($where as $key => $value) {
            $conditions[] = " $key = ? ";
        }

        return [
            'where' => implode(' AND ', $conditions),
            'values' => array_values($where)
        ];
    }
}
