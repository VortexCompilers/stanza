<?php require_once __DIR__ . '/lang/load.php'; ?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/catalog.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/nav.css">

    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>




<main>


<div class="filtersec">

<form action="/search" method="get">
    <input type="search" name="catal" placeholder="<?= translator('catalog_search_placeholder') ?>" aria-label="<?= translator('action_search') ?>">


    

       <a id="abrirPop">▼ <?= translator('action_filter') ?></a>

    <button type="submit"><?= translator('action_search') ?></button>



          <div class="filterpop">
          <h1><?= translator('catalog_filter_title') ?></h1>


          <h2><?= translator('catalog_sort_by') ?></h2>
                <div class="stsbox">
                  <div class="rdbt">
                        <input type="radio" name="order" id="recent" checked>
                        <label for="recent"><?= translator('catalog_sort_recent') ?></label>

                        <input type="radio" name="order" id="save">
                        <label for="save"><?= translator('catalog_sort_most_saved') ?></label>

                        <input type="radio" name="order" id="view">
                        <label for="view"><?= translator('catalog_sort_most_viewed') ?></label>
                  </div>

              </div>


          <h2><?= translator('catalog_category_label') ?></h2>
                <div class="stsbox">
                  <div class="rdbt">
                        <input type="radio" name="category" id="book" checked>
                        <label for="book"><?= translator('category_book') ?></label>

                        <input type="radio" name="category" id="poem">
                        <label for="poem"><?= translator('category_poetry') ?></label>

                        <input type="radio" name="category" id="tale">
                        <label for="tale"><?= translator('category_story') ?></label>
                  </div>

              </div>

          </div>


  </form>


</div>














            <section>
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>

                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>

                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>


                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>


                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>



                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>



                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>



                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>




                    
                    <div class="post">
                        <div class="img"></div>
                        <div class="info">
                            <a href="LINNNNK">Title Example Like This One</a>
                            <h2>Book</h2>
                          <div class="postfooter">  
                            <h3>232 views</h3>
                            <button>&#9661</button>
                          </div>
                        </div>
                    </div>



</section>


























</main>






<script>
    const filter = document.querySelector(".filterpop");
     const abrir = document.querySelector("#abrirPop");

    
    abrir.addEventListener("click", function() {
        if(filter.style.display == "block"){
            filter.style.display = "none";
        }else{filter.style.display = "block"}

         
    });
</script>



</body>
</html>