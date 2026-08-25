<?php

declare(strict_types=1);

use App\Models\Text;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App as SlimApp;

require_once __DIR__ . '/../Services/MlClient.php';

return function (SlimApp $app) {
    $app->post('/texts', function (Request $request, Response $response) {
        $dados = $request->getParsedBody();

        $text = Text::create([
            'author_id' => (int) $dados['author_id'],
            'title' => $dados['title'],
            'body' => $dados['body'],
            'description' => $dados['description'],
            'category' => $dados['category'],
            'cover_image' => $dados['cover_image'] ?? null,
            'visibility' => $dados['visibility'] ?? 'public',
        ]);

        try {
            mlAdicionar($text->id, $text->body);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode([
                'erro' => 'Texto salvo, mas falhou ao indexar na API de ML: ' . $e->getMessage(),
                'text' => $text,
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(502);
        }

        $response->getBody()->write(json_encode(['text' => $text]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    });

    $app->post('/search', function (Request $request, Response $response) {
        $dados = $request->getParsedBody();
        $query = $dados['query'] ?? '';
        $k = isset($dados['k']) ? (int) $dados['k'] : 5;

        try {
            $resultadoMl = mlBuscar($query, $k);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(502);
        }

        $ids = array_column($resultadoMl['results'] ?? [], 'id');
        $scoresPorId = array_column($resultadoMl['results'] ?? [], 'score', 'id');

        $textos = Text::whereIn('id', $ids)->get()->keyBy('id');

        $resultados = [];
        foreach ($ids as $id) {
            if (isset($textos[$id])) {
                $texto = $textos[$id]->toArray();
                $texto['score'] = $scoresPorId[$id];
                $resultados[] = $texto;
            }
        }

        $response->getBody()->write(json_encode(['results' => $resultados]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
