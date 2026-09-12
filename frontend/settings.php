<?php
require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/settings.php';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/settings.css">
 <link rel="stylesheet" href="css/header.css">
 <link rel="stylesheet" href="css/nav.css">



 <link rel="icon" type="image/png" href="img/logo.png">
    <title>Stanza</title>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>


<main>

        <div class="settingsec">

        <h1><?= translator('settings_general') ?></h1>
                <div class="stsbox">
            
                        <h2><?= translator('settings_theme') ?></h2>

                                <div class="rdbt">
                                <input type="radio" name="theme" id="light" checked>
                                <label for="light"><?= translator('settings_theme_light') ?></label>

                                <input type="radio" name="theme" id="dark">
                                <label for="dark"><?= translator('settings_theme_dark') ?></label>
                                    </div>

                            </div>






                <div class="stsbox">
                <h2><?= translator('settings_default_font_size') ?></h2>

                    
                    <input type="range" name="fontsize" id="fontsie" min="1" max="50" value="12">
                    <label>31</label>

                </div>







                <div class="stsbox">

                        <h2><?= translator('settings_language') ?></h2>

                        <div class="rdbt">
                            <a href="set-language.php?lang=enus"<?= $lang === 'enus' ? ' aria-current="true"' : '' ?>>EN-US</a>
                            <a href="set-language.php?lang=es"<?= $lang === 'es' ? ' aria-current="true"' : '' ?>>ES-419</a>
                            <a href="set-language.php?lang=ptbr"<?= $lang === 'ptbr' ? ' aria-current="true"' : '' ?>>PT-BR</a>
                        </div>

                        </div>





</div>


    <div class="settingsec">

        <h1><?= translator('settings_profile') ?></h1>





            <div class="stsbox1" style="gap:10px;"> 
                    <!--  Different -->
                        <h2 style="margin: auto 6px;" ><?= translator('settings_profile_picture') ?></h2>

                        <div class="stpic"></div>

            <button><?= translator('action_edit') ?></button>
            </div>







            <div class="stsbox1">
                    <div class="stsinfo">
                        <h2><?= translator('settings_username') ?></h2>

                            <label><?= htmlspecialchars($user['name']) ?></label>

                    </div>
            <button><?= translator('action_edit') ?></button>
            </div>

            <div class="stsbox1">
                    <div class="stsinfo">
                        <h2><?= translator('settings_email') ?></h2>

                        <label><?= htmlspecialchars($user['email'])?></label>

                    </div>
            <button><?= translator('action_edit') ?></button>
            </div>


            <div class="stsbox1">
                    <div class="stsinfo">
                        <h2><?= translator('settings_password') ?></h2>

                        <label>***</label>

                    </div>
            <button><?= translator('action_edit') ?></button>
            </div>
</div>


        <div class="footbuttons">
            <button class="dlbt"><?= translator('settings_delete_account') ?></button>
            <button class="lvbt"><a href="../backend/logout.php"><?= translator('settings_logout') ?></a></button>
        </div>


</main>


</body>
</html>