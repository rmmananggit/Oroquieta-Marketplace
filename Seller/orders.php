<?php
// Include necessary files
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>My Orders</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">My Order</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<?php $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']); ?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <br>
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Buyer</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query = "SELECT
    c.*, 
    c.id AS cart_id, 
    c.status AS cartStatus, 
    c.quantity AS cartQuantity,
    p.*, 
    p.vendor_id, 
    u.first_name, 
    u.middle_name, 
    u.last_name
FROM
    cart AS c
INNER JOIN
    product AS p
ON 
    c.product_id = p.product_id
INNER JOIN
    users AS u
ON 
    p.vendor_id = u.user_id
WHERE
    u.user_id = $userId
ORDER BY
    c.dateCreated DESC
";
                        $query_run = mysqli_query($con, $query);
                        if (!$query_run) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                                // Prepare image
                                $profileImageSrc = !empty($row['image']) 
                                    ? 'data:image/jpeg;base64,' . base64_encode($row['image']) 
                                    : './assets/img/noimage.jpg';
                        ?>
                            <tr>
                            <td><?= $row['first_name']; ?> <?= $row['middle_name']; ?> <?= $row['last_name']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['cartQuantity']; ?></td>
                                <td><?= number_format($row['price'], 2, '.', ','); ?></td>
                                <td>
                                    <?php
                                    if ($row['cartStatus'] == 'Completed') {
                                        echo '<span class="badge bg-success">Completed</span>';
                                    } elseif ($row['cartStatus'] == 'Cancelled') {
                                        echo '<span class="badge bg-warning text-dark">Cancelled</span>';
                                    } elseif ($row['cartStatus'] == 'Pending') {
                                        echo '<span class="badge bg-secondary">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-light">Invalid</span>';
                                    }
                                    ?>
                                </td>
                              
                           <td>
    <div class="btn-group">
    <button type="button"
        class="btn btn-primary btn-sm mark-as-sold"
        data-cart-id="<?= $row['cart_id']; ?>"
        data-product-id="<?= $row['product_id']; ?>"
        data-quantity="<?= $row['cartQuantity']; ?>">
    Mark as Sold
</button>
    </div>
</td>

                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8">No Record Found</td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Viewing Product Details -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productDetailsContent">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteProductName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST" action="./controller/delete-product.php">
                    <input type="hidden" name="product_id" id="deleteProductId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImageModalLabel">Manage Product Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productImageContent" class="row">
                    <div class="col-md-3 text-center">
                        <img src="path/to/image.jpg" alt="Product Image" class="img-thumbnail">
                        <button type="button" class="btn btn-primary">Set as Primary</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                    <!-- Add more images and buttons dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Details Modal -->
<div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDetailsModalLabel">Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./controller/update-product.php" method="POST">
                    <input type="hidden" name="product_id" id="editProductId">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select class="form-select" id="editCategory" name="category" required>
                            <option value="">Select Category</option>
                            <?php
                            // Populate categories dynamically from the database
                            $categoryQuery = "SELECT id, name FROM categories";
                            $categories = mysqli_query($con, $categoryQuery);
                            while ($category = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$category['id']}'>{$category['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                    </div>
                    <!-- Save Changes button aligned to the right -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
include("./includes/footer.php");
?>
