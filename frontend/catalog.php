<?php 

/*
AI USE DECLARATION

Tool: Gemini, Codex
Stage: Development
Purpose: Refactoring the catalog page to render dynamic books safely and adding
         advanced filters for category, sorting, tags, and optional semantic
         ranking through the FAISS API.
Validation: Query parameters and rendered output were reviewed. PHP syntax was
            checked with php -l.
*/

require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/catalog.php';
?>

<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/post.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/nav.css">

 <link rel="icon" type="image/png" href="img/logo.png">
    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>




<main>


<div class="filtersec">

<form action="catalog.php" method="get">
    <input type="search" name="search" value="<?= htmlspecialchars($query) ?>" placeholder="<?= translator('catalog_search_placeholder') ?>" aria-label="<?= translator('action_search') ?>">


    

       <a id="abrirPop">▼ <?= translator('action_filter') ?></a>

    <button type="submit"><?= translator('action_search') ?></button>



          <div class="filterpop">
          <h1><?= translator('catalog_filter_title') ?></h1>


          <h2><?= translator('catalog_sort_by') ?></h2>
                <div class="stsbox">
                  <div class="rdbt">
                        <input type="radio" name="order" id="recent" value="recent" <?= $order === 'recent' ? 'checked' : '' ?>>
                        <label for="recent"><?= translator('catalog_sort_recent') ?></label>

                        <input type="radio" name="order" id="save" value="save" <?= $order === 'save' ? 'checked' : '' ?>>
                        <label for="save"><?= translator('catalog_sort_most_saved') ?></label>

                        <input type="radio" name="order" id="view" value="view" <?= $order === 'view' ? 'checked' : '' ?>>
                        <label for="view"><?= translator('catalog_sort_most_viewed') ?></label>
                  </div>

              </div>


          <h2><?= translator('catalog_category_label') ?></h2>
                <div class="stsbox">
                  <div class="rdbt">
                        <input type="radio" name="category" id="category_all" value="" <?= $category === '' ? 'checked' : '' ?>>
                        <label for="category_all"><?= translator('catalog_category_all') ?></label>

                        <input type="radio" name="category" id="book" value="book" <?= $category === 'book' ? 'checked' : '' ?>>
                        <label for="book"><?= translator('category_book') ?></label>

                        <input type="radio" name="category" id="poetry" value="poetry" <?= $category === 'poetry' ? 'checked' : '' ?>>
                        <label for="poetry"><?= translator('category_poetry') ?></label>

                        <input type="radio" name="category" id="story" value="story" <?= $category === 'story' ? 'checked' : '' ?>>
                        <label for="story"><?= translator('category_story') ?></label>
                  </div>

              </div>

          <h2><?= translator('catalog_tags_label') ?></h2>
                <div class="stsbox tagbox">
                  <div class="rdbt">
                    <?php foreach ($genres as $genre): ?>
                        <?php $genreId = (int) $genre['id']; ?>
                        <input type="checkbox" name="tags[]" id="tag_<?= $genreId ?>" value="<?= $genreId ?>" <?= in_array($genreId, $selectedTags, true) ? 'checked' : '' ?>>
                        <label for="tag_<?= $genreId ?>"><?= htmlspecialchars($genre['name']) ?></label>
                    <?php endforeach; ?>
                  </div>
              </div>

          </div>


  </form>


</div>






            <section>
               <?php if ($catalogError): ?>
            <p class="catalog-message"><?= translator($catalogError) ?></p>
        <?php endif; ?>

               <?php if (empty($books)): ?>
            <p>Nenhum resultado encontrado para "<?= htmlspecialchars($query) ?>".</p>
        <?php else: ?>
            <?php foreach ($books as $text): ?>
                <div class="post">
                    <div class="img">
                        <?php if (!empty($text['cover_image'])): ?>
                            <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="Capa de <?= htmlspecialchars($text['title']) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                        <h2><?= htmlspecialchars($text['tags'] ?: $text['category']) ?></h2>
                        <div class="postfooter">
                            <h3><?= (int) $text['read_count'] ?> <?= translator('views') ?></h3>
                            <button>&#9661;</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

</section>

</main>






<script>
    const filter = document.querySelector(".filterpop");
     const abrir = document.querySelector("#abrirPop");

    
    abrir.addEventListener("click", function() {
        if(filter.style.display == "block"){
            filter.style.display = "none";
            abrir.textContent = "▼ <?= translator('action_filter') ?>"
        }else{
            filter.style.display = "block"
            abrir.textContent = "✖ <?= translator('action_filter') ?>"
        }

         
    });
</script>





<!--
    StanzAI chat bubble, hosted on Chatvolt. The agent is a catalog guide: it
    reads the live catalog through backend/api/catalog.php and only talks about
    texts that are actually published on the platform.

    The version is pinned on purpose, so an upstream release cannot change the
    widget between now and the presentation.
-->
<script type="module">
    import Chatbox from 'https://cdn.jsdelivr.net/npm/@chatvolt/embeds@4.3.16/dist/chatbox/index.js';

    Chatbox.initBubble({
        agentId: 'cmttdb5b50dfiv16p8udc577t',
    });
</script>

</body>

</html>
