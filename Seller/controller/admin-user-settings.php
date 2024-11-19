<?php
session_start();
include('../config/config.php');


if (isset($_POST['editProfile'])) {
    // Database connection
    // Assuming $con is your MySQLi connection

    // Collect form data
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $emailAddress = $_POST['emailAddress'];

    // Initialize profile picture variable
    $picture = '';

    // Check if a new profile picture is selected
    if (!empty($_FILES['profilePicture']['name'])) {
        // Validate file type and size as needed
        $picture = file_get_contents($_FILES['profilePicture']['tmp_name']);
    } else {
        // No new picture selected, get existing one
        $existingPictureQuery = "SELECT profilePicture FROM employee WHERE userId = ?";
        $stmt = mysqli_prepare($con, $existingPictureQuery);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingPicture);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $picture = $existingPicture;
    }

    // Prepare update query with placeholders
    $query = "UPDATE employee SET firstName = ?, middleName = ?, lastName = ?, phoneNumber = ?, emailAddress = ?, profilePicture = ? WHERE userId = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $middleName, $lastName, $phoneNumber, $emailAddress, $picture, $userId);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION['auth_user']['fullName'] = $firstName . ' ' . $lastName;
            $_SESSION['status'] = "Profile has been updated";
            $_SESSION['status_code'] = "success";
            header('Location: ../profile.php');
            exit();
        } else {
            $_SESSION['status'] = "Error updating profile: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            header('Location: ../profile.php');
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Error preparing statement: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        header('Location: ../profile.php');
        exit();
    }
      // Unreachable code
      mysqli_close($con);
}


if (isset($_POST['changePassword'])) {
    $userId = $_POST['userId'];
    $currentPassword = $_POST['currentPassword']; // Correct variable name
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate that the new password matches the re-entered password
    if ($newPassword != $confirmPassword) {
        $_SESSION['status'] = "New password and re-entered password do not match!";
        $_SESSION['status_code'] = "error";
        header('Location: ../profile.php');
        exit();
    }

    // Check the current password before updating
    $checkPasswordQuery = "SELECT `password` FROM `employee` WHERE `userId` = ?";
    $stmt = mysqli_prepare($con, $checkPasswordQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $storedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verify the current password
    if ($currentPassword == $storedPassword) { // Fix variable name
        // Update the password in the database
        $updatePasswordQuery = "UPDATE `employee` SET `password` = ? WHERE `userId` = ?";
        $stmt = mysqli_prepare($con, $updatePasswordQuery);
        mysqli_stmt_bind_param($stmt, "si", $newPassword, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['status'] = "Password changed successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: ../profile.php');
        exit();
    } else {
        $_SESSION['status'] = "Incorrect current password!";
        $_SESSION['status_code'] = "error";
        header('Location: ../profile.php');
        exit();
    }


    
    // Unreachable code
    mysqli_close($con);
}

?>