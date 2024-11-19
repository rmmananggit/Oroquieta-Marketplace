<?php
session_start();
include('../config/config.php');

if (isset($_POST['signin'])) {
    $emailAddress = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "
        SELECT
            users.user_id, 
            users.username, 
            users.email, 
            users.password, 
            users.role, 
            users.first_name, 
            users.last_name, 
            users.profile_image, 
            users.account_status, 
            users.verification_status
        FROM
            users
             WHERE
        users.username = '$username' AND
        users.`password` = '$password'
        LIMIT 1";
    
    $login_query_run = mysqli_query($con, $login_query);

    if ($login_query_run) {
        if (mysqli_num_rows($login_query_run) > 0) {
            $data = mysqli_fetch_assoc($login_query_run);
            // Assuming passwords are hashed, you'll need to verify the password
            if (password_verify($password, $data['password'])) {

                $userId = $data['user_id'];
                $fullName = $data['first_name'] . ' ' . $data['last_name'];
                $userEmailAddress = $data['email'];
                $accountStatus = $data['account_status'];
                $userRole = $data['role']; 

                $_SESSION['auth'] = true;
                $_SESSION['userRole'] = $userRole;
                $_SESSION['accountStatus'] = $accountStatus;
                $_SESSION['auth_user'] = [
                    'userId' => $userId,
                    'fullName' => $fullName,
                    'userEmail' => $userEmailAddress,
                ];

                // Account status checks
                if ($accountStatus == 'suspended') {
                    $_SESSION['status'] = "Your account has been suspended!";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../login.php");
                    exit();
                } elseif ($accountStatus == 'pending') {
                    $_SESSION['status'] = "Your account is still pending";
                    $_SESSION['status_code'] = "info";
                    header("Location: ../login.php");
                    exit();
                } elseif ($accountStatus == 'active') {
                    $_SESSION['status'] = "Welcome $fullName!";
                    $_SESSION['status_code'] = "success";

                    // Role-based redirection
                    if ($userRole == 'admin') {
                        header("Location: ../Admin/index.php");
                    } elseif ($userRole == 'buyer') {
                        header("Location: ../buyer/index.php");
                    } elseif ($userRole == 'seller') {
                        header("Location: ../seller/index.php");
                    } else {
                        header("Location: ../index.php");
                    }
                    exit();
                }
            }
             else {
                // Incorrect password
                $_SESSION['status'] = "Invalid Credentials";
                $_SESSION['status_code'] = "error";
                header("Location: ../login.php");
                exit();
            }
        } else {
            // No user found with this email
            $_SESSION['status'] = "Invalid Credentials";
            $_SESSION['status_code'] = "error";
            header("Location: ../login.php");
            exit();
        }
    } else {
        // Handle the query execution error
        $_SESSION['status'] = "Error executing the login query: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        header("Location: ../login.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid request";
    $_SESSION['status_code'] = "error";
    header("Location: ../login.php");
    exit();
}
?>
