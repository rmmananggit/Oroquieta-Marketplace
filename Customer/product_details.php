<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
?>
<style type="text/css">
                body{
                    margin-top:20px;
                    background:#eee;
                }


                .product-content {
                    border: 1px solid #dfe5e9;
                    margin-bottom: 20px;
                    margin-top: 12px;
                    background: #fff
                }

                .product-content .carousel-control.left {
                    margin-left: 0
                }

                .product-content .product-image {
                    background-color: #fff;
                    display: block;
                    min-height: 238px;
                    overflow: hidden;
                    position: relative
                }

                .product-content .product-deatil {
                    border-bottom: 1px solid #dfe5e9;
                    padding-bottom: 17px;
                    padding-left: 16px;
                    padding-top: 16px;
                    position: relative;
                    background: #fff
                }

                .product-content .product-deatil h5 a {
                    color: #2f383d;
                    font-size: 15px;
                    line-height: 19px;
                    text-decoration: none;
                    padding-left: 0;
                    margin-left: 0
                }

                .product-content .product-deatil h5 a span {
                    color: #9aa7af;
                    display: block;
                    font-size: 13px
                }

                .product-content .product-deatil span.tag1 {
                    border-radius: 50%;
                    color: #fff;
                    font-size: 15px;
                    height: 50px;
                    padding: 13px 0;
                    position: absolute;
                    right: 10px;
                    text-align: center;
                    top: 10px;
                    width: 50px
                }

                .product-content .product-deatil span.sale {
                    background-color: #21c2f8
                }

                .product-content .product-deatil span.discount {
                    background-color: #71e134
                }

                .product-content .product-deatil span.hot {
                    background-color: #fa9442
                }

                .product-content .description {
                    font-size: 12.5px;
                    line-height: 20px;
                    padding: 10px 14px 16px 19px;
                    background: #fff
                }

                .product-content .product-info {
                    padding: 11px 19px 10px 20px
                }

                .product-content .product-info a.add-to-cart {
                    color: #2f383d;
                    font-size: 13px;
                    padding-left: 16px
                }

                .product-content name.a {
                    padding: 5px 10px;
                    margin-left: 16px
                }

                .product-info.smart-form .btn {
                    padding: 6px 12px;
                    margin-left: 12px;
                    margin-top: -10px
                }

                .product-entry .product-deatil {
                    border-bottom: 1px solid #dfe5e9;
                    padding-bottom: 17px;
                    padding-left: 16px;
                    padding-top: 16px;
                    position: relative
                }

                .product-entry .product-deatil h5 a {
                    color: #2f383d;
                    font-size: 15px;
                    line-height: 19px;
                    text-decoration: none
                }

                .product-entry .product-deatil h5 a span {
                    color: #9aa7af;
                    display: block;
                    font-size: 13px
                }

                .load-more-btn {
                    background-color: #21c2f8;
                    border-bottom: 2px solid #037ca5;
                    border-radius: 2px;
                    border-top: 2px solid #0cf;
                    margin-top: 20px;
                    padding: 9px 0;
                    width: 100%
                }

                .product-block .product-deatil p.price-container span,
                .product-content .product-deatil p.price-container span,
                .product-entry .product-deatil p.price-container span,
                .shipping table tbody tr td p.price-container span,
                .shopping-items table tbody tr td p.price-container span {
                    color: #21c2f8;
                    font-family: Lato, sans-serif;
                    font-size: 24px;
                    line-height: 20px
                }

                .product-info.smart-form .rating label {
                    margin-top: 0
                }

                .product-wrap .product-image span.tag2 {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    padding: 10px 0;
                    color: #fff;
                    font-size: 11px;
                    text-align: center
                }

                .product-wrap .product-image span.sale {
                    background-color: #57889c
                }

                .product-wrap .product-image span.hot {
                    background-color: #a90329
                }

                .shop-btn {
                    position: relative
                }

                .shop-btn>span {
                    background: #a90329;
                    display: inline-block;
                    font-size: 10px;
                    box-shadow: inset 1px 1px 0 rgba(0, 0, 0, .1), inset 0 -1px 0 rgba(0, 0, 0, .07);
                    font-weight: 700;
                    border-radius: 50%;
                    padding: 2px 4px 3px!important;
                    text-align: center;
                    line-height: normal;
                    width: 19px;
                    top: -7px;
                    left: -7px
                }

                .description-tabs {
                    padding: 30px 0 5px!important
                }

                .description-tabs .tab-content {
                    padding: 10px 0
                }

                .product-deatil {
                    padding: 30px 30px 50px
                }

                .product-deatil hr+.description-tabs {
                    padding: 0 0 5px!important
                }

                .product-deatil .carousel-control.left,
                .product-deatil .carousel-control.right {
                    background: none!important
                }

                .product-deatil .glyphicon {
                    color: #3276b1
                }

                .product-deatil .product-image {
                    border-right: none!important
                }

                .product-deatil .name {
                    margin-top: 0;
                    margin-bottom: 0
                }

                .product-deatil .name small {
                    display: block
                }

                .product-deatil .name a {
                    margin-left: 0
                }

                .product-deatil .price-container {
                    font-size: 24px;
                    margin: 0;
                    font-weight: 300
                }

                .product-deatil .price-container small {
                    font-size: 12px
                }

                .product-deatil .fa-2x {
                    font-size: 16px!important
                }

                .product-deatil .fa-2x>h5 {
                    font-size: 12px;
                    margin: 0
                }

                .product-deatil .fa-2x+a,
                .product-deatil .fa-2x+a+a {
                    font-size: 13px
                }

                .profile-message ul {
                list-style: none ;  
                }

                .product-deatil .certified {
                    margin-top: 10px
                }

                .product-deatil .certified ul {
                    padding-left: 0
                }

                .product-deatil .certified ul li:not(first-child) {
                    margin-left: -3px
                }

                .product-deatil .certified ul li {
                    display: inline-block;
                    background-color: #f9f9f9;
                    border: 1px solid #ccc;
                    padding: 13px 19px
                }

                .product-deatil .certified ul li:first-child {
                    border-right: none
                }

                .product-deatil .certified ul li a {
                    text-align: left;
                    font-size: 12px;
                    color: #6d7a83;
                    line-height: 16px;
                    text-decoration: none
                }

                .product-deatil .certified ul li a span {
                    display: block;
                    color: #21c2f8;
                    font-size: 13px;
                    font-weight: 700;
                    text-align: center
                }

                .product-deatil .message-text {
                    width: calc(100% - 70px)
                }

                @media only screen and (min-width:1024px) {
                    .product-content div[class*=col-md-4] {
                        padding-right: 0
                    }
                    .product-content div[class*=col-md-8] {
                        padding: 0 13px 0 0
                    }
                    .product-wrap div[class*=col-md-5] {
                        padding-right: 0
                    }
                    .product-wrap div[class*=col-md-7] {
                        padding: 0 13px 0 0
                    }
                    .product-content .product-image {
                        border-right: 1px solid #dfe5e9
                    }
                    .product-content .product-info {
                        position: relative
                    }
                }

                .message img.online {
                    width:40px;
                    height:40px;
                }
