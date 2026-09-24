<header>
<a href="home.php" class="logobox">
<img id="stanzalogo" src="img/stanza.png">
<img id="feather" src="img/logo.png">
</a>
<div class="bup">
    <button id="menubutton">☰</button>
</div>
</header>

<div class="menugrid">

    <button id="menuclose">X</button>

    <div class="gridsec">
        <a href="home.php">
            <div class="gridcard">Home</div>
        </a>

        <a href="create.php">
            <div class="gridcard">Create</div>
        </a>

        <a href="catalog.php">
            <div class="gridcard">Explore</div>
        </a>
        <a href="profile.php">
            <div class="gridcard">Profile</div>
        </a>
        <a href="settings.php">
            <div class="gridcard">Settings</div>
        </a>

    </div>
</div>


<script>
    const menu = document.querySelector(".menugrid");
     const open = document.querySelector("#menubutton");
    const close = document.querySelector("#menuclose");


    open.addEventListener("click", function() {
       menu.style.display = "block";
       open.textContent = "-";
    });

    close.addEventListener("click", function() {
        menu.style.display = "none";
        open.textContent = "☰";
    });

</script>