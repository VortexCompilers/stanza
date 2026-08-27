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

// aqui o id vem da query string porque a exclusão é um link, não um formulário
$id = (int) ($_GET['id'] ?? 0);

try {
    // NUNCA sem WHERE. o author_id garante que só o dono apaga o próprio texto:
    // trocar o ?id= na URL para o texto de outra pessoa não casa com linha nenhuma.
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

// no DELETE o rowCount() é inequívoco (diferente do UPDATE, onde zero pode ser
// "salvou sem mudar nada"): zero aqui significa que o texto não existe ou não é seu
if ($stmt->rowCount() === 0) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}

header('Location: ../frontend/catalog.php?msg=texto_apagado');
exit;
