<?php
require_once __DIR__ . '/lang/load.php';

$erroRegister = '';

if (isset($_GET['erro'])) {
    // Maps the ?erro= codes backend/register.php redirects with to dictionary
    // keys defined in lang/enus.php.
    $errorKeys = [
        'campo_vazio'     => 'error_empty_fields',
        'email_duplicado' => 'error_email_taken',
    ];

    $erroRegister = translator($errorKeys[$_GET['erro']] ?? 'error_generic');
}

// Direct access to this page: the pop-up is already open.
$registerAberto = true;
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="css/modal.css">

    <title>Stanza</title>
</head>
<body class="modal-page">


<?php include __DIR__ . '/partials/modal-register.php'; ?>


</body>
</html>
