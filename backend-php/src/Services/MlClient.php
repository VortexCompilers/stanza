<?php

function mlAdicionar(int $id, string $texto): array
{
    return mlChamarApi('/add', [
        'id' => $id,
        'texto' => $texto,
    ]);
}

function mlBuscar(string $query, int $k = 20): array
{
    return mlChamarApi('/search', [
        'query' => $query,
        'k' => $k,
    ]);
}

function mlChamarApi(string $endpoint, array $dados): array
{
    $baseUrl = $_ENV['ML_ENGINE_URL'] ?? 'http://127.0.0.1:8000';
    $url = $baseUrl . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

    $resposta = curl_exec($ch);
    echo '<pre>';
    var_dump($resposta);
    echo '</pre>';
    
    if (curl_errno($ch)) {
        throw new Exception('Erro ao chamar a API: ' . curl_error($ch));
    }

    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   
    if ($statusCode !== 200) {
        throw new Exception("API retornou status $statusCode: $resposta");
    }

    return json_decode($resposta, true);
}