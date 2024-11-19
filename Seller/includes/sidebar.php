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

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'products.php') ? '' : 'collapsed'; ?>" href="products.php">
    <i class="bi bi-bag-plus"></i>
      <span>Products</span>
    </a>
  </li>

  <li class="nav-heading">Manage</li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'orders.php') ? '' : 'collapsed'; ?>" href="orders.php">
    <i class="bi bi-cart2"></i>
      <span>Orders</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">
