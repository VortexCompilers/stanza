<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/../backend-php/src/Services/MlClient.php';

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
$body = ''; 
$cover_image = null; 
$embedding_text = implode('. ', array_filter([
    $title,
    $description
]));

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    $tiposPermitidos = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $tipoReal = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($tiposPermitidos[$tipoReal])) {
        header('Location: ../frontend/create.php?erro=formato_invalido');
        exit;
    }

  
    $nomeArquivo = bin2hex(random_bytes(8)) . '.' . $tiposPermitidos[$tipoReal];
    $destino = __DIR__ . '/../frontend/img/uploads/' . $nomeArquivo;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destino)) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    $cover_image = $nomeArquivo; 
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
    $id = (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
    error_log($e->getMessage()); 
    header('Location: ../frontend/create.php?erro=erro_interno');
    exit;
}

if ($visibility === "public") { mlAdicionar( $id, $embedding_text );}

header('Location: ../frontend/edit.php?id=' . $id);
exit;