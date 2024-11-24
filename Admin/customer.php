<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>Customer</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Customer</li>
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
                                <th>Profile Picture</th>
                                <th><b>N</b>ame</th>
                                <th>Address</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT
                                    users.user_id, 
                                    users.last_name, 
                                    users.first_name, 
                                    users.phone_number, 
                                    users.profile_image, 
                                    users.address_street, 
                                    users.address_baranggay, 
                                    users.address_city, 
                                    users.account_status, 
                                    users.date_of_birth,
                                    users.last_login
                                  FROM users
                                  WHERE users.role = 'buyer'";
                        $query_run = mysqli_query($con, $query);
                        if (!$query_run) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                        ?>
                            <tr>
                                    <td>
                                    <?php
                                    // Check if profile_image is not empty
                                    if (!empty($row['profile_image'])) {
                                    $imageData = base64_encode($row['profile_image']);
                                    $mimeType = 'image/jpeg'; 
                                    $profileImageSrc = 'data:' . $mimeType . ';base64,' . $imageData;
                                    } else {
                                    $profileImageSrc = './assets/img/noimage.jpg'; 
                                    }
                                    ?>
                                    <img src="<?php echo $profileImageSrc; ?>" alt="Profile Image" style="width: 100px; height: 100px;">
                                    </td>
                                <td><?= $row['first_name']; ?> <?= $row['last_name']; ?></td>
                                <td><?= $row['address_street'] . ', ' . $row['address_baranggay'] . ', ' . $row['address_city']; ?></td>
                                <td><?= date("Y-m-d", strtotime($row['last_login'])); ?></td>
                                <td>
                                    <?php
                                    if ($row['account_status'] == 'Active') {
                                        echo '<span class="badge bg-success">Active</span>';
                                    } elseif ($row['account_status'] == 'Suspended') {
                                        echo '<span class="badge bg-warning text-dark">Suspended</span>';
                                    } elseif ($row['account_status'] == 'Pending') {
                                        echo '<span class="badge bg-secondary">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-light">Invalid</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#customerModal" onclick="viewCustomerDetails(<?= $row['user_id']; ?>)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>   
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

<!-- Modal for Viewing Customer Details -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModalLabel">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="customer-details">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->


<?php
include("./includes/footer.php");
?>
