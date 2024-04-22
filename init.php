<?php

session_start();

define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once __ROOT__ . "/vendor/autoload.php";


// ENV
$dotenv = Dotenv\Dotenv::createImmutable(__ROOT__);
$dotenv->load();


// DB setup
R::setup($_ENV['DB_CONNECTION']);


// init core script
$core = new \Simplicity\Core\Core();
