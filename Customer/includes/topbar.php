<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/ustp-logo.png" alt="">
         <span class="d-none d-lg-block">UCHEQUE</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon -->

      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

          <?php
          if (isset($_SESSION['auth_user'])) {
            $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
            $query = "SELECT profile_image FROM users WHERE user_id = '$userId'";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
              if (mysqli_num_rows($query_run) > 0) {
                $row = mysqli_fetch_assoc($query_run);
                $profilePicture = $row['profile_image'];
                
                if (!empty($profilePicture)) {
                  echo '<img class="rounded-circle" 
                  src="data:image/jpeg;base64,' . base64_encode($profilePicture) . '" 
                  alt="Profile Picture" style="object-fit: cover; width: 100%; height: auto;">';
                } else {
                  // Fallback profile image
                }
              } else {
              }
            } else {
              // Query error handling
              echo "Query failed: " . mysqli_error($con);
            }
          }
          ?>

          <span class="d-none d-md-block dropdown-toggle ps-2"><?= htmlspecialchars($_SESSION['auth_user']['fullName']); ?></span>
        </a><!-- End Profile Image Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arorw profile">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="profile.php">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