</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />

<?php
$product_id = $_GET['product_id']; 
$query = "
    SELECT
        product_images.image, 
        product.product_id, 
        product.vendor_id, 
        product.name, 
        product.description, 
        product.price, 
        product.category, 
        product.quantity, 
        product.product_condition, 
        product.order_type, 
        product.status, 
        users.first_name, 
        users.middle_name, 
        users.last_name
    FROM
        product
    INNER JOIN
        product_images ON product.product_id = product_images.product_id
    INNER JOIN
        users ON product.vendor_id = users.user_id
    WHERE
        product.product_id = $product_id
";

// Execute the query
$result = mysqli_query($con, $query);

// Fetch the product data
$product = mysqli_fetch_assoc($result);

// Fetch all product images related to this product_id
$product_images_query = "
    SELECT image FROM product_images WHERE product_id = $product_id
";
$product_images_result = mysqli_query($con, $product_images_query);

?>

<div class="container">
    <!-- Product -->
    <div class="product-content product-wrap clearfix product-deatil">
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="product-image">
                    <div id="myCarousel-2" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            $index = 0;
                            while ($image_row = mysqli_fetch_assoc($product_images_result)) {
                                $activeClass = ($index == 0) ? 'active' : '';
                                echo '<li data-target="#myCarousel-2" data-slide-to="' . $index . '" class="' . $activeClass . '"></li>';
                                $index++;
                            }
                            ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php
                            mysqli_data_seek($product_images_result, 0);  // Reset result pointer
                            $index = 0;
                            while ($image_row = mysqli_fetch_assoc($product_images_result)) {
                                // Convert BLOB to base64
                                $image_data = base64_encode($image_row['image']);
                                $image_src = 'data:image/jpeg;base64,' . $image_data;

                                // Set the first image as active
                                $active_class = ($index == 0) ? 'active' : '';
                                echo "<div class='carousel-item $active_class'>";
                                echo "<img src='$image_src' class='d-block w-100' alt='Product Image $index'>";
                                echo "</div>";
                                $index++;
                            }
                            ?>
                        </div>

                        <!-- Controls -->
                        <a class="carousel-control-prev" href="#myCarousel-2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#myCarousel-2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-md-offset-1 col-sm-12 col-xs-12">
                <h2 class="name">
                    <?php echo $product['name']; ?>
                    <small>Product by <a href="javascript:void(0);"><?php echo $product['first_name'] . ' ' . $product['middle_name'] . ' ' . $product['last_name']; ?></a></small>
                    <i class="fa fa-star fa-2x text-primary"></i>
                    <i class="fa fa-star fa-2x text-primary"></i>
                    <i class="fa fa-star fa-2x text-primary"></i>
                    <i class="fa fa-star fa-2x text-primary"></i>
                    <i class="fa fa-star fa-2x text-muted"></i>
                    <span class="fa fa-2x"><h5>(109) Votes</h5></span>
                    <a href="javascript:void(0);">109 customer reviews</a>
                </h2>
                <hr />
                <h3 class="price-container">
                ₱<?php echo $product['price']; ?>
                    <small>*includes tax</small>
                </h3>
                <div class="certified">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">Order Type<span><?php echo $product['order_type'] ?></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Availability<span><?php echo $product['status'] ?></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Stock<span><?php echo $product['quantity'] ?></span></a>
                        </li>
                    </ul>
                </div>
                <hr />
                <div class="description">
                    <strong>Product Description:</strong>
                    <p>
                        <?php echo $product['description']; ?>
                    </p>
                </div>
                <hr />
                <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <!-- Add to cart form -->
        <form action="./controller/addtocart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['auth_user']['userId']) ? $_SESSION['auth_user']['userId'] : ''; ?>">

            <!-- Quantity input -->
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
            </div>

            <!-- Add to cart button -->
            <button type="submit" class="btn btn-success btn-lg">Add to cart</button>
        </form>
    </div>
</div>
            </div>
        </div>
    </div>
    <!-- End Product -->
</div>

<?php
include("./includes/footer.php");
?>