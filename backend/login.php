<?php

require_once __DIR__ . '/config/database.php';

$username_or_email = $_POST['usernameoremail'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username_or_email) || empty($password)) {
    header('Location: ../frontend/login.php?erro=campo_vazio');
    exit;
}

if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
}

$stmt->execute([$username_or_email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../frontend/login.php?erro=credenciais_invalidas');
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {
    header('Location: admin/index.php');
} else {
    header('Location: ../frontend/home.php');
}
exit;
