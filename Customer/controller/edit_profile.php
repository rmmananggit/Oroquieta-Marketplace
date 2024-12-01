<?php
session_start();
include(__DIR__ . '/../config/config.php');

// Check if the form is submitted
if (isset($_POST['editProfile'])) {
    $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $about = mysqli_real_escape_string($con, $_POST['about']);
    $street = mysqli_real_escape_string($con, $_POST['street']);
    $baranggay = mysqli_real_escape_string($con, $_POST['baranggay']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $twitter = mysqli_real_escape_string($con, $_POST['twitter']);
    $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
    $instagram = mysqli_real_escape_string($con, $_POST['instagram']);

    $profileImageQueryPart = ""; // To store image-related query part

    // Handle image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $imageTmpName = $_FILES['profile_image']['tmp_name'];
        $imageData = file_get_contents($imageTmpName);
        $profileImage = mysqli_real_escape_string($con, $imageData);
        $profileImageQueryPart = ", profile_image = '$profileImage'";
    }

    // Handle delete image
    if (isset($_POST['deleteImage']) && $_POST['deleteImage'] == '1') {
        $profileImageQueryPart = ", profile_image = NULL"; // Set to NULL if user wants to delete image
    }

    // Update query
    $updateQuery = "UPDATE users SET 
                    first_name = '$firstName',
                    last_name = '$lastName',
                    aboutme = '$about',
                    address_street = '$street',
                    address_baranggay = '$baranggay',
                    phone_number = '$phone',
                    email = '$email',
                    twitterLink = '$twitter',
                    facebookLink = '$facebook',
                    instagramLink = '$instagram'
                    $profileImageQueryPart
                    WHERE user_id = $userId";

    // Execute the query
    if (mysqli_query($con, $updateQuery)) {
        $_SESSION['status'] = "Profile updated successfully!";
        $_SESSION['status_code'] = "success"; 
        header("Location: ../profile.php"); // Redirect to profile page
        exit();
    } else {
        $_SESSION['status'] = "Error updating profile: " . mysqli_error($con);
        $_SESSION['status_code'] = "error"; 
        header("Location: ../profile.php"); // Redirect to profile page with error message
        exit();
    }
}
?>
