<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

      <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Products</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <?php
                    $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']); 
                                   $listings = "SELECT
                                                  product.*
                                                FROM
                                                  product
                                                WHERE
                                                  product.vendor_id = $userId";
                                   $listings_run = mysqli_query($con, $listings);


                                   if($listings_total = mysqli_num_rows($listings_run))
                                   {
                                       echo '<h6 class="mb-0"> '.$listings_total.' </h6>';
                                   }else
                                   {
                                       echo '<h6 class="mb-0">0</h6>';
                                   }
                      ?>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Customers Card -->
            <div class="col-xxl-6 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Orders</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                                    $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']); 
                                   $listings = "SELECT
                                                  product.vendor_id, 
                                                  cart.*
                                                FROM
                                                  cart
                                                  INNER JOIN
                                                  product
                                                  ON 
                                                    cart.product_id = product.product_id
                                                WHERE
                                                  product.vendor_id = $userId";
                                   $listings_run = mysqli_query($con, $listings);


                                   if($listings_total = mysqli_num_rows($listings_run))
                                   {
                                       echo '<h6 class="mb-0"> '.$listings_total.' </h6>';
                                   }else
                                   {
                                       echo '<h6 class="mb-0">0</h6>';
                                   }
                      ?>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

<?php $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']); ?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <br>
                                      <!-- Button to Open Modal -->
                                      <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createListingModal">
                            Create Listings
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="createListingModal" tabindex="-1" aria-labelledby="createListingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createListingModalLabel">Create a New Listing</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="./controller/add-products.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="productName" class="form-label">Product Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="productName" name="product_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description <small>(Put N/A if none)</small></label>
                                            <textarea class="form-control" id="description" name="description" rows="9" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price <span style="color: red;">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₱</span>
                                                <input type="number" class="form-control" id="price" name="price" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category <span style="color: red;">*</span></label>
                                            <select class="form-select" id="category" name="category" required>
                                                <option value="">Select Category</option>
                                                <?php
                                                $categoryQuery = "SELECT id, name FROM categories";
                                                $categories = mysqli_query($con, $categoryQuery);
                                                while ($category = mysqli_fetch_assoc($categories)) {
                                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Product Images <small>(Optional)</small></label>
                                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" name="addproduct" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            product_images.image AS image, 
                            categories.`name` AS categoryName
                            FROM
                            product
                            LEFT JOIN
                            product_images
                            ON 
                            product.product_id = product_images.product_id AND product_images.is_primary = 1
                            INNER JOIN
                            categories
                            ON 
                            product.category = categories.id
                            WHERE
                            product.vendor_id = $userId
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
                                <!-- Wrap each cell with a link to the details page -->
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
                                <td>
                                    <?php
                                    $description = $row['description'];
                                    $words = explode(' ', $description);
                                    $words = array_slice($words, 0, 50);
                                    $truncatedDescription = implode(' ', $words);

                                    if (count($words) < count(explode(' ', $description))) {
                                        $truncatedDescription .= '...';
                                    }

                                    echo $truncatedDescription;
                                    ?>
                                </td>
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
                            <td class="text-center">
                                <!-- Edit Dropdown -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- Edit Details Option -->
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item edit-product" 
                                            data-id="<?= $row['product_id']; ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editDetailsModal">
                                            Details
                                            </a>
                                        </li>
                                        <!-- Edit Image Option -->
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item edit-image" 
                                            data-id="<?= $row['product_id']; ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editImageModal">
                                            Image
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Delete Button -->
                                <a href="javascript:void(0);" 
                                class="btn btn-danger btn-sm delete-product" 
                                data-id="<?= $row['product_id']; ?>" 
                                data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteConfirmationModal">
                                    Delete
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

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

<?php
include("./includes/footer.php");
?>