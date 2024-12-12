<?php
include("./includes1/authentication.php");
include("./includes1/header.php");
include("./includes1/topbar.php");
include("./includes1/sidebar.php");
?>

<div class="pagetitle">
    <h1>Orders</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Orders</li>
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
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                         $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
                        $query = "SELECT
                                        cart.id, 
                                        cart.user_id, 
                                        cart.product_id, 
                                        cart.quantity, 
                                        cart.status,
                                        cart.dateCreated,
                                        product.product_id, 
                                        product.vendor_id, 
                                        product.`name` as productName, 
                                        product.description, 
                                        product.price, 
                                        product.category, 
                                        product.product_condition, 
                                        product.order_type,
                                        product_images.image
                                    FROM
                                        cart
                                        INNER JOIN
                                        product
                                        ON 
                                            cart.product_id = product.product_id
                                        LEFT JOIN 
                                        product_images 
                                        ON product.product_id = product_images.product_id
                                    WHERE
                                        cart.user_id = $userId
                                    ORDER BY
                                        cart.dateCreated DESC
                                    ";
                        $query_run = mysqli_query($con, $query);
                        if (!$query_run) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                                // Check if status is 'Complete'
                                $isComplete = ($row['status'] == 'Completed') ? true : false;
                                
                                // Convert the image from LONG BLOB to base64
                                $imageData = base64_encode($row['image']);
                                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                        ?>
                            <tr>
                            <td>
                                <a href="product_details.php?product_id=<?= $row['product_id']; ?>" class="text-primary">
                                    <?= $row['productName']; ?>
                                </a>
                            </td>
                                <td><?= $row['description']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 'Completed') {
                                        echo '<span class="badge bg-success">Completed</span>';
                                    } elseif ($row['status'] == 'Suspended') {
                                        echo '<span class="badge bg-warning text-dark">Suspended</span>';
                                    } elseif ($row['status'] == 'Pending') {
                                        echo '<span class="badge bg-secondary">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-light">Invalid</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= date("Y-m-d h:i A", strtotime($row['dateCreated'])); ?></td>
                                <td>
                                    <?php if (!$isComplete) { ?>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editOrderModal" 
                                        data-id="<?= $row['id']; ?>" 
                                        data-product-name="<?= $row['productName']; ?>"
                                        data-description="<?= $row['description']; ?>"
                                        data-quantity="<?= $row['quantity']; ?>"
                                        data-price="<?= $row['price']; ?>"
                                        data-status="<?= $row['status']; ?>"
                                        data-image="<?= $imageSrc; ?>"
                                        >Edit</button>

                                        <!-- Delete Button -->
                                        <form action="./controller/delete-order.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="orderId" value="<?= $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    <?php } else { ?>
                                        <span></span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="6">No Record Found</td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./controller/update-order.php" method="POST">
                    <input type="hidden" id="orderId" name="id">
                    <div class="mb-3 text-center">
                        <img id="productImage" src="" alt="Product Image" style="max-width: 50%; height: 50%"/>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Available Stock</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" readonly>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>

<script>
    // Script to populate modal with data when "Edit" button is clicked
    var editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Get data attributes
            var productId = button.getAttribute('data-id');
            var productName = button.getAttribute('data-product-name');
            var description = button.getAttribute('data-description');
            var quantity = button.getAttribute('data-quantity');
            var price = button.getAttribute('data-price');
            var status = button.getAttribute('data-status');
            var imageSrc = button.getAttribute('data-image');
            
            // Set values in modal
            document.getElementById('orderId').value = productId;
            document.getElementById('productName').value = productName;
            document.getElementById('description').value = description;
            document.getElementById('quantity').value = quantity;
            document.getElementById('price').value = price;
            document.getElementById('productImage').src = imageSrc;
        });
    });
</script>
