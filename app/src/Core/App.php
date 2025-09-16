<?php
declare(strict_types=1);

namespace Nullstate\Core;

use Dotenv\Dotenv;

final class App
{
    public function __construct()
    {
        $root = dirname(__DIR__, 2);

        if (file_exists($root.'/.env')) {
            $dotenv = Dotenv::createImmutable($root);
            $dotenv->load();
        }

        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');

        ini_set('display_errors', ($_ENV['APP_DEBUG'] ?? 'false') === 'true' ? '1' : '0');

        // Boot services
        Database::boot(); // Eloquent Capsule
        View::boot();     // Twig
    }
}