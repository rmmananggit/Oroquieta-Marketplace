<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = mysqli_real_escape_string($con, $_POST['product_id']);

    // Delete the product from the database
    $deleteProductQuery = "DELETE FROM product WHERE product_id = $productId";
    $deleteImagesQuery = "DELETE FROM product_images WHERE product_id = $productId";

    $productDeleted = mysqli_query($con, $deleteProductQuery);
    $imagesDeleted = mysqli_query($con, $deleteImagesQuery);

    if ($productDeleted && $imagesDeleted) {
        $_SESSION['status'] = "Product deleted successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: ../products.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to delete the product.";
        $_SESSION['status_code'] = "error";
        header("Location: ../products.php");
        exit();
    }

}
?>
