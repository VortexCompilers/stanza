<?php

require_once '../../includes/auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$productName = trim($_POST['product_name'] ?? '');
$description = trim($_POST['description'] ?? '');
$salePrice = $_POST['sale_price'] ?? 0;
$quantity = $_POST['quantity'] ?? 0;
$unit = trim($_POST['unit'] ?? '');
$barcode = trim($_POST['barcode'] ?? '');

$imageName = null;

// Product image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../assets/uploads/products/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $originalName = $_FILES['image']['name'];
    $temporaryPath = $_FILES['image']['tmp_name'];
    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        header('Location: create.php?error=invalid_image');
        exit;
    }

    $imageName = uniqid('product_', true) . '.' . $fileExtension;
    $destinationPath = $uploadDir . $imageName;

    move_uploaded_file($temporaryPath, $destinationPath);
}

$sql = "INSERT INTO products 
        (product_name, description, sale_price, quantity, unit, barcode, image)
        VALUES
        (:product_name, :description, :sale_price, :quantity, :unit, :barcode, :image)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':product_name' => $productName,
    ':description' => $description,
    ':sale_price' => $salePrice,
    ':quantity' => $quantity,
    ':unit' => $unit,
    ':barcode' => $barcode,
    ':image' => $imageName
]);

header('Location: index.php');
exit;