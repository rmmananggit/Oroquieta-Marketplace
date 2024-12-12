<?php
session_start();
include(__DIR__ . '/../config/config.php');

if (isset($_GET['cart_id'], $_GET['product_id'], $_GET['quantity'])) {
    $cartId = mysqli_real_escape_string($con, $_GET['cart_id']);
    $productId = mysqli_real_escape_string($con, $_GET['product_id']);
    $quantity = mysqli_real_escape_string($con, $_GET['quantity']);

    mysqli_begin_transaction($con);
    try {
        $updateCartQuery = "UPDATE cart SET status = 'Completed' WHERE id = '$cartId'";
        if (!mysqli_query($con, $updateCartQuery)) {
            throw new Exception("Failed to update cart status: " . mysqli_error($con));
        }

        $updateProductQuery = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = '$productId'";
        if (!mysqli_query($con, $updateProductQuery)) {
            throw new Exception("Failed to update product quantity: " . mysqli_error($con));
        }

        mysqli_commit($con);

        $_SESSION['status'] = "Item marked as sold successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: ../orders.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($con);

        $_SESSION['status'] = "Error marking item as sold: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
        header("Location: ../orders.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid request. Missing required fields.";
    $_SESSION['status_code'] = "error";
    header("Location: ../orders.php");
    exit();
}
