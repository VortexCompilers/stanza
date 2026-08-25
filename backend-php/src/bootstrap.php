<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\App as SlimApp;
use Slim\Factory\AppFactory;

function bootDatabase(): void
{
    $capsule = new Capsule();

    $capsule->addConnection([
        'driver' => 'mysql',
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'database' => $_ENV['DB_NAME'] ?? 'stanza',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
}

function createApp(): SlimApp
{
    bootDatabase();

    $app = AppFactory::create();
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $app->setBasePath(
        rtrim(str_replace('/index.php', '', $scriptName), '/')
    );
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware((bool) ($_ENV['APP_DEBUG'] ?? false), true, true);

    (require __DIR__ . '/Routes/api.php')($app);

    return $app;
}
