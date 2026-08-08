<?php

$currentPage = 'dashboard';

require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<main class="container py-4">

    <section class="mb-4">
        <h1 class="fw-bold"><?= $text['dashboard'] ?></h1>
        <p class="text-muted">
            <?= $text['welcome'] ?>, <?= htmlspecialchars($_SESSION['user']) ?>.
            <?= $text['internal_system'] ?>.
        </p>
    </section>

    <section class="row g-4">

        <div class="col-12 col-md-4">
            <div class="card tf-card h-100">
                <img src="../assets/img/tabletop-menu.png" class="card-img-top" alt="Table menu">
                <div class="card-body">
                    <h5 class="card-title"><?= $text['products'] ?></h5>
                    <p class="card-text">
                        Manage panini, drinks and menu items.
                    </p>
                    <a href="products/index.php" class="btn tf-btn-primary">
                        Open
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card tf-card h-100">
                <img src="../assets/img/interior-view.png" class="card-img-top" alt="Interior view">
                <div class="card-body">
                    <h5 class="card-title"><?= $text['orders'] ?></h5>
                    <p class="card-text">
                        View and control internal orders.
                    </p>
                    <a href="#" class="btn tf-btn-secondary disabled">
                        Coming soon
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card tf-card h-100">
                <img src="../assets/img/storefront-photo.png" class="card-img-top" alt="Storefront photo">
                <div class="card-body">
                    <h5 class="card-title"><?= $text['cashier'] ?></h5>
                    <p class="card-text">
                        Control payments and cashier operations.
                    </p>
                    <a href="#" class="btn tf-btn-secondary disabled">
                        Coming soon
                    </a>
                </div>
            </div>
        </div>

    </section>

</main>

<?php require_once '../includes/footer.php'; ?>