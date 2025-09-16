<?php
declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use Nullstate\Core\App;
use Nullstate\Router\Router;


new App();

$router = new Router();
$router->get('/', [\Nullstate\Controllers\HomeController::class, 'index']);
$router->dispatch();