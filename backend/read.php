<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

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

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $reader_id = $_SESSION['user_id'];

    $sql = 'INSERT INTO reading_logs (reader_id, text_id, time_spent_seconds) VALUES (?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reader_id, $id, 0]);
}

$pdo->prepare('UPDATE texts SET read_count = read_count + 1 WHERE id = :id')
    ->execute([':id' => $id]);
?>