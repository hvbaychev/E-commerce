<?php
session_start();
include('layouts/header.php')
?>

    <!-- Home -->
    <section id="home">
        <div class="container-fluid">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices</span>This Season</h1>
            <p>E-shop offers the best products for the most affordable prices</p>
            <button>Shop Now</button>
        </div>
    </section>

    <!-- Brand -->
    <section id="brand">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/img/Adidas_logo.png">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/img/Nike-Logo.png">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/img/puma-logo.jpg">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/img/under-armour.jpg">
            </div>
        </div>
    </section>


    <section id="new" class="w-100">
        <div class="row p-0 m-0">
            <!-- One -->
            <div class="col-lg-4 col-md-12 col-sm-12 p-0">
                <div class="image-container">
                    <img class="img-fluid" src="assets/img/shoes.jpg">
                    <div class="details">
                        <h2>Extremely Awesome Shoes</h2>
                        <button class="text-uppercase">Shop Now</button>
                    </div>
                </div>
            </div>
            <!-- Two -->
            <div class="col-lg-4 col-md-12 col-sm-12 p-0">
                <div class="image-container">
                    <img class="img-fluid" src="assets/img/jacket.jpg">
                    <div class="details">
                        <h2>Awesome Jacket</h2>
                        <button class="text-uppercase">Shop Now</button>
                    </div>
                </div>
            </div>
            <!-- Three -->
            <div class="col-lg-4 col-md-12 col-sm-12 p-0">
                <div class="image-container">
                    <img class="img-fluid" src="assets/img/50sale.jpg">
                    <div class="details">
                        <h2>50% OFF</h2>
                        <button class="text-uppercase">Shop Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured -->
    <section id="featured" class="my-5 pd-5">
        <div class="container-fluid text-center mt-5 py-5">
            <h3>Our Featured</h3>
            <hr class="mx-auto">
            <p>Here you can check out our featured products</p>
        </div>
        <div class="row mx-auto container-fluid">


            <?php include('server/getFeaturedProducts.php'); ?>

            <?php while ($row = $featuredProducts->fetch_assoc()) {  //return next row from result fetch_assoc
            ?>

                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="<?php echo $row['product_image']; //return the image 
                                                                ?>">
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; //return the name of product 
                                        ?></h5>
                    <h4 class="p-price">$<?php echo $row['product_price']; // return the price of product 
                                            ?></h4>
                    <a href="<?php echo 'singleProduct.php?product_id=' . $row['product_id']; ?>">
                        <button class="check-btn">BUY NOW</button>
                    </a>

                </div>

            <?php } ?>


        </div>
    </section>

    <!-- banner -->

    <section id="banner" class="my-5 py-5">
        <div class="container-fluid">
            <h4>MID SEASON'S SALE</h4>
            <h1>Autumn Collection <br> UP to 30% OFF</h1>
            <button class="text-uppercase">shop now</button>
        </div>
    </section>

    <!-- Clothes -->


    <section id="clothes" class="my-5">
        <div class="container-fluid text-center mt-5 py-5">
            <h3>Dresses & Coats</h3>
            <hr class="mx-auto">
            <p>Here you can check out our amazing clothes</p>
        </div>
        <div class="row mx-auto container-fluid">

            <?php include('server/getCoats.php'); ?>

            <?php while ($row = $coatProducts->fetch_assoc()) { ?>

                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="<?php echo $row['product_image']; ?>">
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    <h4 class="p-price">$<?php echo $row['product_price']; ?></h4>
                    <a href="<?php echo 'singleProduct.php?product_id=' . $row['product_id']; ?>">
                        <button class="buy-btn">BUY NOW</button>
                    </a>
                </div>


            <?php } ?>

        </div>
    </section>

<?php include('layouts/footer.php');?>