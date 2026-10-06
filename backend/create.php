<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/tags.php';
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
$genres = getAllGenres($pdo);
$selectedTags = getSelectedGenreIdsFromPost($genres);
$selectedTagNames = getGenreNamesByIds($genres, $selectedTags);

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    $allowedTypes = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $detectedType = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($allowedTypes[$detectedType])) {
        header('Location: ../frontend/create.php?erro=formato_invalido');
        exit;
    }

  
    $fileName = bin2hex(random_bytes(8)) . '.' . $allowedTypes[$detectedType];
    $destination = __DIR__ . '/../frontend/img/uploads/' . $fileName;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination)) {
        header('Location: ../frontend/create.php?erro=upload_falhou');
        exit;
    }

    $cover_image = $fileName;
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
    // The tag schema is initialized before the transaction because DDL commits implicitly in MariaDB.
    ensureTagSchema($pdo);
    $pdo->beginTransaction();

    $sql = 'INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language) VALUES (?,?,?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$author_id, $title, $body, $description, $category, $cover_image, $visibility, $language]);
    $id = (int) $pdo->lastInsertId();

    syncTextGenres($pdo, $id, $selectedTags);
    $pdo->commit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage()); 
    header('Location: ../frontend/create.php?erro=erro_interno');
    exit;
}

if ($visibility === "public") {
    $embedding_text = implode('. ', array_filter([
        $title,
        $description,
        ...$selectedTagNames,
    ]));

    try {
        mlAdicionar($id, $embedding_text);
    } catch (Throwable $e) {
        // Book creation must not fail when the optional ML service is unavailable.
        error_log('Embedding generation failed for text ' . $id . ': ' . $e->getMessage());
    }
}

header('Location: ../frontend/edit.php?id=' . $id);
exit;
