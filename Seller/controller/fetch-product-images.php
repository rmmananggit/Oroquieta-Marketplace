<?php
session_start();
include(__DIR__ . '/../config/config.php');

if (isset($_GET['product_id'])) {
    $productId = mysqli_real_escape_string($con, $_GET['product_id']);
    $query = "SELECT image_id, image, is_primary FROM product_images WHERE product_id = $productId";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $isPrimary = $row['is_primary'] ? 'Primary' : 'Set as Primary';
            $badgeClass = $row['is_primary'] ? 'badge-success' : 'badge-secondary';
            echo '
                <div class="col-md-4 mb-3 text-center">
                    <img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="img-thumbnail" style="max-width: 100%; height: auto;">
                    <div class="mt-2">
                        <button class="btn btn-sm btn-danger delete-image" data-id="' . $row['image_id'] . '">Delete</button>
                        <button class="btn btn-sm btn-primary set-primary" data-id="' . $row['image_id'] . '">' . $isPrimary . '</button>
                    </div>
                    <span class="badge ' . $badgeClass . '">' . ($row['is_primary'] ? 'Primary' : '') . '</span>
                </div>';
        }
    } else {
        echo '<p>No images found for this product.</p>';
    }
} else {
    echo '<p>Invalid product ID.</p>';
}
?>
