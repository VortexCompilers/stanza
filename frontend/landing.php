<?php require_once __DIR__ . '/lang/load.php'; ?>
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


    <title>Stanza</title>
</head>
<body>

<?php include 'header.php'; ?>

<main>

<div class="up">

    <div class="hero">
      <h1><span><?= translator('landing_hero_line1_accent') ?></span> <?= translator('landing_hero_line1_rest') ?></h1>
      <h1><span><?= translator('landing_hero_line2_accent') ?></span> <?= translator('landing_hero_line2_rest') ?></h1>

      <h2><?= translator('landing_hero_subtitle') ?></h2>
    </div>




    <div class="demos">
        <div class="cards">

          <div class="minicard" style="margin-top:-2px;">
            <div class="pic"></div>
                <div class="inf">
              <h1>.</h1><h1>.</h1><br><h1>.</h1>
                </div>
            </div>

          <div class="minicard" style="margin-top:18px;">
            <div class="pic"></div>
                <div class="inf">
              <h1>.</h1><h1>.</h1><br><h1>.</h1>
                </div>
            </div>

        </div>


        <div class="testinput">
            <label for="test"><?= translator('landing_demo_label') ?></label>
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
              <div class="post">
                  <div class="img"></div>
                  <div class="info">
                      <a href="LINNNNK">Title Example Like This One</a>
                      <h2>Book</h2>
                  
                  </div>
              </div>


                 <div class="post">
                  <div class="img"></div>
                  <div class="info">
                      <a href="LINNNNK">Title Example Like This One</a>
                      <h2>Book</h2>
                  
                  </div>
              </div>

                 <div class="post">
                  <div class="img"></div>
                  <div class="info">
                      <a href="LINNNNK">Title Example Like This One</a>
                      <h2>Book</h2>
                  
                  </div>
              </div>

</div>


</div>


<div class="procurar">
    <label for="search"><?= translator('landing_search_label') ?></label>
    <input type="text" id="search" name="search" placeholder="<?= translator('landing_search_placeholder') ?>">
</div>


</main>



<?php include __DIR__ . '/partials/modal-login.php'; ?>
<?php include __DIR__ . '/partials/modal-register.php'; ?>



<script src="js/modal.js"></script>


</body>
</html>