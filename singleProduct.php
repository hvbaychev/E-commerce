<?php

session_start();
include('layouts/header.php');
include('server/connection.php');



if (isset($_GET['product_id'])) {
  $productId = $_GET['product_id'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");  // take only 1 products unique for product every time
  $stmt->bind_param("i", $productId);

  $stmt->execute();
  $product =  $stmt->get_result(); //[]



  // $productData = $product->fetch_assoc(); 
  // $userId = $productData['user_id'];
  // $stmtPhone = $conn->prepare("SELECT phone_number FROM users WHERE user_id = ?");
  // $stmtPhone->bind_param("i", $userId);
  // $stmtPhone->execute();
  // $phoneNumber = $stmtPhone->get_result()->fetch_assoc();
  // if ($phoneNumber) {
  // 
  //   $phoneNumber = $phoneNumber['phone_number'];
  // }

  

} else {
  header('location: index.php'); //no product id was given
}

?>


  <!-- single-product -->
  <section class="container single-product my-5 pt-5">
    <div class="row mt-5">

      <?php while ($row = $product->fetch_assoc()) { // logic is here cause i need to take and phone number and need to use only one time fetch_assoc
          $userId = $row['user_id'];                // and can use iserid from product and can take phone number
          $stmtPhone = $conn->prepare("SELECT phone_number FROM users WHERE user_id = ?");
          $stmtPhone->bind_param("i", $userId);
          $stmtPhone->execute();
          $phoneNumberResult = $stmtPhone->get_result();
             if ($phoneNumberResult && $phoneNumber = $phoneNumberResult->fetch_assoc()) {
                $phoneNumber = $phoneNumber['phone_number'];} ?>




        <div class="col-lg-5 col-md-6 col-sm-12">
          <img class="img-fluid w-100 pb-1" src="<?php echo $row['product_image']; ?>" id="mainImg" />
          <div class="small-img-group">
            <div class="small-image-col">
              <img src="<?php echo $row['product_image']; ?>" width="100%" class="small-image">
            </div>
            <div class="small-image-col">
              <img src="<?php echo $row['product_image2']; ?>" width="100%" class="small-image">
            </div>
            <div class="small-image-col">
              <img src="<?php echo $row['product_image3']; ?>" width="100%" class="small-image">
            </div>
            <div class="small-image-col">
              <img src="/<?php echo $row['product_image4']; ?>" width="100%" class="small-image">
            </div>
          </div>
        </div>


        <div class="col-lg-6 col-md-12 col-12">
          <h6><?php echo $row['product_category']; ?></h6>
          <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
          <h2><?php echo $row['product_price']; ?></h2>

          <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
            <input type="number" name="product_quantity" value="1">

            <button class="buy-btn" type="submit" name="add-to-cart">Add to Cart</button>
          </form>

          <h4 class="mt-5 mb-5">Product details:</h4>
          <span><?php echo $row['product_description']; ?></span>
          <h4 class="mt-5 mb-5">Contact seller:</h4>
          <span><?php echo $phoneNumber; ?></span>
        </div>


      <?php } ?>


    </div>
  </section>


  <!-- Related products -->
  <section id="related-products" class="my-5 pd-5">
    <div class="container text-center mt-5 py-5">
      <h3>Related Products</h3>
      <hr class="mx-auto">
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
            <button class="buy-btn">BUY NOW</button>
          </a>

        </div>

      <?php } ?>


    </div>
  </section>


<?php include('layouts/footer.php');?>