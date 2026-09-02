<?php require_once __DIR__ . '/../backend/edit.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/edit.css">
   <link rel="stylesheet" href="css/header.css">
    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>


<main>

<form id="edit-form" action="../backend/update.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $id ?>">



<!-- Web bar -->




<div class="bar">


       <a href="read.php?id=<?= $id ?>">&lt;</a>
       <button type="button" class="fecha" id="fecharBar">X</button>

    <div class="img">
        <?php if ($text['cover_image']): ?>
            <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>"
                 alt="Capa atual"
                 style="width:100%; height:100%; object-fit:cover;">
        <?php endif; ?>
    </div>

     <input
        type="file"
        id="image-picker"
        name="cover_image"

        accept="image/png, image/jpeg, image/webp"
        />





    <h2>Título</h2>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($text['title']) ?>">

    <h2>Descrição</h2>
    <textarea id="description" name="description"><?= htmlspecialchars($text['description']) ?></textarea>






    <h2>Categoria</h2>
        <select id="category" name="category">
            <option value="book"   <?= $text['category'] === 'book'   ? 'selected' : '' ?>>Livro</option>
            <option value="poetry" <?= $text['category'] === 'poetry' ? 'selected' : '' ?>>Poesia</option>
            <option value="story"  <?= $text['category'] === 'story'  ? 'selected' : '' ?>>Conto</option>
        </select>


    <h2>Idioma</h2>
        <select id="language" name="language">
            <option value="">Idioma</option>
            <option value="enus" <?= $text['language'] === 'enus' ? 'selected' : '' ?>>English</option>
            <option value="ptbr" <?= $text['language'] === 'ptbr' ? 'selected' : '' ?>>Português</option>
            <option value="es"   <?= $text['language'] === 'es'   ? 'selected' : '' ?>>Español</option>
        </select>




    <h2>Visibilidade</h2>

    <div class="visibt">

        <input type="radio" name="visibility" id="public" value="public"
               <?= $text['visibility'] === 'public' ? 'checked' : '' ?>>
        <label for="public">Público</label>

        <input type="radio" name="visibility" id="private" value="private"
               <?= $text['visibility'] === 'private' ? 'checked' : '' ?>>
        <label for="private">Privado</label>

    </div>



                    <div class="wbbt">
                    <h2>Tamanho da fonte</h2>
                    <input type="number" id="fontsize" name="fontsize" min="1" max="40">



                    <button type="submit" class="svv">Salvar</button>
              
              
                </div>

                <a class="excluir"
                   href="../backend/delete.php?id=<?= $id ?>"
                   onclick="return confirm('Apagar este texto? Esta ação não pode ser desfeita.');">🗑</a>

</div>










<!-- Mobile -->


 <div class="mbbt1">
    <a href="read.php?id=<?= $id ?>" style="margin:0;">&lt;</a>
    <a href="DPS vc muda" style="margin-left:auto;" >Salvar</a>

    <button type="button" id="abrirBar" style="margin-left:auto;">⋮</button>
</div>



    <label style="display:none;" for="body">Escrever</label>
    <textarea id="body" name="body"><?= htmlspecialchars($text['body']) ?></textarea>







    <div class="mbbt2">

        <label>12 palavras</label>

        <label>226 caracteres</label>

        <label for="fontsize">Tamanho da fonte: </label>
        <input type="number" id="fontsize" name="fontsize" min="1" max="40">
    </div>










<!-- Pop-up Mobile Buttons -->

</form>

</main>


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
