<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    // Prepare the DELETE query with a prepared statement to prevent SQL injection
    $deleteQuery = $con->prepare("DELETE FROM categories WHERE id = ?");
    $deleteQuery->bind_param("i", $categoryId);  

    if ($deleteQuery->execute()) {
        $_SESSION['status'] = "Category deleted successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: ../categories.php");
        exit();
    } else {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error"; 
        header("Location: ../categories.php");
        exit();
    }
}
?>
