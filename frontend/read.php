<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/edit.css">

    <title>Stanza</title>
</head>

<body style="background-color: rgba(25, 22, 109, 0.94);">


<!-- Barra Web -->


<div class="bar"> 

        
       <a href="home.php"><</a>
       <button class="fecha" id="fecharBar">X</button>

        <div class="fsec">
                <div class="img">  </div>

                <div class="rinfo">

                    <h2>Título</h2>
                    <h3>Categoria</h3>

            
                    <div class="dw">
                    <h3>2233 views</h3>
                    <button>&#9661</button>
                      </div>
                </div>
        










        </div> 

        <div class="rdesc">

            Descrição é o tipo de texto que fornece características sobre algo ou alguém. Assim, a descrição propicia à pessoa que a lê ou a que ouve imaginar com facilidade o que está sendo descrito - objetos, lugares, acontecimentos ou pessoas, por exemplo.

        </div>


</div> 










<!-- Mobile -->


 <div class="mbbt1">
    <a href="home.php"  style="margin:0;"><</a>
   
    <button id="abrirBar" style="margin-left:auto;">⋮</button>
</div>





    <form action="  ALGUMA ACAO  ">
    <label style="display:none;" for="content">Escrever</label>
    <textarea id="content" name="content" readonly>Você nao pode mudar esse texto</textarea>



    



    <div class="mbbt2">
    
        <label>12 palavras</label>
        
        <label>226 caracteres</label>

        <label for="fontsize">Tamanho da fonte: </label>                                                
        <input type="number" id="fontsize" name="fontsize" min="1" max="40">
    </div>
    </form>













<!-- Botões Popup Mobile -->

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