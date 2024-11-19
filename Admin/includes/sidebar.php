<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <?php
  // Get the name of the current file
  $current_page = basename($_SERVER['PHP_SELF']);
  ?>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'index.php') ? '' : 'collapsed'; ?>" href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-heading">Manage</li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'vendor.php') ? '' : 'collapsed'; ?>" href="vendor.php">
    <i class="bi bi-shop-window"></i>
      <span>Vendors</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'customer.php') ? '' : 'collapsed'; ?>" href="customer.php">
    <i class="bi bi-person-check"></i>
      <span>Customers</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'faculty.php') ? '' : 'collapsed'; ?>" href="faculty.php">
    <i class="bi bi-box-seam"></i>
      <span>Products</span>
    </a>
  </li>


  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'categories.php') ? '' : 'collapsed'; ?>" href="categories.php">
    <i class="bi bi-cart-dash"></i>
      <span>Categories</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'staff.php') ? '' : 'collapsed'; ?>" href="staff.php">
    <i class="bi bi-broadcast-pin"></i>
      <span>Orders</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">
