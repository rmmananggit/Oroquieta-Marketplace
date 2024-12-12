<?php
session_start();
include(__DIR__ . '/../config/config.php');

if (!isset($_SESSION['auth_user']['userId'])) {
    echo "not_logged_in";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input values
    $order_id = mysqli_real_escape_string($con, $_POST['id']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    
    // Check if quantity is valid
    if ($quantity <= 0) {
        $_SESSION['status'] = "Invalid quantity.";
        $_SESSION['status_code'] = "error";
        header("Location: ../orders.php");
        exit();
    }

    // Get the current product quantity from the database to verify stock availability
    $sql_product = "SELECT quantity FROM cart WHERE id = ?";
    $stmt_product = $con->prepare($sql_product);
    $stmt_product->bind_param("i", $order_id);
    $stmt_product->execute();
    $result = $stmt_product->get_result();
    $order = $result->fetch_assoc();
    
    if (!$order) {
        $_SESSION['status'] = "Order not found.";
        $_SESSION['status_code'] = "error";
        header("Location: ../orders.php");
        exit();
    }

    // Update the order quantity if stock is available
    $sql_update = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param("ii", $quantity, $order_id);
    if ($stmt_update->execute()) {
        $_SESSION['status'] = "Order updated successfully.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error updating order.";
        $_SESSION['status_code'] = "error";
    }
    
    header("Location: ../orders.php");
    exit();
} else {
    echo "Invalid request method.";
    exit();
}
?>
