<?php
#validacao do email
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';

$status = isset($_GET['status']) ? (string) $_GET['status'] : '';
$error = isset($_GET['error']) ? (string) $_GET['error'] : '';

$messageType = '';
$messageText = '';

if ($error === 'invalid_email') {
    $messageType = 'error';
    $messageText = 'Please enter a valid email address.';
} elseif ($error === 'server') {
    $messageType = 'error';
    $messageText = 'Unable to process your request right now. Please try again later.';
} elseif ($status === 'sent') {
    $messageType = 'success';
    $messageText = 'If the email exists in our system, a password reset link has been sent.';
}

if ($messageText !== '') {
    echo '<div class="alert ' . $messageType . '">' . htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8') . '</div>';
}
 
$email = trim((string) ($_POST['email'] ?? ''));

if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../../frontend/password-reset/auth.php?error=credenciais_invalidas');
    exit;
}

$stmt = $pdo->prepare("SELECT id, email FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    usleep(500000);
    header('Location: ../../frontend/password-reset/auth.php?erro=credenciais_invalidas');
    exit;
}

else {
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expiresAt = date('Y-m-d H:i:s', time() + 1800);

    $insert = $pdo->prepare(
        "INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)"
    );
    $insert->execute([$user['id'], $tokenHash, $expiresAt]);

    $baseUrl = rtrim($baseUrl, '/');

    if ($baseUrl === '') {
        header('Location: ../../frontend/password-reset/auth.php?error=server');
        exit;
    }

    $resetLink = $baseUrl . '/frontend/password-reset/auth-new-password.php?token=' . $token;

    $logFile = __DIR__ . '/reset_email.log';
    $logEntry = date('Y-m-d H:i:s') . " | to: {$user['email']} | link: {$resetLink}" . PHP_EOL;
    @file_put_contents($logFile, $logEntry, FILE_APPEND);

    header('Location: ../../frontend/password-reset/auth.php?status=sent');
    exit;
}
?>
