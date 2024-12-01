<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $productId = intval($_POST['product_id']); // Get product ID
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = intval($_POST['category']);
    $quantity = intval($_POST['quantity']);

    // Check if all required fields are filled
    if (empty($productName) || empty($description) || empty($price) || empty($category) || empty($quantity)) {
        $_SESSION['status'] = "Please fill all fields.";
        $_SESSION['status_code'] = "error";
        header('Location: ../products.php');
        exit(0);
    }

    // Prepare the SQL update query
    $updateQuery = "UPDATE product SET 
                    `name` = ?, 
                    description = ?, 
                    price = ?, 
                    category = ?, 
                    quantity = ? 
                    WHERE product_id = ?";

    if ($stmt = mysqli_prepare($con, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, 'ssdiis', $productName, $description, $price, $category, $quantity, $productId);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status'] = "Product details updated successfully.";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Failed to update product details.";
            $_SESSION['status_code'] = "error";
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Error preparing the update query.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect to the product page
    header('Location: ../products.php');
    exit(0);
} else {
    // If the form is not submitted, redirect back
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header('Location: ../products.php');
    exit(0);
}
?>
