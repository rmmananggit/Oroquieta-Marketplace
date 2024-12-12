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

    $query = "INSERT INTO `product`(`vendor_id`, `name`, `description`, `price`, `category`, `quantity`, `status`) 
              VALUES ('$userId', '$product_name', '$description', '$price', '$category', '$quantity', 'available')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $product_id = mysqli_insert_id($con);

        $activity_description = "Added a new product: $product_name (ID: $product_id)";
        $activity_log = "INSERT INTO `recent_activities`(`user_id`, `activity_type`, `description`) 
                         VALUES ('$userId', '$activity_type', '$activity_description')";
        mysqli_query($con, $activity_log);

        if (!empty($images['name'][0])) {
            $total_images = count($images['name']);
            $is_first_image = true;

            for ($i = 0; $i < $total_images; $i++) {
                if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) {
                    echo "Error uploading file: " . $_FILES['images']['name'][$i] . " (Error code: " . $_FILES['images']['error'][$i] . ")";
                    exit;
                }

                $file_name = $images['name'][$i];
                $file_tmp = $images['tmp_name'][$i];

                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (in_array($file_ext, $allowed_extensions)) {
                    $image_data = file_get_contents($file_tmp);

                    $image_is_primary = $is_first_image ? 1 : 0;
                    $is_first_image = false;

                    $image_query = "INSERT INTO `product_images`(`product_id`, `image`, `is_primary`) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($con, $image_query);

                    if ($stmt === false) {
                        die('MySQL prepare error: ' . mysqli_error($con));
                    }

                    mysqli_stmt_bind_param($stmt, 'isb', $product_id, $image_data, $image_is_primary);
                    mysqli_stmt_send_long_data($stmt, 1, $image_data);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Invalid file type for file: " . $file_name;
                    exit;
                }
            }
        }

        $_SESSION['status'] = "Product has been listed!";
        $_SESSION['status_code'] = "success";
        header('Location: ../index.php');
        exit(0);
    } else {
        echo "Error: " . mysqli_error($con);
    }
    mysqli_close($con);
}
?>
