<?php

declare(strict_types=1);

require(dirname(__DIR__) . '/vendor/autoload.php');

use Bojan\PhpGrapejs\Container\Container;
use Bojan\PhpGrapejs\Middleware\AuthMiddleware;
use Bojan\PhpGrapejs\Posts\PostController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new Router;
$strategy = new ApplicationStrategy();

$router->setStrategy($strategy);
$container = new Container();

$router->getStrategy()->setContainer($container);

$router->group('/', function (RouteGroup $group) {
    $group->get('posts', [PostController::class, 'index']);
})->middleware($container->get(AuthMiddleware::class));

$router->get('render-view', function () {
    return view('index', ['name' => 'John Doe']);
})->middleware($container->get(AuthMiddleware::class));

try {
    $response = $router->dispatch($request);
} catch (Exception $exception) {
    dd($exception->getMessage());
}

(new SapiEmitter)->emit($response);