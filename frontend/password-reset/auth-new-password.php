<?php
require_once __DIR__ . '/../lang/load.php';

$token = isset($_GET['token']) ? trim((string) $_GET['token']) : '';
$errorParam = isset($_GET['error']) ? (string) $_GET['error'] : '';

$errorKey = '';
if ($errorParam === 'password') {
    $errorKey = 'reset_error_password';
} elseif ($errorParam === 'mismatch') {
    $errorKey = 'reset_error_mismatch';
} elseif ($errorParam === 'server') {
    $errorKey = 'reset_error_server';
} elseif ($errorParam === 'invalid' || $token === '') {
    $errorKey = 'reset_error_invalid';
}

$showForm = $token !== '' && $errorKey !== 'reset_error_invalid';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/style.css">

 <link rel="icon" type="image/png" href="../img/logo.png">


    <title>Stanza</title>
</head>
<body>

<div class="wblock">

<h1><?= translator('reset_new_password_title') ?></h1>

<?php if ($errorKey !== ''): ?>
    <div class="alert error"><?= translator($errorKey) ?></div>
<?php endif; ?>

<?php if ($showForm): ?>

<form action="../../backend/password-reset/update-password.php" method="POST">

    <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">

    <label for="password"><?= translator('reset_password_label') ?></label>
    <input type="password" id="password" name="password">

    <label for="confirm-password"><?= translator('reset_confirm_label') ?></label>
    <input type="password" id="confirm-password" name="confirm_password">

    <button type="submit"><?= translator('reset_submit') ?></button>

</form>

<?php else: ?>

    <a class="modal-link" href="auth.php"><?= translator('reset_request_new_link') ?></a>

<?php endif; ?>

</div>

</body>
</html>
