<?php
include(__DIR__ . '/../config/config.php');

if (isset($_GET['id'])) {
    $userId = mysqli_real_escape_string($con, $_GET['id']);  // Use $_GET['id'] instead of hardcoding

    // Query to fetch customer details
    $query = "SELECT 
                users.user_id, 
                users.username,
                users.first_name, 
                users.last_name, 
                users.email, 
                users.phone_number, 
                users.address_street, 
                users.address_baranggay, 
                users.address_city, 
                users.date_of_birth, 
                users.account_status,
                users.registration_date
              FROM users 
              WHERE users.user_id = '$userId' LIMIT 1";
    
    $query_run = mysqli_query($con, $query);

    if (!$query_run) {
        // Log the error
        error_log('Query failed: ' . mysqli_error($con));
        echo json_encode(['success' => false, 'message' => 'Error executing the query.']);
        exit();
    }

    // Check if user exists
    if (mysqli_num_rows($query_run) > 0) {
        $customer = mysqli_fetch_assoc($query_run);

        // Return the customer details as a JSON response
        echo json_encode([
            'success' => true,
            'data' => $customer
        ]);
    } else {
        // If no customer found
        echo json_encode(['success' => false, 'message' => 'Customer not found.']);
    }
} else {
    // No 'id' provided in the request
    echo json_encode(['success' => false, 'message' => 'No customer ID provided.']);
}
?>
