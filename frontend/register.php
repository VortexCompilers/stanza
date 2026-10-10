<?php
require_once __DIR__ . '/lang/load.php';

$erroRegister = '';
$registerStartStep = 1;

if (isset($_GET['erro'])) {

    $errorKeys = [
        'campo_vazio'      => 'error_empty_fields',
        'email_duplicado'  => 'error_email_taken',
        'upload_falhou'    => 'error_upload_failed',
        'formato_invalido' => 'error_invalid_format',
    ];

    $erroRegister = translator($errorKeys[$_GET['erro']] ?? 'error_generic');

    if (in_array($_GET['erro'], ['upload_falhou', 'formato_invalido'], true)) {
        $registerStartStep = 2;
    }
}

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
