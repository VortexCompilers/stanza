<?php

require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$author_id = $_SESSION['user_id'];
$title = $_POST['title'] ?? '';
$description = $_POST['desc'] ?? '';
$category = $_POST['category'] ?? '';
$body = ''; // o corpo é escrito na tela de edição, logo depois deste cadastro
$cover_image = null; // capa é opcional (DEFAULT NULL no schema)

// VALIDAR A COVER IMAGE

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    // não confia no 'type' que o navegador mandou — verifica o conteúdo real do arquivo
    $tiposPermitidos = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $tipoReal = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($tiposPermitidos[$tipoReal])) {
        header('Location: ../frontend/create.php?erro=formato_invalido');
        exit;
    }

    // não usa o 'name' original (pode ter path traversal, caracteres estranhos, colisão de nomes)
    $nomeArquivo = bin2hex(random_bytes(8)) . '.' . $tiposPermitidos[$tipoReal];
    $destino = __DIR__ . '/../frontend/img/uploads/' . $nomeArquivo;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destino)) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    $cover_image = $nomeArquivo; // só isso vai pro INSERT
}

$visibility = $_POST['visibility'] ?? '';

$language = $_POST['language'] ?? '';
if ($language === '') {
    $language = null;
}

if (empty($title) || empty($description) || empty($category) || empty($visibility)) {
    header('Location: ../frontend/create.php?erro=campo_vazio');
    exit;
}

try {
    $sql = 'INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language) VALUES (?,?,?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$author_id, $title, $body, $description, $category, $cover_image, $visibility, $language]);
} catch (PDOException $e) {
    error_log($e->getMessage()); 
    header('Location: ../frontend/create.php?erro=erro_interno');
    exit;
}

header('Location: ../frontend/edit.php?id=' . $pdo->lastInsertId());
exit;