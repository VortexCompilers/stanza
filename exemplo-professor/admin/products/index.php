<?php

$currentPage = 'products';

require_once '../../includes/auth.php';
require_once '../../includes/header.php';
require_once '../../includes/navbar.php';
require_once '../../config/database.php';

$sql = "SELECT product_id, product_name, description, sale_price, quantity, unit, image 
        FROM products 
        ORDER BY product_name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container py-4">

    <section class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1"><?= $text['products'] ?></h1>
            <p class="text-muted mb-0">
                <?= $text['products_management'] ?>
            </p>
        </div>

        <a href="create.php" class="btn tf-btn-primary">
            <?= $text['new_product'] ?>
        </a>
    </section>

    <section class="card tf-card">
        <div class="card-body">

            <?php if (empty($products)): ?>

            <div class="text-center py-5">

                <img src="../../assets/img/tabletop-menu.png" alt="Table menu"
                    class="img-fluid rounded-4 shadow-sm mb-4" style="max-width: 280px;">

                <h3 class="fw-bold mb-3">
                    <?= $text['no_products_found'] ?>
                </h3>

                <p class="text-muted mb-4">
                    <?= $text['start_products_message'] ?>
                </p>

                <a href="create.php" class="btn tf-btn-primary">
                    <?= $text['new_product'] ?>
                </a>

            </div>

            <?php else: ?>


<div class="row g-4">
    <?php foreach ($products as $product): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <article class="card tf-card h-100">

                <?php if (!empty($product['image'])): ?>
                    <img 
                        src="../../assets/uploads/products/<?= htmlspecialchars($product['image']) ?>" 
                        class="tf-product-card-image"
                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                    >
                <?php else: ?>
                    <div class="tf-product-card-placeholder">
                        <?= $text['no_image'] ?>
                    </div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">
                        <?= htmlspecialchars($product['product_name']) ?>
                    </h5>

                    <p class="card-text text-muted flex-grow-1">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>

                    <div class="mb-3">
                        <span class="badge tf-price-badge">
                            € <?= number_format($product['sale_price'], 2, ',', '.') ?>
                        </span>

                        <span class="badge text-bg-light">
                            <?= number_format($product['quantity'], 3, ',', '.') ?>
                            <?= htmlspecialchars($product['unit']) ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="edit.php?id=<?= $product['product_id'] ?>" class="btn btn-sm btn-outline-secondary w-100">
                            <?= $text['edit'] ?>
                        </a>

                        <a 
                            href="delete.php?id=<?= $product['product_id'] ?>" 
                            class="btn btn-sm btn-outline-danger w-100"
                            onclick="return confirm('<?= htmlspecialchars($text['confirm_delete'], ENT_QUOTES) ?>');"
                        >
                            <?= $text['delete'] ?>
                        </a>
                    </div>
                </div>

            </article>
        </div>
    <?php endforeach; ?>
</div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php require_once '../../includes/footer.php'; ?>