<?php
include("../config/config.php");
session_start();

$userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
$activity_type = "New Listing";

if (isset($_POST['addproduct'])) {
    $product_name = $_POST['product_name'];
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $images = !empty($_FILES['images']['name'][0]) ? $_FILES['images'] : null;

    // Insert the product into the `product` table
    $query = "INSERT INTO `product`(`vendor_id`, `name`, `description`, `price`, `category`, `quantity`, `status`) 
              VALUES ('$userId', '$product_name', '$description', '$price', '$category', '$quantity', 'available')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Get the last inserted product ID
        $product_id = mysqli_insert_id($con);

        // Log the activity
        $activity_description = "Vendor added a new product: $product_name (ID: $product_id)";
        $activity_log = "INSERT INTO `recent_activities`(`user_id`, `activity_type`, `description`) 
                         VALUES ('$userId', '$activity_type', '$activity_description')";
        mysqli_query($con, $activity_log);

        // Check if files were uploaded
        if (!empty($images['name'][0])) {
            for ($i = 0; $i < count($images['name']); $i++) {
                $file_name = $images['name'][$i];
                $file_tmp = $images['tmp_name'][$i];

                // Ensure the file is an image
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                if (in_array($file_ext, $allowed_extensions)) {
                    // Read the file contents
                    $image_data = file_get_contents($file_tmp);

                    // Insert the binary data into the `product_images` table
                    $image_query = "INSERT INTO `product_images`(`product_id`, `image`) VALUES (?, ?)";
                    $stmt = mysqli_prepare($con, $image_query);
                    mysqli_stmt_bind_param($stmt, 'ib', $product_id, $image_data);
                    mysqli_stmt_send_long_data($stmt, 1, $image_data);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
            }
        }

        $_SESSION['status'] = "Product has been listed!";
        $_SESSION['status_code'] = "success";
        header('Location: ../products.php');
        exit(0);
    } else {
        echo "Error: " . mysqli_error($con);
    }
    mysqli_close($con);
}
?>
