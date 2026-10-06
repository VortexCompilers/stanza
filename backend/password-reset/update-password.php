<?php

require_once __DIR__ . '/../config/database.php';

$token = trim((string) ($_POST['token'] ?? ''));
$password = (string) ($_POST['password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');

if ($token === '' || strlen($token) !== 64 || !ctype_xdigit($token)) {
    header('Location: ../../frontend/password-reset/auth-new-password.php?error=invalid');
    exit;
}

$redirectBase = '../../frontend/password-reset/auth-new-password.php?token=' . urlencode($token);

if (strlen($password) < 8) {
    header('Location: ' . $redirectBase . '&error=password');
    exit;
}

if ($password !== $confirmPassword) {
    header('Location: ' . $redirectBase . '&error=mismatch');
    exit;
}

$tokenHash = hash('sha256', $token);

$stmt = $pdo->prepare(
    "SELECT id, user_id, expires_at FROM password_resets WHERE token_hash = ? AND used = 0 LIMIT 1"
);
$stmt->execute([$tokenHash]);
$reset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reset || strtotime($reset['expires_at']) < time()) {
    header('Location: ' . $redirectBase . '&error=invalid');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
        ->execute([$passwordHash, $reset['user_id']]);

    $pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?")
        ->execute([$reset['id']]);

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    header('Location: ' . $redirectBase . '&error=server');
    exit;
}

header('Location: ../../frontend/landing.php?status=password_updated&modal=login');
exit;
