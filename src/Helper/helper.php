<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

$dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__) . '/../');
$dotenv->load();

if (!function_exists('view')) {
    function view(string $path, array $data = []): ResponseInterface {
        $baseDir = dirname(__DIR__) . '/../templates/';
        $blade = new Blade($baseDir . 'views', $baseDir . 'cache');

        $response = new Response();
        $response->getBody()->write($blade->make($path, $data)->render());
        return $response;
    }
}
