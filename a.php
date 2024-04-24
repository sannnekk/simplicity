<?php

require_once 'vendor/autoload.php';

define('__ROOT__', __DIR__);


// ENV
$dotenv = Dotenv\Dotenv::createImmutable(__ROOT__);
$dotenv->load();

// DB setup
\RedBeanPHP\R::setup($_ENV['DB_CONNECTION'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

// init core script
$migrationManager = new \Simplicity\Core\Migration\Utils\MigrationManager();
$migrations = $migrationManager->getAll();

foreach ($migrations as $migration) {
    echo 'Running migration: ' . get_class($migration) . PHP_EOL;
    $migrationManager->run($migration);
}
