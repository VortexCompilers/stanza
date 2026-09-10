<?php
require_once __DIR__ . '/lang/load.php';

$erroLogin = '';

if (isset($_GET['erro'])) {
    $errorKeys = [
        'campo_vazio'           => 'error_empty_fields',
        'credenciais_invalidas' => 'error_invalid_credentials',
    ];

    $erroLogin = translator($errorKeys[$_GET['erro']] ?? 'error_generic');
}

$loginAberto = true;
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


<?php include __DIR__ . '/partials/modal-login.php'; ?>


</body>
</html>
