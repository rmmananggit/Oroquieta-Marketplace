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
            users.username = '$emailAddress' AND
            users.password = '$password'
        LIMIT 1";
    
    $login_query_run = mysqli_query($con, $login_query);

    if ($login_query_run) {
        if (mysqli_num_rows($login_query_run) > 0) {
            $data = mysqli_fetch_assoc($login_query_run);

            $userId = $data['user_id'];
            $fullName = $data['first_name'] . ' ' . $data['last_name'];
            $userEmailAddress = $data['email'];
            $accountStatus = $data['account_status'];
            $userRole = $data['role'];

            // Update the last_login column with the current timestamp
            $update_last_login_query = "UPDATE users SET last_login = NOW() WHERE user_id = '$userId'";
            mysqli_query($con, $update_last_login_query);

            $_SESSION['auth'] = true;
            $_SESSION['userRole'] = $userRole;
            $_SESSION['accountStatus'] = $accountStatus;
            $_SESSION['auth_user'] = [
                'userId' => $userId,
                'fullName' => $fullName,
                'userEmail' => $userEmailAddress,
            ];

            // Account status checks
            if ($accountStatus == 'Suspended') {
                $_SESSION['status'] = "Your account has been suspended!";
                $_SESSION['status_code'] = "warning";
                header("Location: ../index.php");
                exit();
            } elseif ($accountStatus == 'Pending') {
                $_SESSION['status'] = "Your account is still pending";
                $_SESSION['status_code'] = "info";
                header("Location: ../index.php");
                exit();
            } elseif ($accountStatus == 'Active') {
                $_SESSION['status'] = "Welcome $fullName!";
                $_SESSION['status_code'] = "success";

                // Role-based redirection
                if ($userRole == 'admin') {
                    header("Location: ../Admin/index.php"); 
                } elseif ($userRole == 'buyer') {
                    header("Location: ../Customer/index.php");
                } elseif ($userRole == 'seller') {
                    header("Location: ../Seller/index.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            }
        } else {
            // No user found with this username and password
            $_SESSION['status'] = "Invalid Credentials";
            $_SESSION['status_code'] = "error";
            header("Location: ../index.php");
            exit();
        }
    } else {
        // Handle the query execution error
        $_SESSION['status'] = "Error executing the login query: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid request";
    $_SESSION['status_code'] = "error";
    header("Location: ../index.php");
    exit();
}
?>
