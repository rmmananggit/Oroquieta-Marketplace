<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Function to check password criteria
function validatePassword($password) {
    // Password criteria
    $minLength = 8;
    $hasUpperCase = preg_match('/[A-Z]/', $password);
    $hasLowerCase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSpecialChar = preg_match('/[\W_]/', $password);
    
    // Check password length and criteria
    if (strlen($password) < $minLength) {
        return "Password must be at least $minLength characters long.";
    } elseif (!$hasUpperCase) {
        return "Password must contain at least one uppercase letter.";
    } elseif (!$hasLowerCase) {
        return "Password must contain at least one lowercase letter.";
    } elseif (!$hasNumber) {
        return "Password must contain at least one number.";
    } elseif (!$hasSpecialChar) {
        return "Password must contain at least one special character.";
    }
    
    return true; // Password is valid
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user ID from session
    $userId = $_SESSION['auth_user']['userId'];

    // Sanitize the inputs
    $currentPassword = mysqli_real_escape_string($con, $_POST['password']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newpassword']);
    $reNewPassword = mysqli_real_escape_string($con, $_POST['renewpassword']);

    // Fetch current password from database
    $result = mysqli_query($con, "SELECT password FROM users WHERE user_id = '$userId'");
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $dbPassword = $user['password'];

        // Check if current password matches the one in the database
        if ($currentPassword === $dbPassword) {
            // Check if the new password and re-entered new password match
            if ($newPassword === $reNewPassword) {
                // Validate new password based on criteria
                $passwordValidation = validatePassword($newPassword);
                if ($passwordValidation === true) {
                    // Update the password in the database (no hashing, as per your requirement)
                    $updateQuery = "UPDATE users SET password = '$newPassword' WHERE user_id = '$userId'";
                    if (mysqli_query($con, $updateQuery)) {
                        $_SESSION['status'] = "Password updated successfully!";
                        $_SESSION['status_code'] = "success";
                        header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
                        exit();
                    } else {
                        $_SESSION['status'] = "Error updating password: " . mysqli_error($con);
                        $_SESSION['status_code'] = "error";
                        header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
                        exit();
                    }
                } else {
                    // If password doesn't meet criteria
                    $_SESSION['status'] = $passwordValidation;
                    $_SESSION['status_code'] = "error";
                    header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
                    exit();
                }
            } else {
                $_SESSION['status'] = "New passwords do not match!";
                $_SESSION['status_code'] = "error";
                header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
                exit();
            }
        } else {
            $_SESSION['status'] = "Current password is incorrect!";
            $_SESSION['status_code'] = "error";
            header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
            exit();
        }
    } else {
        $_SESSION['status'] = "User not found!";
        $_SESSION['status_code'] = "error";
        header("Location: ../profile.php#profile-change-password"); // Stay on the same tab
        exit();
    }
}
?>
