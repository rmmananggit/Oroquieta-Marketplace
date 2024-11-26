<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Check if the delete image button was clicked
if (isset($_POST['deleteImage'])) {
    $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);

    // SQL query to update the user's profile image to NULL (delete the image)
    $updateQuery = "UPDATE users SET profile_image = NULL WHERE user_id = $userId";

    // Execute the query
    if (mysqli_query($con, $updateQuery)) {
        $_SESSION['status'] = "Profile image removed successfully!";
        $_SESSION['status_code'] = "success"; 
        header("Location: ../profile.php"); // Redirect to profile page
        exit();
    } else {
        $_SESSION['status'] = "Error removing profile image: " . mysqli_error($con);
        $_SESSION['status_code'] = "error"; 
        header("Location: ../profile.php"); // Redirect to profile page with error message
        exit();
    }
}
?>
