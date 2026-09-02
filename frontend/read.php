<?php
require_once __DIR__ . '/../backend/read.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/edit.css">
   <link rel="stylesheet" href="css/header.css">
    <title>Stanza</title>
</head>

<body style="background-color: rgba(25, 22, 109, 0.94);">


<?php include 'header.php'; ?>



<!-- Web Bar -->



<main>


<div class="bar"> 

        
       <a href="home.php"><</a>
       <button class="fecha" id="fecharBar">X</button>

        <div class="fsec">
                <div class="img">  </div>

                <div class="rinfo">

                    <h2><?= htmlspecialchars($text['title'])?></h2>
                    <h3><?= htmlspecialchars($text['category'])?></h3>

            
                    <div class="dw">
                    <h3><?= htmlspecialchars($text['read_count'])?></h3>
                    <button>&#9661</button>
                      </div>
                </div>
        










        </div> 

        <div class="rdesc">

            <?= htmlspecialchars($text['description'])?>

        </div>


</div> 










<!-- Mobile -->


 <div class="mbbt1">
    <a href="home.php"  style="margin:0;"><</a>
   
    <button id="abrirBar" style="margin-left:auto;">⋮</button>
</div>





    <form action="  ALGUMA ACAO  ">
    <label style="display:none;" for="content">Escrever</label>
    <textarea id="content" name="content" readonly><?= htmlspecialchars($text['body'])?></textarea>



    



    <div class="mbbt2">
    
        <label>12 palavras</label>
        
        <label>226 caracteres</label>

        <label for="fontsize">Tamanho da fonte: </label>                                                
        <input type="number" id="fontsize" name="fontsize" min="1" max="40">
    </div>
    </form>



</main>









<!-- Pop-up Mobile Buttons -->

<script>
    const bar = document.querySelector(".bar");
     const abrir = document.querySelector("#abrirBar");
    const fechar = document.querySelector("#fecharBar");

    fechar.addEventListener("click", function() {
        bar.style.display = "none";
    });
    
    abrir.addEventListener("click", function() {
        bar.style.display = "block";
    });



</script>



</body>
</html>