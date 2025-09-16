<?php
declare(strict_types=1);

namespace Nullstate\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

final class Database
{
    public static function boot(): void
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'host'      => $_ENV['DB_HOST'] ?? 'localhost',
            'port'      => $_ENV['DB_PORT'] ?? '3306',
            'database'  => $_ENV['DB_DATABASE'] ?? '',
            'username'  => $_ENV['DB_USERNAME'] ?? '',
            'password'  => $_ENV['DB_PASSWORD'] ?? '',
            'charset'   => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            'collation' => $_ENV['DB_COLLATION'] ?? 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);

        // Make Capsule available globally (optional) and boot Eloquent
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}