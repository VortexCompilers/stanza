<header>
<img src="img/logo.png">
<div class="bup">
    <button id="menubutton">Menu</button>
</div>
</header>

<div class="menugrid">

    <button id="menuclose">X</button>

    <div class="gridsec">
        <a href="home.php">
            <div class="gridcard">🏠 Home</div>
        </a>

        <a href="create.php">
            <div class="gridcard">➕ Create</div>
        </a>

        <a href="catalog.php">
            <div class="gridcard">🌐 Explore</div>
        </a>
        <a href="profile.php">
            <div class="gridcard">👤 Profile</div>
        </a>
        <a href="settings.php">
            <div class="gridcard">⚙ Settings</div>
        </a>

    </div>
</div>


<script>
    const menu = document.querySelector(".menugrid");
     const open = document.querySelector("#menubutton");
    const close = document.querySelector("#menuclose");


    open.addEventListener("click", function() {
       menu.style.display = "block";
    });

    close.addEventListener("click", function() {
        menu.style.display = "none";
    });

</script>