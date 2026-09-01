<?php require_once __DIR__ .'/../backend/settings.php'?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/settings.css">
 <link rel="stylesheet" href="css/header.css">
 <link rel="stylesheet" href="css/nav.css">



    <title>Stanza</title>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>


<main>



        <h1>Geral</h1>
                <div class="stsbox">
            
                        <h2>Tema</h2>

                                <div class="rdbt">
                                <input type="radio" name="theme" id="light" checked>
                                <label for="light">Claro</label>

                                <input type="radio" name="theme" id="dark">
                                <label for="dark">Escuro</label>
                                    </div>

                            </div>






                <div class="stsbox">
                <h2>Tamanho de fonte padrão</h2>

                    
                    <input type="range" name="fontsize" id="fontsie" min="1" max="50" value="12">
                    <label>31</label>

                </div>







                <div class="stsbox">

                        <h2>Idioma</h2>

                        <div class="rdbt">
                            <input type="radio" name="languagew" id="ptbr" checked>
                            <label for="ptbr">PT-BR</label>

                            <input type="radio" name="languagew" id="enus">
                            <label for="enus">EN-US</label>
                            
                            <input type="radio" name="languagew" id="eses">
                            <label for="eses">ES-419</label>
                                </div>

                        </div>










        <h1>Perfil</h1>





            <div class="stsbox1" style="gap:10px;"> 
                    <!--  Different -->
                        <h2 style="margin: auto 6px;" >Foto de Perfil</h2>

                        <div class="stpic"></div>

            <button>Editar</button>
            </div>







            <div class="stsbox1">
                    <div class="stsinfo"> 
                        <h2>Nome de usuário</h2>

                            <label><?= htmlspecialchars($user['name']) ?></label> 

                    </div>
            <button>Editar</button>
            </div>

            <div class="stsbox1">
                    <div class="stsinfo"> 
                        <h2>E-mail</h2>

                        <label><?= htmlspecialchars($user['email'])?></label> 

                    </div>
            <button>Editar</button>
            </div>

            
            <div class="stsbox1">
                    <div class="stsinfo"> 
                        <h2>Senha</h2>

                        <label>***</label> 

                    </div>
            <button>Editar</button>
            </div>




        <button class="dlbt">Deletar conta</button>


        <a class="lvbt" href="../backend/logout.php">Sair</a>


</main>


</body>
</html>