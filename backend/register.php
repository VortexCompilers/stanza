<?php

require_once __DIR__ . '/config/database.php';

$username = $_POST['username'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($username) || empty($gender) || empty($birthdate) || empty($email) || empty($password)) {
    header('Location: ../frontend/register.php?erro=campo_vazio');
    exit;
}

$sql = "SELECT id FROM users WHERE email = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
$email
]);

if ($stmt->fetch()) {
    header('Location: ../frontend/register.php?erro=email_duplicado');
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

header('Location: ../frontend/home.php');
exit;