<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Claude Code
Stage: Development
Purpose: Turning the "Most favourited" carousel from static mockup markup
         into a PHP loop over the query results, mirroring the "Most viewed"
         block and escaping output with htmlspecialchars().
Validation: Rendered in the browser against the seeded data and the output
            compared with the rows returned by the query.
*/
require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/home.php';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/homestt.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/nav.css">


    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>



<main>

<form action="search.php" class="search">
     <input type="search" placeholder="<?= translator('home_search_placeholder') ?>" name="search">
       <button type="submit"><?= translator('action_search') ?></button>
    </form>


        <h1><?= translator('home_recently_viewed') ?></h1>

        <div class="carousel"> 

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





                

                    
        </div>



        <h1><?= translator('home_explore_by') ?></h1>


        <div class="Csection">
            <div class="card">
                <h1><?= translator('home_card_books') ?></h1>
                <a href="OUTRO LINK"> o </a>
            </div>
            <div class="card" style="background-color:darkcyan;">
                <h1><?= translator('home_card_poetry') ?></h1>
                <a href="OUTRO LINK"> o </a>
            </div>
            <div class="card" style="background-color:forestgreen;">
                <h1><?= translator('home_card_stories') ?></h1>
                <a href="OUTRO LINK"> o </a>
            </div>
        </div>







        <div class="Bsection">
        <p>STANZA <span style="color: rgb(29, 114, 241); font-weight: normal;"><?= translator('home_tops') ?></span></p>




        <h1><?= translator('home_most_viewed') ?></h1>

            <div class="carousel">

                <?php foreach ($most_viewed as $text): ?>
                    <div class="post">
                        <div class="img">
                            <?php if ($text['cover_image']): ?>
                                <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="info">
                            <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                            <h2><?= htmlspecialchars($text['category']) ?></h2>
                            <div class="postfooter">
                                <h3><?= (int) $text['read_count'] ?> <?= translator('views') ?></h3>
                                <button>&#9661</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>




        <h1><?= translator('home_most_favorited') ?></h1>

            <div class="carousel">

                <?php foreach ($most_favorited as $text): ?>
                    <div class="post">
                        <div class="img">
                            <?php if ($text['cover_image']): ?>
                                <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="info">
                            <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                            <h2><?= htmlspecialchars($text['category']) ?></h2>
                            <div class="postfooter">
                                <h3><?= (int) $text['favorites'] ?> <?= translator('favorites') ?></h3>
                                <button>&#9661</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>




        <h1><?= translator('home_recently_published') ?></h1>

            <div class="carousel">

                <?php foreach ($recents as $text): ?>
                    <div class="post">
                        <div class="img">
                            <?php if ($text['cover_image']): ?>
                                <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="info">
                            <a href="read.php?id=<?= (int) $text['id'] ?>"><?= htmlspecialchars($text['title']) ?></a>
                            <h2><?= htmlspecialchars($text['category']) ?></h2>
                            <div class="postfooter">
                                <h3><?= (int) $text['read_count'] ?> <?= translator('views') ?></h3>
                                <button>&#9661</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

















        <h1><?= translator('home_saved_texts') ?></h1>

        <div class="carousel"> 

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



                    
        </div>


</main>


</body>
</html>