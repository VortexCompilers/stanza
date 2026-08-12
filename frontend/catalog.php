<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/catalog.css">
  <link rel="stylesheet" href="css/header.css">


    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>




<main>


<div class="filtersec">

<form action="/search" method="get">
    <input type="search" name="catal" placeholder="Pesquisar..." aria-label="Search">
   
    

       <a id="abrirPop">▼ Filtrar</a>

    <button type="submit">Pesquisar</button>

  </form>



          <div class="filterpop">
          <h1>Filtrar</h1>


          <h2>Ordenar por</h2>
                <div class="stsbox">  
                  <div class="rdbt">
                        <input type="radio" name="order" id="recent" checked>
                        <label for="recent">Recentes</label>

                        <input type="radio" name="order" id="save">
                        <label for="save">Mais salvos</label>
                        
                        <input type="radio" name="order" id="view">
                        <label for="view">Mais vistos</label>
                  </div>
        
              </div>


          <h2>Categoria</h2>
                <div class="stsbox">  
                  <div class="rdbt">
                        <input type="radio" name="category" id="book" checked>
                        <label for="book">Livro</label>

                        <input type="radio" name="category" id="poem">
                        <label for="poem">Poema</label>
                        
                        <input type="radio" name="category" id="tale">
                        <label for="tale">Conto</label>
                  </div>
        
              </div>

          </div>



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