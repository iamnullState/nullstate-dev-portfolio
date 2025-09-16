<?php
declare(strict_types=1);

namespace Nullstate\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class View
{
    private static ?Environment $twig = null;

    public static function boot(): void
    {
        $loader = new FilesystemLoader(dirname(__DIR__, 2).'/templates');
        self::$twig = new Environment($loader, [
            'cache' => false, // set to storage/cache/twig in prod
            'autoescape' => 'html',
            'debug' => ($_ENV['APP_DEBUG'] ?? 'false') === 'true',
        ]);
    }

    public static function render(string $template, array $data = []): void
    {
        if (!self::$twig) {
            self::boot();
        }
        echo self::$twig->render($template, $data);
    }

    public static function twig(): Environment
    {
        if (!self::$twig) {
            self::boot();
        }
        return self::$twig;
    }
}