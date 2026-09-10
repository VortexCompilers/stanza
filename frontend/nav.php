<?php require_once __DIR__ . '/lang/load.php'; ?>
<nav>
<div class="createbt"><a href="create.php"> <?= translator('nav_create') ?> </a></div>

<br>


<a href="home.php"> <div class="navbt"><?= translator('nav_home') ?> </div></a>

<a href="catalog.php"><div class="navbt"> <?= translator('nav_explore') ?></div></a>

<a href="profile.php"><div class="navbt"> <?= translator('nav_profile') ?> </div></a>

<br>

<a href="settings.php"><div class="navbt"> <?= translator('nav_settings') ?> </div></a>
</nav>
