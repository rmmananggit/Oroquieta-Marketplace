<?php
include(__DIR__ . '/../config/config.php');

if (isset($_GET['id'])) {
    $productId = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch product details
    $query = "SELECT 
                product.product_id, 
                product.name, 
                product.description, 
                product.price, 
                product.quantity, 
                product.status, 
                categories.name AS categoryName
              FROM product
              INNER JOIN categories ON product.category = categories.id
              WHERE product.product_id = $productId";

    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Fetch all images for the product
        $imagesQuery = "SELECT image FROM product_images WHERE product_id = $productId";
        $imagesResult = mysqli_query($con, $imagesQuery);

        // Collect images into an array
        $images = [];
        while ($imageRow = mysqli_fetch_assoc($imagesResult)) {
            $images[] = $imageRow['image'];
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($images)) { ?>
                <div id="carouselProductImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $image) { ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                <img src="data:image/jpeg;base64,<?= base64_encode($image); ?>" class="d-block w-100" alt="Product Image">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductImages" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProductImages" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <?php } else { ?>
                    <p class="text-center">No images available.</p>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <h4><?= htmlspecialchars($product['name']); ?></h4>
                <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Price:</strong> ₱<?= number_format($product['price'], 2); ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($product['categoryName']); ?></p>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($product['quantity']); ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($product['status']); ?></p>
            </div>
        </div>

        <?php
    } else {
        echo "<p class='text-danger'>Product not found.</p>";
    }
} else {
    echo "<p class='text-danger'>Invalid request.</p>";
}
?>