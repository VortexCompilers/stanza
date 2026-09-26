<?php 

/*
  DECLARATION OF ARTIFICIAL INTELLIGENCE USE
 
  Tool: ChatGPT
  Stage: Development
  Purpose: Assisted with JavaScript and CSS implementation for interactive frontend
           behavior, including event handling, visibility and color toggling based on
           radio button selection, and debugging DOM manipulation issues.
 
  Validation: Verified event listeners, element state changes, and interface
              behavior through browser testing.
 */



require_once __DIR__ . '/lang/load.php'; ?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/create.css">
 <link rel="stylesheet" href="css/header.css">
 <link rel="stylesheet" href="css/nav.css">


 <link rel="icon" type="image/png" href="img/logo.png">

    <title>Stanza</title>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>




<main>

    <h1><?= translator('editor_create_title') ?></h1>


        <form action="../backend/create.php" method="POST" enctype="multipart/form-data">

        <div class="imgblock">

            <label for="cape"><?= translator('editor_cover') ?></label>
                <input 
                type="file" 
                id="image-picker" 
                name="cover_image" 

                accept="image/png, image/jpeg, image/webp" 
                />



    </div>


        
    <div class="cblock">
        
            <label for="title"><?= translator('editor_title') ?></label>

            <input type="text" id="title" name="title">




            <label for="desc"><?= translator('editor_description') ?></label>
            <textarea id="desc" name="desc"></textarea>







            <label for="category"><?= translator('editor_category') ?></label>
                <select id="category" name="category">
                    <option value=""><?= translator('category_placeholder') ?></option>
                    <option value="book"><?= translator('category_book') ?></option>
                    <option value="poetry"><?= translator('category_poetry') ?></option>
                    <option value="story"><?= translator('category_story') ?></option>
                </select>



                    

            <!-- Content language: each option stays in its own language, not translated -->
            <label for="language"><?= translator('editor_language') ?></label>
                <select id="language" name="language">
                    <option value=""><?= translator('editor_language_placeholder') ?></option>
                    <option value="enus">English</option>
                    <option value="ptbr">Português</option>
                    <option value="es">Español</option>
                </select>




              <label for="visibility"><?= translator('editor_visibility') ?></label>
                <div class="visibt">
            <input type="radio" name="visibility" id="public" value="public" checked>
            <label for="public"><?= translator('visibility_public') ?></label>

            <input type="radio" name="visibility" id="private" value="private">
            <label for="private"><?= translator('visibility_private') ?></label>

        </div>

            <p class="aviso-visibilidade">&#9888 <?= translator('editor_visibility_warning') ?></p>
            
            <script>
                const warning = document.querySelector(".aviso-visibilidade");    
                const publicbt = document.querySelector("#public")
                const privatebt = document.querySelector("#private")

            function warningcheck(){
                if (publicbt.checked == true){
                    warning.style.visibility = "visible";
                }else{
                    warning.style.visibility = "hidden";
                }
             }

            publicbt.addEventListener("change", warningcheck)
            privatebt.addEventListener("change", warningcheck)
        </script>



        <div class="botoes-form">
            <button type="button" style="background-color:white; padding:8px 12px;color:black;" ><?= translator('action_cancel') ?> </button>
            <button type="submit" ><?= translator('editor_submit_create') ?></button>
        </div>




        
</div>

        </form>



</main>




</body>
</html>