<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app): void {
    $app->get('/health', function (Request $request, Response $response): Response {
        $response->getBody()->write(json_encode(['status' => 'OK']));

        return $response->withHeader('Content-Type', 'application/json');
    });
};
