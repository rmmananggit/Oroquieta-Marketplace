<?php
include(__DIR__ . '/../config/config.php');

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Query to fetch the category details
    $query = "SELECT id, name, description FROM categories WHERE id = '$categoryId' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $category = mysqli_fetch_assoc($query_run);

        // Return the category details as a JSON response
        echo json_encode([
            'success' => true,
            'data' => $category
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    // No 'id' provided in the request
    echo json_encode(['success' => false]);
}
?>
