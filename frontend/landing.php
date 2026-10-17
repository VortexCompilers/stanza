<?php
require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/landing.php';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
     <link rel="stylesheet" href="css/color.css">
   <link rel="stylesheet" href="css/landing.css">
   <link rel="stylesheet" href="css/modal.css">

 <link rel="icon" type="image/png" href="img/logo.png">

    <title>Stanza</title>
</head>
<body>

<?php include 'headerland.php'; ?>

<main>

    <div class="hero">
        <div class="hero-1">
            <div class="hero-texts">          
                <h1><?= translator('landing_hero_line1') ?></h1>
                <h2><?= translator('landing_hero_subtitle') ?></h2>
            </div>
        </div>
        <div class="hero-2">
             <div class="mock-1">
                <img src="img/iphone-mockup.png" alt="phone mockup">
            </div>
            <div class="mock-2">
                <img src="img/laptop-mockup.png" alt="phone mockup">
            </div>
        
        </div>

</div>





  <div class="bts-sec">
    <h1><?= translator('landing_bts_line')?></h1>

    <div class="bts-fig">
        <img src="img/bman1.png" alt="Stickman reading a book">
    </div>

  <button type="button" data-abrir="modalRegister"><?= translator('landing_cta_register') ?></button>
  <a href="login.php" data-abrir="modalLogin"><?= translator('landing_cta_login') ?></a>


</div>


</main>

<?php
$erroLogin = $erroRegister = '';
$loginAberto = $registerAberto = false;
$registerStartStep = 1;

if (isset($_GET['erro'])) {
    $errorKeys = [
        'campo_vazio'           => 'error_empty_fields',
        'credenciais_invalidas' => 'error_invalid_credentials',
        'email_duplicado'       => 'error_email_taken',
        'upload_falhou'         => 'error_upload_failed',
        'formato_invalido'      => 'error_invalid_format',
    ];
    $msg = translator($errorKeys[$_GET['erro']] ?? 'error_generic');

    if (($_GET['modal'] ?? '') === 'register') {
        $erroRegister = $msg;
        $registerAberto = true;

        if (in_array($_GET['erro'], ['upload_falhou', 'formato_invalido'], true)) {
            $registerStartStep = 2;
        }
    } else {
        $erroLogin = $msg;
        $loginAberto = true;
    }
}

include __DIR__ . '/partials/modal-login.php'; 
include __DIR__ . '/partials/modal-register.php';
?>



<script src="js/modal.js"></script>


</body>
</html>