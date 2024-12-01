<?php
include("../config/config.php");  // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $categoryId = $_POST['id'];
    $categoryName = mysqli_real_escape_string($con, $_POST['name']);
    $categoryDescription = mysqli_real_escape_string($con, $_POST['description']);

    // Update category query
    $updateQuery = "UPDATE categories SET name = '$categoryName', description = '$categoryDescription' WHERE id = '$categoryId'";

    if (mysqli_query($con, $updateQuery)) {
        // Success message
        echo json_encode([
            'success' => true,
            'message' => 'Category has been updated!'
        ]);
    } else {
        // Error message
        echo json_encode([
            'success' => false,
            'message' => 'Error updating category. Please try again later.'
        ]);
    }
}
?>
