<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['cartId'], $data['productId'], $data['quantity'])) {
        $cartId = mysqli_real_escape_string($con, $data['cartId']);
        $productId = mysqli_real_escape_string($con, $data['productId']);
        $quantity = mysqli_real_escape_string($con, $data['quantity']);

        mysqli_begin_transaction($con);
        try {
            // Update the cart status to 'Sold'
            $updateCartQuery = "UPDATE cart SET status = 'Completed' WHERE id = '$cartId'";
            if (!mysqli_query($con, $updateCartQuery)) {
                throw new Exception("Failed to update cart status: " . mysqli_error($con));
            }

            // Deduct the quantity from the product
            $updateProductQuery = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = '$productId'";
            if (!mysqli_query($con, $updateProductQuery)) {
                throw new Exception("Failed to update product quantity: " . mysqli_error($con));
            }

            // Commit the transaction
            mysqli_commit($con);

            // Success message
            $_SESSION['status'] = "Item marked as sold successfully.";
            $_SESSION['status_code'] = "success";
            header("Location: ../orders.php");
            exit();
        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($con);

            // Error message
            $_SESSION['status'] = "Error marking item as sold: " . $e->getMessage();
            $_SESSION['status_code'] = "error";
            header("Location: ../orders.php");
            exit();
        }
    } else {
        // Error for invalid data
        $_SESSION['status'] = "Invalid request. Missing required fields.";
        $_SESSION['status_code'] = "error";
        header("Location: ../orders.php");
        exit();
    }
} else {
    // Error for invalid request method
    $_SESSION['status'] = "Invalid request method.";
    $_SESSION['status_code'] = "error";
    header("Location: ../orders.php");
    exit();
}
