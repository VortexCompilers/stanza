<?php

# VERIFICA SE O USUARIO QUE ESTÁ ACESSANDO TEM ACESSO A ESSE TEXTO
require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

// aqui o id vem da query string porque a tela é aberta por edit.php?id=N (navegação GET).
// quem recebe POST é o update.php, e lá o id vem do campo escondido.
$id = (int) ($_GET['id'] ?? 0);

// a trava de dono está no próprio SQL: ou o texto é seu, ou não volta nada
$stmt = $pdo->prepare(
    'SELECT * FROM texts WHERE id = :id AND author_id = :author_id'
);
$stmt->execute([
    ':id'        => $id,
    ':author_id' => $_SESSION['user_id'],
]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

// não voltou nada = o texto não existe OU não é de quem está pedindo.
// os dois casos dão a mesma resposta de propósito: não confirmamos que o id N existe.
if (!$text) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}
