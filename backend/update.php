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
$genres = getAllGenres($pdo);
$selectedTags = getSelectedGenreIdsFromPost($genres);
$selectedTagNames = getGenreNamesByIds($genres, $selectedTags);

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


    $allowedTypes = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $detectedType = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($allowedTypes[$detectedType])) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=formato_invalido');
        exit;
    }

   
    $fileName = bin2hex(random_bytes(8)) . '.' . $allowedTypes[$detectedType];
    $destination = __DIR__ . '/../frontend/img/uploads/' . $fileName;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination)) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=upload_falhou');
        exit;
    }

    $cover_image = $fileName;
}

try {
    ensureTagSchema($pdo);
    $pdo->beginTransaction();

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

    syncTextGenres($pdo, $id, $selectedTags);
    $pdo->commit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=erro_interno');
    exit;
}

if ($visibility === 'public') {
    $embedding_text = implode('. ', array_filter([
        $title,
        $description,
        $body,
        ...$selectedTagNames,
    ]));

    mlAdicionar($id, $embedding_text);
}

header('Location: ../frontend/read.php?id=' . $id);
exit;
