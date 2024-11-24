<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['description'])) {
    $categoryName = mysqli_real_escape_string($con, $_POST['name']);
    $categoryDescription = mysqli_real_escape_string($con, $_POST['description']);

    // Insert new category into the database
    $insertQuery = "INSERT INTO categories (name, description) VALUES ('$categoryName', '$categoryDescription')";

    if (mysqli_query($con, $insertQuery)) {
        $_SESSION['status'] = "Category added successfully.";
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
