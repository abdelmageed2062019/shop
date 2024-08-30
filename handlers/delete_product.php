<?php
require_once '../classes/Database.php';
require_once '../classes/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($productId) {
        $db = new Database();
        $conn = $db->getConnection();
        $product = new Product($conn);

        if ($product->delete($productId)) {
            header("Location: ../index.php?message=Product+deleted+successfully");
            exit();
        } else {
            echo "Error: Could not delete the product.";
        }
    } else {
        echo "Error: Invalid product ID.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>