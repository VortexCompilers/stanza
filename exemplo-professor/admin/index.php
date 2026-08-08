<?php
session_start();

$allowedLanguages = ['it', 'en-gb', 'pt-pt'];

if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLanguages)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = $_SESSION['lang'] ?? 'it';

require_once __DIR__ . '/../lang/' . $lang . '.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Temporary fixed credentials for the first didactic version.
    $validUsername = 'admin';
    $validPassword = '123456';

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['user'] = $username;

        header('Location: dashboard.php');
        exit;
    }

    $errorMessage = $text['invalid_login'];
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tre Fratelli — Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="tf-login-page">

<main class="container min-vh-100 d-flex align-items-center justify-content-center py-4">

    <section class="row w-100 shadow-lg rounded-4 overflow-hidden tf-login-box">

        <div class="col-12 col-lg-6 p-0">
            <img src="../assets/img/interior-view.png" class="img-fluid h-100 w-100 tf-login-image" alt="Tre Fratelli interior">
        </div>

        <div class="col-12 col-lg-6 bg-white p-4 p-md-5">

            <div class="mb-4">
                <h1 class="fw-bold mb-1">Tre Fratelli</h1>
                <p class="text-muted mb-0">Paninoteca Romana</p>
            </div>

            <h2 class="h4 mb-3"><?= $text['login'] ?></h2>

            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($errorMessage) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php">

                <div class="mb-3">
                    <label for="username" class="form-label">
                        <?= $text['username'] ?>
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="username" 
                        name="username" 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <?= $text['password'] ?>
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        required
                    >
                </div>

                <button type="submit" class="btn tf-btn-primary w-100">
                    <?= $text['enter'] ?>
                </button>

            </form>

            <hr class="my-4">

            <div class="d-flex justify-content-center gap-2">
                <a href="?lang=it" class="btn btn-sm btn-outline-secondary">IT</a>
                <a href="?lang=en-gb" class="btn btn-sm btn-outline-secondary">EN</a>
                <a href="?lang=pt-pt" class="btn btn-sm btn-outline-secondary">PT</a>
            </div>

            <p class="small text-muted text-center mt-4 mb-0">
                Educational project · Beta version
            </p>

        </div>

    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>