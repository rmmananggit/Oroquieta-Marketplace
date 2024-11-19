<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>Vendor</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Vendor</li>
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
                                <th>Birthday</th>
                                <th>Status</th>
                                <th>Rating</th>
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
                                    users.ratings
                                  FROM users
                                  WHERE users.role = 'seller'";
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
                                <td><?= date("Y-m-d", strtotime($row['date_of_birth'])); ?></td>
                                <td>
                                    <?php
                                    if ($row['account_status'] == 'active') {
                                        echo '<span class="badge bg-success">Active</span>';
                                    } elseif ($row['account_status'] == 'suspended') {
                                        echo '<span class="badge bg-warning text-dark">Suspended</span>';
                                    } elseif ($row['account_status'] == 'pending') {
                                        echo '<span class="badge bg-secondary">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-light">Invalid</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (empty($row['ratings'])) {
                                        echo 'N/A';
                                    } else {
                                        echo $row['ratings'];
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit_vendor.php?id=<?= $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_vendor.php?id=<?= $row['user_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("./includes/footer.php");
?>
