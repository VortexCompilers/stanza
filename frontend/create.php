<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/create.css">
 <link rel="stylesheet" href="css/header.css">
 <link rel="stylesheet" href="css/nav.css">



    <title>Stanza</title>
</head>
<body>

<?php include 'header.php'; ?>




<main>

    <h1>Criar</h1>


        <form action="../backend/create.php" method="POST" enctype="multipart/form-data">

        <div class="imgblock">

            <label for="cape">Capa</label>
                <input 
                type="file" 
                id="image-picker" 
                name="cover_image" 

                accept="image/png, image/jpeg, image/webp" 
                />



    </div>


        
    <div class="cblock">
        
            <label for="title">Título</label>
        
            <input type="text" id="title" name="title">
        


            
            <label for="desc">Descrição</label>
            <textarea id="desc" name="desc"></textarea>
        


            <div class="mbimg">
            <label for="cape">Capa</label>
                <input 
                type="file" 
                id="image-picker" 
                name="cover_image" 

                accept="image/png, image/jpeg, image/webp" 
                />
            </div>








            <label for="category">Categoria</label>
                <select id="category" name="category">
                    <option value="">Categoria</option>
                    <option value="book">Livro</option>
                    <option value="poetry">Poesia</option>
                    <option value="story">Conto</option>
                </select>



                    

            <label for="language">Idioma</label>
                <select id="language" name="language">
                    <option value="">Idioma</option>
                    <option value="enus">English</option>
                    <option value="ptbr">Português</option>
                    <option value="es">Español</option>
                </select>




              <label for="visibility">Visibilidade</label>
                <div class="visibt">
            <input type="radio" name="visibility" id="public" value="public" checked>
            <label for="public">Público</label>

            <input type="radio" name="visibility" id="private" value="private">
            <label for="private">Privado</label>
                
        </div>

            <p class="aviso-visibilidade">&#9888 Todos os usuários poderão ver seu texto, mesmo incompleto</p>






        <div class="botoes-form">
            <button type="button" style="background-color:white; padding:8px 12px;color:black;" >Cancelar</button>
            <button type="submit" >Escrever</button>
        </div>




        
</div>

        </form>



</main>




</body>
</html>