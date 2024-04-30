<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require(dirname(__DIR__) . '/vendor/autoload.php');


use Bojan\PhpGrapejs\Container\Container;
use Bojan\PhpGrapejs\Posts\ApiPostController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();
$strategy = new JsonStrategy($responseFactory);

$router = new Router;
$router->setStrategy($strategy);

$container = new Container();
$router->getStrategy()->setContainer($container);

$router->group('/api', function (RouteGroup $group) {
    $group->get('bojan', [ApiPostController::class, 'index']);
});

try {
    $response = $router->dispatch($request);
} catch (Exception $exception) {
    dd($exception->getMessage());
}

(new SapiEmitter)->emit($response);