<?php
declare(strict_types=1);

namespace Nullstate\Core;

use Dotenv\Dotenv;
use Nullstate\Http\Middleware\Csrf;

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

        // Booting services -- 
        $this->bootSession();
        Database::boot(); // Eloquent Capsule
        View::boot();     // Twig
        $this->bootCsrf();  // CSRF + Twig globals
        
    }

    private function bootSession(): void
    {
        session_set_cookie_params([
            'httponly' => true,
            'secure'   => $this->isHttps(),
            'samesite' => 'Lax',
            'path'     => '/',
        ]);
        session_start();
    }
    private function isHttps(): bool
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') return true;
        if (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) return true;
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') return true;
        return false;
    }

    private function bootCsrf(): void
    {
        Csrf::ensure();
        Csrf::verifyPost();

        View::twig()->addGlobal('csrf_token', Csrf::token());
        $flash = \Nullstate\Core\Flash::get();
        if ($flash) {
            View::twig()->addGlobal('flash_alert', $flash);
        }
    }
}