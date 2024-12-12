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
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Listings <span>| Posted</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                                   
                                   $listings = "SELECT
                                                  product.*
                                                FROM
                                                  product";
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

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Vendor <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                                   
                                   $vendor = "SELECT
                                                      users.*
                                                    FROM
                                                      users
                                                    WHERE
                                                      users.role = 'seller'";
                                   $vendor_run = mysqli_query($con, $vendor);


                                   if($vendor_total = mysqli_num_rows($vendor_run))
                                   {
                                       echo '<h6 class="mb-0"> '.$vendor_total.' </h6>';
                                   }else
                                   {
                                       echo '<h6 class="mb-0">0</h6>';
                                   }
                      ?>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Customers <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                                   
                                   $customer = "SELECT
                                                      users.*
                                                    FROM
                                                      users
                                                    WHERE
                                                      users.role = 'buyer'";
                                   $customer_run = mysqli_query($con, $customer);


                                   if($customer_total = mysqli_num_rows($customer_run))
                                   {
                                       echo '<h6 class="mb-0"> '.$customer_total.' </h6>';
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

            <!-- Recent Orders -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Recent Orders <span>| Today</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                      <th>Buyer</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT
                                        cart.*,
                                        cart.status as cartStatus, 
                                        product.*, 
                                        product.vendor_id, 
                                        users.first_name, 
                                        users.middle_name, 
                                        users.last_name
                                    FROM
                                        cart
                                        INNER JOIN
                                        product
                                        ON 
                                            cart.product_id = product.product_id
                                        INNER JOIN
                                        users
                                        ON 
                                            product.vendor_id = users.user_id
                                    WHERE
                                        users.user_id
                                    ORDER BY
                                        cart.dateCreated DESC";
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
                                <td><?= $row['quantity']; ?></td>
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

                </div>

              </div>
            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
              
        <div class="card">
                  <div class="card-body">
                <h5 class="card-title">Recent Activity <span>| Today</span></h5>
                <div class="activity">
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    include("../Admin/config/config.php");

                    // Fetch the latest 4 recent activities
                    $query = "SELECT ra.activity_type, ra.description, ra.created_at, u.first_name, u.last_name
                              FROM recent_activities ra
                              INNER JOIN users u ON ra.user_id = u.user_id
                              ORDER BY ra.created_at DESC
                              LIMIT 4";
                    $query_run = mysqli_query($con, $query);

                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        while ($activity = mysqli_fetch_assoc($query_run)) {
                            // Calculate time elapsed
                            $created_at = new DateTime($activity['created_at']);
                            $now = new DateTime();
                            $elapsed = $created_at->diff($now);
                            
                            if ($elapsed->d > 0) {
                                $time_label = $elapsed->d . " day" . ($elapsed->d > 1 ? "s" : "");
                            } elseif ($elapsed->h > 0) {
                                $time_label = $elapsed->h . " hr" . ($elapsed->h > 1 ? "s" : "");
                            } elseif ($elapsed->i > 0) {
                                $time_label = $elapsed->i . " min";
                            } else {
                                $time_label = "Just now";
                            }

                            // Dynamic badge colors based on activity type
                            $badge_color = match ($activity['activity_type']) {
                                "New Listing" => "text-success",
                                "Updated Listing" => "text-primary",
                                "Deleted Listing" => "text-danger",
                                default => "text-muted",
                            };
                    ?>
                            <div class="activity-item d-flex">
                                <div class="activite-label"><?= $time_label; ?></div>
                                <i class="bi bi-circle-fill activity-badge <?= $badge_color; ?> align-self-start"></i>
                                <div class="activity-content">
                                    <?= htmlspecialchars($activity['activity_type']); ?>: 
                                    <a href="#" class="fw-bold text-dark"><?= htmlspecialchars($activity['description']); ?></a>
                                    by <?= htmlspecialchars($activity['first_name']) . ' ' . htmlspecialchars($activity['last_name']); ?>
                                </div>
                            </div><!-- End activity item -->
                    <?php
                        }
                    } else {
                        echo "<p>No recent activities found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>


        </div><!-- End Right side columns -->

      </div>
    </section>

<?php
include("./includes/footer.php");
?>