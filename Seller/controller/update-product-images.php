<?php
session_start();
include(__DIR__ . '/../config/config.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $imageId = intval($_POST['image_id']); // Convert to integer

    if ($action === 'delete') {
        $deleteQuery = "DELETE FROM product_images WHERE image_id = ?";
        if ($stmt = mysqli_prepare($con, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, 'i', $imageId);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['status'] = "Image deleted successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to delete the image.";
                $_SESSION['status_code'] = "error";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['status'] = "Error preparing the delete query.";
            $_SESSION['status_code'] = "error";
        }
    } elseif ($action === 'set_primary') {
        $productId = intval($_POST['product_id']); // Convert to integer

        // Prepare and execute the reset primary query
        $resetQuery = "UPDATE product_images SET is_primary = 0 WHERE product_id = ?";
        if ($stmt = mysqli_prepare($con, $resetQuery)) {
            mysqli_stmt_bind_param($stmt, 'i', $productId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Prepare and execute the set primary query
        $setPrimaryQuery = "UPDATE product_images SET is_primary = 1 WHERE image_id = ?";
        if ($stmt = mysqli_prepare($con, $setPrimaryQuery)) {
            mysqli_stmt_bind_param($stmt, 'i', $imageId);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['status'] = "Image set as primary successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to set the image as primary.";
                $_SESSION['status_code'] = "error";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['status'] = "Error preparing the set primary query.";
            $_SESSION['status_code'] = "error";
        }
    }
}
?>
