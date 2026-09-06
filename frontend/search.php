<?php 

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Gemini
Stage: Development
Purpose: Refactoring the search page (frontend and backend integration) to consume
         vector search results from the FAISS API, build dynamic MySQL queries 
         using ORDER BY FIELD() to preserve score rankings, and render the books 
         carousel loop safely using htmlspecialchars().
Validation: Verified query parameters, PHP array structures, and rendered HTML output 
            against search results in the browser.
*/

require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/search.php'; 
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homestt.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/nav.css">
    <title>Stanza - <?= htmlspecialchars($query) ?></title>
</head>
<body>

<main>
    <div class="carousel">
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
                        <h2><?= htmlspecialchars($text['category']) ?></h2>
                        <div class="postfooter">
                            <h3><?= (int) $text['read_count'] ?> <?= translator('views') ?></h3>
                            <button>&#9661;</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>