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
                                    <a href="javascript:void(0);" onclick="openEditModal(<?= $row['id']; ?>)" class="btn btn-warning btn-sm">Edit</a>
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

<!-- Modal for Editing Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST">
                    <input type="hidden" name="id" id="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" required></textarea>
                    </div>
                    <div class="modal-footer text-end">
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
