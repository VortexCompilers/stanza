<?php require_once __DIR__ . '/lang/load.php'; ?>
<nav>

<a href="create.php"><div class="navbt"> <?= translator('nav_create') ?> </div></a>

<br>

<a href="home.php"> <div class="navbt"><?= translator('nav_home') ?> </div></a>

<a href="catalog.php"><div class="navbt"> <?= translator('nav_explore') ?></div></a>

<a href="profile.php"><div class="navbt"> <?= translator('nav_profile') ?> </div></a>

<br>

<a href="settings.php"><div class="navbt"> <?= translator('nav_settings') ?> </div></a>
</nav>



<script>
    const menu = document.querySelector("nav");
     const open = document.querySelector("#menubutton");


    open.addEventListener("click", function() {
            if(menu.style.display == "none"){
                    menu.style.display = "block";
            }else{
                 menu.style.display = "none";
     } });


</script>