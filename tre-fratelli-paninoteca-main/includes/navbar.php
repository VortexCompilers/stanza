<nav class="navbar navbar-expand-lg navbar-dark tf-navbar">

    <div class="container">


        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/admin/dashboard.php">
            Tre Fratelli
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>"href="<?= BASE_URL ?>/admin/dashboard.php">
                        <?= $text['dashboard'] ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'products' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/admin/products/index.php">
                        <?= $text['products'] ?>
                    </a>
                </li>

            </ul>

            <div class="d-flex gap-2">

                <a href="?lang=it" class="btn btn-sm btn-outline-light">
                    IT
                </a>

                <a href="?lang=en-gb" class="btn btn-sm btn-outline-light">
                    EN
                </a>

                <a href="?lang=pt-pt" class="btn btn-sm btn-outline-light">
                    PT
                </a>

                <a href="<?= BASE_URL ?>/admin/logout.php" class="btn btn-sm btn-warning">
                    <?= $text['logout'] ?>
                </a>

            </div>

        </div>

    </div>

</nav>