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

    if ($password != $re_pass) {
        $_SESSION['status'] = "Passwords do not match!";
        $_SESSION['status_code'] = "error";
        header('Location: ../signup.php');
        exit(0);
    }

    $otp = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);

    $query = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `role`, `otp`) 
              VALUES ('$firstName', '$middleName', '$lastName', '$userName', '$password', '$emailAddress', '$role', '$otp')";

    if (mysqli_query($con, $query)) {
        $_SESSION['status'] = "You are registered as a User!";
        $_SESSION['status_code'] = "success";
        header('Location: ../index.php');
        exit(0);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
