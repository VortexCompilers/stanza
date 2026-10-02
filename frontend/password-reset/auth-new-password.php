<?php require_once __DIR__ . '/../lang/load.php'; ?>
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

<h1><?= translator('verify_title') ?></h1>


<form action=" ddd ">

    <label>Enter your password</label>

    <input type="password" id="password" name="password">

    <label for="">Confirm your password</label>

    <input type="password" id="confirm-password" name="confirm-password">

    
   <button type="submit"><?= translator('verify_submit') ?></button>

</form>

<a href="reeeeenviar"><?= translator('verify_resend') ?></a>




</div>




</body>
</html>