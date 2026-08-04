<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MlClient
{
    private Client $client;

    public function __construct(?string $baseUri = null)
    {
        $this->client = new Client([
            'base_uri' => $baseUri ?? ($_ENV['ML_ENGINE_URL'] ?? 'http://localhost:8000'),
            'timeout' => 5.0,
        ]);
    }

    /**
     * @return int[] recommended text IDs, empty when the ML engine is unreachable
     */
    public function recommend(int $textId): array
    {
        try {
            $response = $this->client->post('/recomendar', [
                'json' => ['text_id' => $textId],
            ]);
        } catch (GuzzleException) {
            return [];
        }

        $data = json_decode((string) $response->getBody(), true);

        return $data['recommendations'] ?? [];
    }
}
