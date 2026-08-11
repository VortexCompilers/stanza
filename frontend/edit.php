<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/edit.css">

    <title>Stanza</title>
</head>
<body>



<!-- Barra Web -->


<div class="bar"> 
    
        
       <a href="home.php"><</a>
       <button class="fecha" id="fecharBar">X</button>

    <h2>Título</h2>


    <div class="img">
    </div>
    
     <input 
        type="file" 
        id="image-picker" 
        name="imageUpload" 

        accept="image/png, image/jpeg, image/webp" 
        />



    
    
    <h2>Categoria</h2>
        <!-- faça a categoria original vir marcada padrão-->
        <select id="category" name="category">
            <option value="">Categoria</option>
            <option value="book">Livro</option>
            <option value="poetry">Poesia</option>
            <option value="story">Conto</option>
        </select>


    <h2>Idioma</h2>
        <select id="language" name="langugage">
            <option value="">Idioma</option>
            <option value="enus">English</option>
            <option value="ptbr">Português</option>
        </select>




    <h2>Visibilidade</h2>
   
    <div class="visibt">

        <input type="radio" name="visibility" id="public">
        <label for="public">Público</label>

        <input type="radio" name="visibility" id="private">
        <label for="private">Privado</label>

    </div>


                                    
                    <div class="wbbt">
                    <h2>Tamanho da fonte</h2>                       
                    <input type="number" id="fontsize" name="fontsize" min="1" max="40">



                    <button class="svv">Salvar</button>
                </div>

</div> 











<!-- Mobile -->


 <div class="mbbt1">
    <a href="home.php"  style="margin:0;"><</a>
    <a href="DPS vc muda" style="margin-left:auto;" >Salvar</a>
   
    <button id="abrirBar" style="margin-left:auto;">⋮</button>
</div>



    <form action="  ALGUMA ACAO  ">
    <label style="display:none;" for="content">Escrever</label>
    <textarea id="content" name="content"></textarea>



    



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