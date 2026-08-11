<?php

require_once 'backend-php/src/Services/MlClient.php';

header('Content-Type: application/json');

$acao = $_POST['acao'] ?? null;

try {
    if ($acao === 'adicionar') {
        $id = (int) $_POST['id'];
        $texto = $_POST['texto'];

        $resultado = mlAdicionar($id, $texto);
        echo json_encode($resultado);

    } elseif ($acao === 'buscar') {
        $query = $_POST['query'];
        $k = isset($_POST['k']) ? (int) $_POST['k'] : 5;

        $resultado = mlBuscar($query, $k);
        echo json_encode($resultado);

    } else {
        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}