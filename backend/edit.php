<?php

require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT * FROM texts WHERE id = :id AND author_id = :author_id'
);
$stmt->execute([
    ':id'        => $id,
    ':author_id' => $_SESSION['user_id'],
]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$text) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}
