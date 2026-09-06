<?php 
require '../backend-php/src/Services/MlClient.php';

$query = $_GET['search'] ?? '';

if (trim($query) === '') {
    // empty search
    header('Location: /');
    exit;
}

$data = mlBuscar($query, 20);


echo '<pre>';
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo '</pre>';













?>