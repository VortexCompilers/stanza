<?php
$erroRegister = '';

if (isset($_GET['erro'])) {
    $mensagensDeErro = [
        'campo_vazio' => 'Preencha todos os campos.',
        'email_duplicado' => 'Este e-mail já está cadastrado.',
    ];

    $erroRegister = $mensagensDeErro[$_GET['erro']] ?? 'Ocorreu um erro. Tente novamente.';
}

// Acesso direto a esta página: o pop-up já aparece aberto.
$registerAberto = true;
?>
<!DOCTYPE html>
<html lang="pt-br">
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
