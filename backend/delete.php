<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

try {
    $stmt = $pdo->prepare('DELETE FROM texts WHERE id = :id AND author_id = :author_id');
    $stmt->execute([
        ':id'        => $id,
        ':author_id' => $_SESSION['user_id'],
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=erro_interno');
    exit;
}

if ($stmt->rowCount() === 0) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}

header('Location: ../frontend/catalog.php?msg=texto_apagado');
exit;
