<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Ensure the 'orderId' is set via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];

    // Prepare the DELETE query with a prepared statement to prevent SQL injection
    $deleteQuery = $con->prepare("DELETE FROM cart WHERE id = ?");
    $deleteQuery->bind_param("i", $orderId);  

    if ($deleteQuery->execute()) {
        $_SESSION['status'] = "Order has been deleted.";
        $_SESSION['status_code'] = "success";
        header("Location: ../orders.php");  // Redirect back to the orders page
        exit();
    } else {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error"; 
        header("Location: ../orders.php");  // Redirect back to the orders page
        exit();
    }
}
?>
