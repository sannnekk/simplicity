<?php

declare(strict_types=1);

namespace Simplicity\Core\Migration\Utils;

class MigrationManager
{
    private const MIGRATION_DIRECTORIES = [
        [
            "namespace" => "Simplicity\\Core\\Migration",
            "path" => "src/Core/Migration"
        ]
    ];

    public function run(Migration $migration): void
    {
        $migration->up();
    }

    public function rollback(Migration $migration): void
    {
        $migration->down();
    }

    public function getAll(): array
    {
        $migrations = [];

        foreach (self::MIGRATION_DIRECTORIES as $directory) {
            $files = scandir($directory['path']);

            if ($files === false) {
                throw new \Exception('Could not read migration directory');
            }

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $class = $directory['namespace'] . '\\' . str_replace('.php', '', $file);

                if (!class_exists($class)) {
                    continue;
                }

                $migrations[] = new $class();
            }
        }

        usort($migrations, function (Migration $a, Migration $b) {
            return $a->getTimestamp() <=> $b->getTimestamp();
        });

        return $migrations;
    }
}
