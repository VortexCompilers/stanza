<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class HealthTest extends TestCase
{
    public function testHealthReturnsOk(): void
    {
        $app = \App\createApp();

        $request = (new ServerRequestFactory())->createServerRequest('GET', '/health');
        $response = $app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(
            ['status' => 'OK'],
            json_decode((string) $response->getBody(), true)
        );
    }
}
