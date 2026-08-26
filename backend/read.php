<?php
require_once __DIR__ . '/../backend/config/database.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT texts.*, users.name AS author_name
     FROM texts
     JOIN users ON users.id = texts.author_id
     WHERE texts.id = :id'
);
$stmt->execute([':id' => $id]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$text) {
    header('Location: ../frontend/home.php?erro=texto_nao_encontrado');
    exit;
}

$pdo->prepare('UPDATE texts SET read_count = read_count + 1 WHERE id = :id')
    ->execute([':id' => $id]);
?>