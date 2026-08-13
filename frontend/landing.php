<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="css/landing.css">
   <link rel="stylesheet" href="css/modal.css">


    <title>Stanza</title>
</head>
<body>



<div class="up">

    <div class="hero">
      <h1><span>Crie</span> textos</h1>
      <h1><span>Imagine</span> mais</h1>
      
      <h2>Escreva histórias, compartilhe ideias, dê o próximo passo</h2>
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
            <label for="test">Lendo</label>
            <input type="text" id="test" name="test" placeholder="Escreva o primeiro verso...">
        </div>
  </div>

</div>









  <div class="bts">
  <button type="button" data-abrir="modalRegister">Criar conta</button>
  <a href="login.php" data-abrir="modalLogin">Já tenho acesso</a>
</div>


<div class="explore">
<h1>Explore, busque</h1>






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
    <label for="search">Procurar</label>
    <input type="text" id="search" name="search" placeholder="Busque por título, autor ou tema">
</div>




<?php include __DIR__ . '/partials/modal-login.php'; ?>
<?php include __DIR__ . '/partials/modal-register.php'; ?>

<script src="js/modal.js"></script>




</body>
</html>