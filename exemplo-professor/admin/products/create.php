<?php

$currentPage = 'products';

require_once '../../includes/auth.php';
require_once '../../includes/header.php';
require_once '../../includes/navbar.php';
?>

<main class="container py-4">

    <section class="mb-4">
        <h1 class="fw-bold mb-1"><?= $text['new_product'] ?></h1>
        <p class="text-muted mb-0">
            <?= $text['create_product_message'] ?>
        </p>
    </section>

    <section class="card tf-card">
        <div class="card-body">

            <form action="store.php" method="post" enctype="multipart/form-data">

                <div class="row g-3">

                    <div class="col-12 col-md-6">
                        <label for="product_name" class="form-label">
                            <?= $text['product_name'] ?>
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="product_name" 
                            name="product_name" 
                            maxlength="80"
                            required
                        >
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="sale_price" class="form-label">
                            <?= $text['price'] ?>
                        </label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="sale_price" 
                            name="sale_price" 
                            step="0.01"
                            min="0"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">
                            <?= $text['description'] ?>
                        </label>
                        <textarea 
                            class="form-control" 
                            id="description" 
                            name="description" 
                            rows="3"
                            maxlength="255"
                            required
                        ></textarea>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="quantity" class="form-label">
                            <?= $text['quantity'] ?>
                        </label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="quantity" 
                            name="quantity" 
                            step="0.001"
                            min="0"
                            value="0"
                            required
                        >
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="unit" class="form-label">
                            <?= $text['unit'] ?>
                        </label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option value="unit"><?= $text['unit_item'] ?></option>
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="l">l</option>
                            <option value="ml">ml</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="barcode" class="form-label">
                            <?= $text['barcode'] ?>
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="barcode" 
                            name="barcode" 
                            maxlength="30"
                        >
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label">
                            <?= $text['product_image'] ?>
                        </label>
                        <input 
                            type="file" 
                            class="form-control" 
                            id="image" 
                            name="image"
                            accept="image/png, image/jpeg, image/webp"
                        >
                        <small class="text-muted">
                            <?= $text['image_help'] ?>
                        </small>
                    </div>

                </div>

                <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                    <button type="submit" class="btn tf-btn-primary">
                        <?= $text['save'] ?>
                    </button>

                    <a href="index.php" class="btn btn-outline-secondary">
                        <?= $text['cancel'] ?>
                    </a>
                </div>

            </form>

        </div>
    </section>

</main>

<?php require_once '../../includes/footer.php'; ?>