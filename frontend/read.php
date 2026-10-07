<?php
/*
 DECLARATION OF ARTIFICIAL INTELLIGENCE USE

 Tool: ChatGPT

 Stage: Development

 Purpose: Assisted with displaying only the tags previously selected and  
    stored in the database, adapting the PHP loop to filter the     
    available genres and present the selected tags as non-editable
    interface elements

 Validation: Reviewed PHP logic, data filtering, and visual behavior
    through browser testing.

 */

require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/read.php';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/edit.css">
   <link rel="stylesheet" href="css/header.css">
   
 <link rel="icon" type="image/png" href="img/logo.png">
 <title>Stanza</title>
<style>
    html, body{ background: var(--backblue);}
</style>
</head>
<body>


<?php include 'header.php'; ?>



<!-- Web Bar -->



<main>


<div class="bar"> 

        
       <a href="home.php" id="exitarrow">←</a>
       <button class="fecha" id="fecharBar">✕</button>

        <div class="fsec">
                <div class="img"> 
        <?php if ($text['cover_image']): ?>
            <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>"
            alt="<?= translator('editor_current_cover_alt') ?>"
            style="object-fit:cover;">
        <?php endif; ?>
     </div>

                <div class="rinfo">

                    <h2><?= htmlspecialchars($text['title'])?></h2>
                    <h3><?= htmlspecialchars($text['category'])?></h3>

            
                    <div class="dw">
                    <h3><?= htmlspecialchars($text['read_count'])?> <?= translator('views') ?> </h3>
                    <button>&#9661</button>
                      </div>
                </div>


        </div> 


        
        <h2><?= translator('editor_description') ?></h2>
        <div class="rdesc">
           <p> <?= htmlspecialchars($text['description'])?></p>
        </div>
      
      
        <h2><?= translator('catalog_tags_label') ?></h2>
            <div class="rdesc">
                <?php foreach ($genres as $genre): ?>
                    <?php $genreId = (int) $genre['id']; ?>

                    <?php if (in_array($genreId, $selectedTags, true)): ?>
                        <label><?= htmlspecialchars($genre['name']) ?></label>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>



</div> 










<!-- Mobile -->


 <div class="mbbt1">
    <a href="home.php"  style="margin:0;"> < </a>
   
    <button id="abrirBar" style="margin-left:auto;">⋮</button>
</div>





    <form action="  ALGUMA ACAO  ">
    <label style="display:none;" for="content"><?= translator('editor_body_label') ?></label>
    <textarea id="content" name="content" readonly><?= htmlspecialchars($text['body'])?></textarea>







    <div class="mbbt2">

        <label>12 <?= translator('editor_words') ?></label>

        <label>226 <?= translator('editor_characters') ?></label>

       // <label for="fontsize"><?= translator('editor_font_size_inline') ?> </label>
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




<script type="module">
    import Chatbox from 'https://cdn.jsdelivr.net/npm/@chatvolt/embeds@4.3.16/dist/chatbox/index.js';

    Chatbox.initBubble({
        agentId: 'cmttdb5b50dfiv16p8udc577t',
    });
</script>

</body>

</html>