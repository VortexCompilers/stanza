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

$sql = "INSERT INTO users (name, email, birthdate, gender, password_hash) VALUES (?,?,?,?,?)";

$stmt = $pdo-> prepare($sql);

$stmt->execute([
    $username, $email, $birthdate, $gender, $password_hash,
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['role'] = 'reader';

header('Location: /stanza/frontend/home.php');
exit;