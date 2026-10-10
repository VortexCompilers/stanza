<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

require_once __DIR__ . '/config/database.php';

$username = $_POST['username'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$email = $_POST['email'];
$password = $_POST['password'];

$avatar_image = 'default.jpg';

if (isset($_FILES['avatar_image']) && $_FILES['avatar_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['avatar_image']['error'] !== UPLOAD_ERR_OK) {
       header('Location: ../frontend/landing.php?erro=upload_falhou&modal=register');
        exit;
    }

    $allowedTypes = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $detectedType = mime_content_type($_FILES['avatar_image']['tmp_name']);

    if (!isset($allowedTypes[$detectedType])) {
        header('Location: ../frontend/landing.php?erro=formato_invalido&modal=register');
        exit;
    }

    $fileName = bin2hex(random_bytes(8)) . '.' . $allowedTypes[$detectedType];
    $destination = __DIR__ . '/../frontend/img/uploads/' . $fileName;

    if (!move_uploaded_file($_FILES['avatar_image']['tmp_name'], $destination)) {
        header('Location: ../frontend/landing.php?erro=upload_falhou&modal=register');
        exit;
    }

    $avatar_image = $fileName;
}

if (empty($username) || empty($gender) || empty($birthdate) || empty($email) || empty($password)) {
    header('Location: ../frontend/landing.php?erro=campo_vazio&modal=register');
    exit;
}

$sql = "SELECT id FROM users WHERE email = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
$email
]);

if ($stmt->fetch()) {
    header('Location: ../frontend/landing.php?erro=email_duplicado&modal=register');
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, birthdate, gender, password_hash, avatar_image) VALUES (?,?,?,?,?,?)";

$stmt = $pdo-> prepare($sql);

$stmt->execute([
    $username, $email, $birthdate, $gender, $password_hash, $avatar_image
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['role'] = 'reader';

header('Location: /stanza/frontend/home.php');
exit;