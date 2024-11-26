<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>My Listings</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Current Listings</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


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
                                <th>Image</th>
                                <th>Name</th>
                                <th style="width: 400px;">Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                      $query = "SELECT
                                    product.product_id, 
                                    product.`name`, 
                                    product.description, 
                                    product.price, 
                                    product.category, 
                                    product.quantity, 
                                    product.`status`, 
                                    MIN(CASE WHEN product_images.is_primary = 1 THEN product_images.image ELSE NULL END) AS image, 
                                    categories.`name` AS categoryName
                                FROM
                                    product
                                LEFT JOIN
                                    product_images
                                ON 
                                    product.product_id = product_images.product_id
                                INNER JOIN
                                    categories
                                ON 
                                    product.category = categories.id
                                GROUP BY
                                    product.product_id";     
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

                                <td>
                                        <img src="<?= $profileImageSrc; ?>" alt="Product Image" style="width: 100px; height: 100px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" 
                                    class="view-details-link" 
                                    data-id="<?= $row['product_id']; ?>" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewDetailsModal">
                                    <?= $row['name']; ?>
                                    </a>
                                </td>
                                <td><?= $row['description']; ?></a></td>
                                <td><?= number_format($row['price'], 2, '.', ','); ?></td>
                                <td><?= $row['categoryName']; ?></a></td>
                                <td><?= $row['quantity']; ?></a></td>
                                <td>
                                        <?php
                                        if ($row['status'] == 'Available') {
                                            echo '<span class="badge bg-success">Available</span>';
                                        } elseif ($row['status'] == 'Sold Out') {
                                            echo '<span class="badge bg-warning text-dark">Sold Out</span>';
                                        } elseif ($row['status'] == 'Disabled') {
                                            echo '<span class="badge bg-secondary">Disabled</span>';
                                        } else {
                                            echo '<span class="badge bg-light">Invalid</span>';
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" 
                                    class="btn btn-primary btn-sm view-product-details" 
                                    data-id="<?= $row['product_id']; ?>" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewDetailsModal">
                                        <i class="bi bi-eye"></i>
                                    </a>
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


<?php
include("./includes/footer.php");
?>
