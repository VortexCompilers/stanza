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
$id        = (int) ($_POST['id'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT * FROM texts WHERE id = :id AND author_id = :author_id'
);
$stmt->execute([
    ':id'        => $id,
    ':author_id' => $author_id,
]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$text) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}


$title       = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$category    = $_POST['category'] ?? '';
$visibility  = $_POST['visibility'] ?? '';

$body = $_POST['body'] ?? $text['body'];

$language = $_POST['language'] ?? '';
if ($language === '') {
    $language = null;
}

if (empty($title) || empty($description) || empty($category) || empty($visibility)) {
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=campo_vazio');
    exit;
}

$cover_image = $text['cover_image'];

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=upload_falhou');
        exit;
    }


    $tiposPermitidos = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $tipoReal = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($tiposPermitidos[$tipoReal])) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=formato_invalido');
        exit;
    }

   
    $nomeArquivo = bin2hex(random_bytes(8)) . '.' . $tiposPermitidos[$tipoReal];
    $destino = __DIR__ . '/../frontend/img/uploads/' . $nomeArquivo;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destino)) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=upload_falhou');
        exit;
    }

    $cover_image = $nomeArquivo; 
}

try {
    $sql = 'UPDATE texts
            SET title = :title, body = :body, description = :description,
                category = :category, language = :language,
                visibility = :visibility, cover_image = :cover_image
            WHERE id = :id AND author_id = :author_id';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title'       => $title,
        ':body'        => $body,
        ':description' => $description,
        ':category'    => $category,
        ':language'    => $language,
        ':visibility'  => $visibility,
        ':cover_image' => $cover_image,
        ':id'          => $id,
        ':author_id'   => $author_id,
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=erro_interno');
    exit;
}

header('Location: ../frontend/read.php?id=' . $id);
exit;
