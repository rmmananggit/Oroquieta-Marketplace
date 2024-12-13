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
    $role = "seller";

    // Check if password and confirm password match
    if ($password != $re_pass) {
        $_SESSION['status'] = "Passwords do not match!";
        $_SESSION['status_code'] = "error";
        header('Location: ../index.php');
        exit(0);
    }

    // Check if email or username already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$emailAddress' OR username = '$userName'";
    $result = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = "Email address or username is already taken!";
        $_SESSION['status_code'] = "error";
        header('Location: ../index.php');
        exit(0);
    }

    // Generate OTP
    $otp = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);

    // Insert new user into the database
    $query = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `role`, `otp`) 
              VALUES ('$firstName', '$middleName', '$lastName', '$userName', '$password', '$emailAddress', '$role', '$otp')";

    if (mysqli_query($con, $query)) {
        $_SESSION['status'] = "You are registered as a Merchant!";
        $_SESSION['status_code'] = "success";
        header('Location: ../index.php');
        exit(0);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
