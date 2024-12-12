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
                                        product.product_id, 
                                        product.vendor_id, 
                                        product.`name` as productName, 
                                        product.description, 
                                        product.price, 
                                        product.category, 
                                        product.quantity, 
                                        product.product_condition, 
                                        product.order_type
                                    FROM
                                        cart
                                        INNER JOIN
                                        product
                                        ON 
                                            cart.product_id = product.product_id
                                    WHERE
                                        cart.user_id = $userId
                                    ORDER BY
                                        cart.dateCreated
                                    ";
                        $query_run = mysqli_query($con, $query);
                        if (!$query_run) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                        ?>
                            <tr>
                                <td><?= $row['productName']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td><?= $row['status']; ?></td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="7">No Record Found</td>
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


<?php
include("./includes/footer.php");
?>