<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Check if user ID is set in session
if (!isset($_SESSION['auth_user']['userId'])) {
    die('User is not logged in');
}

// Sanitize user ID from the session
$userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = mysqli_real_escape_string($con, $_POST['product_id']);
    $activity_type = 'Deleted Listing'; // Activity type (you can adjust as needed)

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Get the product name before deletion
        $getProductNameQuery = "SELECT name FROM product WHERE product_id = $productId";
        $result = mysqli_query($con, $getProductNameQuery);

        if (!$result || mysqli_num_rows($result) == 0) {
            throw new Exception("Product not found.");
        }

        $product = mysqli_fetch_assoc($result);
        $productName = $product['name'];  // Store the product name for activity log

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

        // Log the activity with the product name
        $activity_description = "Deleted product: $productName";
        $activity_log = "INSERT INTO `recent_activities`(`user_id`, `activity_type`, `description`, `created_at`) 
                         VALUES ('$userId', '$activity_type', '$activity_description', NOW())";

        // Check if the query is successful
        if (!mysqli_query($con, $activity_log)) {
            throw new Exception('Error inserting activity log: ' . mysqli_error($con));
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
