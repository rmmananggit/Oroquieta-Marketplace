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
                                <th><b>N</b>ame</th>
                                <th>Description</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT
                                    categories.id, 
                                    categories.name, 
                                    categories.description, 
                                    categories.created_at
                                  FROM categories";
                        $query_run = mysqli_query($con, $query);

                        if (!$query_run) {
                            die("Query failed: " . mysqli_error($con));
                        }

                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                        ?>
                            <tr>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <td><?= date("Y-m-d", strtotime($row['created_at'])); ?></td>
                                <td class="text-center">
                                    <a href="edit_category.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_category.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
