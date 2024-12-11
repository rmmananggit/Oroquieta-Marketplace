<?php
include("../config/config.php");
session_start();

if (isset($_POST['signup'])) {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $re_pass = $_POST['re_pass'];
    $role = "seller"; // Set the role as 'vendor'

    // Validate if password and re_pass match
    if ($password != $re_pass) {
        $_SESSION['status'] = "Passwords do not match!";
        $_SESSION['status_code'] = "error";
        header('Location: ../signup.php'); // Redirect back to signup page
        exit(0);
    }

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `role`) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssss", $firstName, $middleName, $lastName, $userName, $password, $emailAddress, $role);

    if ($stmt->execute()) {
        $_SESSION['status'] = "You are registered as a Vendor!";
        $_SESSION['status_code'] = "success";
        header('Location: ../index.php');
        exit(0);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    $stmt->close();
    mysqli_close($con);
}
?>
