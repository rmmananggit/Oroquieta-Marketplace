<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "marketplace");

// Get the filter parameter from the URL
$filter = $_GET['filter'];

// Adjust the query based on the filter
switch ($filter) {
    case 'today':
        $query = "SELECT categories.name AS category_name, COUNT(*) AS product_count
                  FROM categories
                  LEFT JOIN product ON categories.id = product.category
                  GROUP BY categories.name";
        break;
    case 'month':
        // Implement logic to filter data for the current month
        $query = "SELECT ...";
        break;
    case 'year':
        // Implement logic to filter data for the current year
        $query = "SELECT ...";
        break;
    default:
        // Default query for all data
        $query = "SELECT categories.name AS category_name, COUNT(*) AS product_count
                  FROM categories
                  LEFT JOIN product ON categories.id = product.category
                  GROUP BY categories.name";
}

// Execute the query and return the results as JSON
// ... (same as before)