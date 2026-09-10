<?php
require_once __DIR__ . '/lang/load.php';
require_once __DIR__ . '/../backend/profile.php';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/nav.css">


    <title>Stanza</title>
</head>
<body>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>



<main>

          <div class="topbar">

            <div class="topinf">
                <div class="pfp"></div>

                    <div class="userinfo">
                        <h1><?= htmlspecialchars($user['name']) ?></h1>
                        <h2><?= sprintf(translator('profile_joined'), htmlspecialchars($joined_at)) ?></h2>
                  </div>

              </div>


            <div class="botinf">
                <div class="nbinfo">
                  <span><?= $total_views ?></span>
                  <p><?= translator('profile_views') ?></p>
                </div>

                <div class="nbinfo">
                <span><?= $texts_written ?></span>
                  <p><?= translator('profile_texts_written') ?></p>
                </div>

                <div class="nbinfo">
                  <span><?= $texts_saved ?></span>
                  <p><?= translator('profile_texts_saved') ?></p>
                </div>


            </div>

          </div>




            <section>

                <?php foreach ($texts as $text): ?>
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

</section>


</main>


</body>
</html>
