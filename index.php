<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Marketplace</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .price {
      font-weight: bold;
      color: #28a745;
    }
    .price {
      font-weight: bold;
      color: #28a745;
    }

    .card-img-top {
      height: 150px;
      object-fit: cover;
    }

    .card-body {
      padding: 0.75rem;
    }

    .card {
      font-size: 0.9rem;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Oroquieta Marketplace</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#products">Products</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="./Login/index.php">Login</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section accent-background">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1>Your One-Stop Shop: Discover, Buy, and Sell with Ease!</h1>
            <p>A marketplace is an online platform that connects buyers and sellers, enabling the exchange of goods, services, or digital products.</p>
            <div class="d-flex">
              <a href="#products" class="btn-get-started">Products</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products section">
      <div class="container">
        <div class="section-title">
          <h2>All Products</h2>
          <p>Browse through a wide variety of products available on our marketplace.</p>
        </div>
        <div class="row gy-4">
          <?php
          // Database connection
          $conn = new mysqli("localhost", "root", "", "marketplace");

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Query to fetch products
          $sql = "SELECT
                      product.product_id, 
                      product.name, 
                      product.price, 
                      product.description, 
                      product_images.image
                  FROM
                      product
                  INNER JOIN
                      product_images
                  ON 
                      product.product_id = product_images.product_id
                  WHERE
                      product_images.is_primary = 1";

          $result = $conn->query($sql);

          // Generate product cards
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $imageData = base64_encode($row['image']);
                  $src = "data:image/jpeg;base64," . $imageData;
                  echo "<div class='col-lg-3 col-md-4 col-sm-6'>";
                  echo "  <div class='card h-100'>";
                  echo "    <img src='$src' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>";
                  echo "    <div class='card-body'>";
                  echo "      <h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                  echo "      <p class='card-text'>" . htmlspecialchars($row['description']) . "</p>";
                  echo "      <div class='d-flex justify-content-between align-items-center'>";
                  echo "        <span class='price'>$" . number_format($row['price'], 2) . "</span>";
                  echo "        <a href='#' class='btn btn-primary btn-sm'>View Details</a>";
                  echo "      </div>";
                  echo "    </div>";
                  echo "  </div>";
                  echo "</div>";
              }
          } else {
              echo "<p>No products available.</p>";
          }

          $conn->close();
          ?>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer accent-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Oroquieta Marketplace</span>
          </a>
          <p>A marketplace is an online platform that connects buyers and sellers, enabling the exchange of goods, services, or digital products. It streamlines transactions, offering convenience, variety, and secure payment options, all in one place.</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p>A108 Adam Street</p>
          <p>New York, NY 535022</p>
          <p>United States</p>
          <p class="mt-4"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
          <p><strong>Email:</strong> <span>info@example.com</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Techie</strong> <span>All Rights Reserved | Integrated by Oroquieta Marketplace Developer</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>