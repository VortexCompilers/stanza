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
    <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="css/landing.css">
   <link rel="stylesheet" href="css/modal.css">

 <link rel="icon" type="image/png" href="img/logo.png">

    <title>Stanza</title>
</head>
<body>

<?php include 'headerland.php'; ?>

<main>

<div class="up">

    <div class="hero">
      <h1><span><?= translator('landing_hero_line1_accent') ?></span> <?= translator('landing_hero_line1_rest') ?></h1>
      <h1><span><?= translator('landing_hero_line2_accent') ?></span> <?= translator('landing_hero_line2_rest') ?></h1>

      <h2><?= translator('landing_hero_subtitle') ?></h2>
    </div>




    <div class="demos">
        <div class="cards">

            <?php foreach ($highlights as $i => $text): ?>
                <div class="minicard" style="margin-top:<?= $i === 0 ? '-2px' : '18px' ?>;">
                    <div class="pic">
                        <?php if ($text['cover_image']): ?>
                            <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="inf">
                        <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                        <h2><?= htmlspecialchars($text['category']) ?></h2>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>


        <div class="testinput">
            <label for="test" data-focus-label="<?= translator('landing_demo_label_focus') ?>"><?= translator('landing_demo_label') ?></label>
            <input type="text" id="test" name="test" placeholder="<?= translator('landing_demo_placeholder') ?>">
        </div>
  </div>

</div>









  <div class="bts">
  <button type="button" data-abrir="modalRegister"><?= translator('landing_cta_register') ?></button>
  <a href="login.php" data-abrir="modalLogin"><?= translator('landing_cta_login') ?></a>
</div>


<div class="explore">
<h1><?= translator('landing_explore_title') ?></h1>






  <div class="carousel">

      <?php foreach ($explore as $text): ?>
          <div class="post">
              <div class="img">
                  <?php if ($text['cover_image']): ?>
                      <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="info">
                  <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                  <h2><?= htmlspecialchars($text['category']) ?></h2>
              </div>
          </div>
      <?php endforeach; ?>

</div>


</div>


<div class="procurar">
    <label for="search"><?= translator('landing_search_label') ?></label>
    <input type="text" id="search" name="search" placeholder="<?= translator('landing_search_placeholder') ?>">
</div>


</main>

<?php
$erroLogin = $erroRegister = '';
$loginAberto = $registerAberto = false;

if (isset($_GET['erro'])) {
    $errorKeys = [
        'campo_vazio'           => 'error_empty_fields',
        'credenciais_invalidas' => 'error_invalid_credentials',
        'email_duplicado'       => 'error_email_taken',
    ];
    $msg = translator($errorKeys[$_GET['erro']] ?? 'error_generic');

    if (($_GET['modal'] ?? '') === 'register') {
        $erroRegister = $msg;
        $registerAberto = true;
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