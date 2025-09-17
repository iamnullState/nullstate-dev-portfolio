<?php
declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use Nullstate\Core\App;
use Nullstate\Router\Router;


new App();

$router = new Router();
// home - 127.0.0.1
$router->get('/', [\Nullstate\Controllers\HomeController::class, 'index']);
// about - whois nullstat3
$router->get('/whois', [\Nullstate\Controllers\AboutController::class, 'index']);
// explore
$router->get('/explore', [\Nullstate\Controllers\ExploreController::class, 'index']);
// projects
$router->get('/projects', [\Nullstate\Controllers\ProjectsController::class, 'index']);
// ibkc - itty bitty kitty committee
$router->get('/ibkc', [\Nullstate\Controllers\MeowController::class, 'index']);
// pathway
$router->get('/pathway', [\Nullstate\Controllers\PathwayController::class, 'index']);
// data
$router->get('/data', [\Nullstate\Controllers\DataController::class, 'index']);
// terms
$router->get('/terms', [\Nullstate\Controllers\TermsController::class, 'index']);
// updates
$router->get('/updates', [\Nullstate\Controllers\UpdatesController::class, 'index']);


$router->dispatch();