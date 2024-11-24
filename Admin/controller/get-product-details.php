<?php
include(__DIR__ . '/../config/config.php');

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Fetch product details
    $productQuery = "SELECT 
                        product.product_id, 
                        product.name, 
                        product.description, 
                        product.price, 
                        product.quantity, 
                        categories.name AS categoryName 
                     FROM 
                        product 
                     INNER JOIN 
                        categories 
                     ON 
                        product.category = categories.id 
                     WHERE 
                        product.product_id = $productId 
                     LIMIT 1";
    
    $productResult = mysqli_query($con, $productQuery);

    // Fetch images
    $imagesQuery = "SELECT image FROM product_images WHERE product_id = $productId";
    $imagesResult = mysqli_query($con, $imagesQuery);

    if ($productResult && mysqli_num_rows($productResult) > 0) {
        $product = mysqli_fetch_assoc($productResult);

        // Fetch images
        $images = [];
        if ($imagesResult) {
            while ($imgRow = mysqli_fetch_assoc($imagesResult)) {
                $images[] = 'data:image/jpeg;base64,' . base64_encode($imgRow['image']);
            }
        }

        // Respond with product details and images
        echo json_encode([
            "success" => true,
            "product" => $product,
            "images" => $images,
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Product not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
