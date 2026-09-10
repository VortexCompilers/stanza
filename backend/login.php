<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

require_once __DIR__ . '/config/database.php';

$username_or_email = $_POST['usernameoremail'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username_or_email) || empty($password)) {
    header('Location: ../frontend/landing.php?erro=campo_vazio&modal=login');
}

if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
}

$stmt->execute([$username_or_email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../frontend/landing.php?erro=credenciais_invalidas&modal=login');
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
