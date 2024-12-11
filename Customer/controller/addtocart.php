<?php
session_start();
include(__DIR__ . '/../config/config.php');

if (!isset($_SESSION['auth_user']['userId'])) {
    echo "not_logged_in";
    exit;
}

$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];
$quantity = $_POST['quantity'];

// Get the current product quantity from the database
$sql_product = "SELECT quantity FROM product WHERE product_id = ?";
$stmt_product = $con->prepare($sql_product);
$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$product_result = $stmt_product->get_result();
$product = $product_result->fetch_assoc();

if ($quantity <= 0) {
    echo "invalid_quantity";
    exit;
}

// Check if the requested quantity exceeds available stock
if ($quantity > $product['quantity']) {
    $_SESSION['status'] = "The requested quantity exceeds the available stock.";
    $_SESSION['status_code'] = "error";
    header("Location: ../product_details.php?product_id=" . $product_id);  // Redirect back to the product details page
    exit();
}

$sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $con->prepare($sql_check);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt_update->execute();
    $_SESSION['status'] = "Product quantity updated in cart.";
    $_SESSION['status_code'] = "success";
    header("Location: ../index.php");
    exit();
} else {
    $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_insert = $con->prepare($sql_insert);
    $stmt_insert->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt_insert->execute();
    $_SESSION['status'] = "Add to cart successfully.";
    $_SESSION['status_code'] = "success";
    header("Location: ../index.php");
    exit();
}
?>
