<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = mysqli_real_escape_string($con, $_POST['product_id']);

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Delete associated images first
        $deleteImagesQuery = "DELETE FROM product_images WHERE product_id = $productId";
        $imagesDeleted = mysqli_query($con, $deleteImagesQuery);

        if (!$imagesDeleted) {
            throw new Exception("Failed to delete associated images: " . mysqli_error($con));
        }

        // Delete the product
        $deleteProductQuery = "DELETE FROM product WHERE product_id = $productId";
        $productDeleted = mysqli_query($con, $deleteProductQuery);

        if (!$productDeleted) {
            throw new Exception("Failed to delete product: " . mysqli_error($con));
        }

        // Commit transaction
        mysqli_commit($con);

        $_SESSION['status'] = "Product deleted successfully.";
        $_SESSION['status_code'] = "success";
    } catch (Exception $e) {
        // Rollback transaction on failure
        mysqli_rollback($con);

        $_SESSION['status'] = "Error deleting product: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    // Redirect back to products page
    header("Location: ../products.php");
    exit();
}
?>
