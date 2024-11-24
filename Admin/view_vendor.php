<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<style>
        body{margin-top:20px;
    background:#f7f8fa
    }

    .avatar-xxl {
        height: 7rem;
        width: 7rem;
    }

    .card {
        margin-bottom: 20px;
        -webkit-box-shadow: 0 2px 3px #eaedf2;
        box-shadow: 0 2px 3px #eaedf2;
    }

    .pb-0 {
        padding-bottom: 0!important;
    }

    .font-size-16 {
        font-size: 16px!important;
    }
    .avatar-title {
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #038edc;
        color: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        font-weight: 500;
        height: 100%;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 100%;
    }

    .bg-soft-primary {
        background-color: rgba(3,142,220,.15)!important;
    }
    .rounded-circle {
        border-radius: 50%!important;
    }

    .nav-tabs-custom .nav-item .nav-link.active {
        color: #038edc;
    }
    .nav-tabs-custom .nav-item .nav-link {
        border: none;
    }
    .nav-tabs-custom .nav-item .nav-link.active {
        color: #038edc;
    }

    .avatar-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 12px;
    }

    .border-end {
        border-right: 1px solid #eff0f2 !important;
    }

    .d-inline-block {
        display: inline-block!important;
    }

    .badge-soft-danger {
        color: #f34e4e;
        background-color: rgba(243,78,78,.1);
    }

    .badge-soft-warning {
        color: #f7cc53;
        background-color: rgba(247,204,83,.1);
    }

    .badge-soft-success {
        color: #51d28c;
        background-color: rgba(81,210,140,.1);
    }

    .avatar-group .avatar-group-item {
        margin-left: -14px;
        border: 2px solid #fff;
        border-radius: 50%;
        -webkit-transition: all .2s;
        transition: all .2s;
    }

    .avatar-sm {
        height: 2rem;
        width: 2rem;
    }

    .nav-tabs-custom .nav-item {
        position: relative;
        color: #343a40;
    }

    .nav-tabs-custom .nav-item .nav-link.active:after {
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .nav-tabs-custom .nav-item .nav-link::after {
        content: "";
        background: #038edc;
        height: 2px;
        position: absolute;
        width: 100%;
        left: 0;
        bottom: -2px;
        -webkit-transition: all 250ms ease 0s;
        transition: all 250ms ease 0s;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    .badge-soft-secondary {
        color: #74788d;
        background-color: rgba(116,120,141,.1);
    }

    .badge-soft-secondary {
        color: #74788d;
    }

    .work-activity {
        position: relative;
        color: #74788d;
        padding-left: 5.5rem
    }

    .work-activity::before {
        content: "";
        position: absolute;
        height: 100%;
        top: 0;
        left: 66px;
        border-left: 1px solid rgba(3,142,220,.25)
    }

    .work-activity .work-item {
        position: relative;
        border-bottom: 2px dashed #eff0f2;
        margin-bottom: 14px
    }

    .work-activity .work-item:last-of-type {
        padding-bottom: 0;
        margin-bottom: 0;
        border: none
    }

    .work-activity .work-item::after,.work-activity .work-item::before {
        position: absolute;
        display: block
    }

    .work-activity .work-item::before {
        content: attr(data-date);
        left: -157px;
        top: -3px;
        text-align: right;
        font-weight: 500;
        color: #74788d;
        font-size: 12px;
        min-width: 120px
    }

    .work-activity .work-item::after {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 50%;
        left: -26px;
        top: 3px;
        background-color: #fff;
        border: 2px solid #038edc
    }
</style>

<?php
 if(isset($_GET['id']))
 {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $users = "SELECT
            users.*,
            COALESCE(
                (SELECT AVG(rating) 
                 FROM ratings 
                 WHERE ratings.user_id = users.user_id), 
                0
            ) AS average_rating,
            GROUP_CONCAT(
                CONCAT(
                    '{\"product_id\": \"', product.product_id, '\",',
                    '\"product_name\": \"', product.name, '\",',
                    '\"product_description\": \"', product.description, '\",',
                    '\"product_category\": \"', product.category, '\",',
                    '\"product_price\": \"', product.price, '\",',
                    '\"product_status\": \"', product.status, '\",',
                    '\"product_created_at\": \"', product.created_at, '\",',
                    '\"product_image\": \"', IFNULL(product_images.image, 'No Image'), '\"}'
                )
            ) AS product_listings
        FROM
            users
        LEFT JOIN
            product ON users.user_id = product.vendor_id
        LEFT JOIN
            product_images ON product_images.product_id = product.product_id
        WHERE
            users.user_id = $id
        GROUP BY
            users.user_id;
    ";
      $users_run = mysqli_query($con, $users);
              ?>
              <?php
              if(mysqli_num_rows($users_run) > 0)
              {
                  foreach($users_run as $user)
                  {
              
            if (!empty($user['profile_image'])) {
                $imageData = base64_encode($user['profile_image']);
                $mimeType = 'image/jpeg';
                $profileImageSrc = 'data:' . $mimeType . ';base64,' . $imageData;
            } else {
                $profileImageSrc = './assets/img/noimage.jpg';
            }
              ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container">
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body pb-0">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="text-center border-end">

                        <img src="<?= $profileImageSrc; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">

                            <h4 class="text-primary font-size-20 mt-3 mb-2"><?= $user['first_name']; ?> <?= $user['last_name']; ?></h4>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="ms-3">
                            <div>
                                <h4 class="card-title mb-2">Contact Information 
                                    <?php
                                    $status = $user['account_status'];
                                    $badgeClass = '';

                                    if ($status === 'Active') {
                                        $badgeClass = 'bg-primary';
                                    } elseif ($status === 'Suspended') {
                                        $badgeClass = 'bg-danger';
                                    } elseif ($status === 'Pending') {
                                        $badgeClass = 'bg-info';
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass; ?>" style="color: white;"><?= $status; ?></span></h4>
                                <p class="mb-0 text-muted">Hi! I am <?= $user['first_name']; ?> <?= $user['last_name']; ?>, a humble and honest vendor here in Oroquieta Marketplace!</p>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div>
                                        <p class="text-muted mb-2 fw-medium"><i class="mdi mdi-email-outline me-2"></i><?= $user['email']; ?>
                                        </p>
                                        <p class="text-muted fw-medium mb-0"><i class="mdi mdi-phone-in-talk-outline me-2"></i><?= $user['phone_number']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                         
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
    <div class="tab-content p-4">
        <div class="tab-pane active show" id="projects-tab" role="tabpanel">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h4 class="card-title mb-4">Listings</h4>
                </div>
            </div>

            <div class="row" id="all-projects">
                <?php
                $products_query = "SELECT 
                    product.*, 
                    product_images.image 
                FROM 
                    product
                LEFT JOIN 
                    product_images ON product.product_id = product_images.product_id
                WHERE 
                    product.vendor_id =  {$user['user_id']}
                GROUP BY 
                    product.product_id;";
                $products_run = mysqli_query($con, $products_query);

                if (mysqli_num_rows($products_run) > 0) {
                    while ($product = mysqli_fetch_assoc($products_run)) {
                        if (!empty($product['image'])) {
                            $imageData = base64_encode($product['image']);
                            $mimeType = 'image/jpeg'; 
                            $productImage = 'data:' . $mimeType . ';base64,' . $imageData;
                        } else {
                            $productImage = './assets/img/noimage.jpg';
                        }
                ?>
                    <div class="col-md-4 mb-4" id="project-items-<?= $product['product_id']; ?>">
                        <div class="card h-100"> 
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex mb-3">
                                    <div class="flex-grow-1 align-items-start">
                                        <h5 class="mb-1 font-size-17"><?= $product['name']; ?></h5>
                                        <p class="text-muted mb-0"><?= $product['description']; ?></p>
                                        <div class="text-center">
                                            <img src="<?= $productImage; ?>" class="img-fluid mt-3" alt="Product Image" style="width: 200px; height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex mt-auto">
                                    <span class="badge badge-soft-info p-2 team-status text-dark" style="margin-left: 10px;"><?= $product['product_condition']; ?></span>
                                    <div class="align-self-end" style="margin-left: 10px;">
                                        <span class="badge p-2 team-status 
                                            <?= $product['status'] === 'Available' ? 'badge-soft-success' : ($product['status'] === 'Sold Out' ? 'badge-soft-danger' : ''); ?>">
                                            <?= ucfirst($product['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="pb-2">
                    <h4 class="card-title mb-3">Ratings</h4>
                    <?php $averageRating = $user['average_rating']; ?>

                        <p>
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $averageRating) {
                                    echo '<i class="bi bi-star-fill text-warning" style="font-size: 30px;"></i>';
                                } else {
                                    echo '<i class="bi bi-star text-muted" style="font-size: 30px;"></i>';
                                }
                            }
                            ?>
                        </p>

                    <!-- end ul -->
                </div>
                <hr>
                <div class="pt-2">
                    <h4 class="card-title">Date Joined</h4>
                    <?php

                    $registrationDate = $user['registration_date'];

                    $dateTime = new DateTime($registrationDate);

                    $formattedDate = $dateTime->format('d/m/Y h:i A');
                    ?>

                    <p><?= $formattedDate; ?></p>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Personal Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td><?= $user['first_name']; ?> <?= $user['last_name']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Location</th>
                                    <td><?= $user['address_street']; ?>, <?= $user['address_baranggay']; ?>, <?= $user['address_city']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Birthday</th>
                                    <td><?= $user['date_of_birth']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>


<?php
                                }
                            }
                            else
                            {
                                ?>
                                <h4>No Record Found!</h4>
                                <?php
                            }
                        }
                        ?>


<?php
include("./includes/footer.php");
?>