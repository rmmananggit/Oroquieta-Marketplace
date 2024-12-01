<?php
session_start();
include(__DIR__ . '/../config/config.php');

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']); // Sanitize the product_id

    // Query to get the product details
    $query = "SELECT product_id, name, description, price, category, quantity FROM product WHERE product_id = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Return the product details as JSON
            echo json_encode($row);
        } else {
            echo json_encode(null); // If no product is found
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(null); // If query fails
    }
}
?>
