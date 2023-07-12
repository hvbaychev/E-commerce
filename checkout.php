 <?php
    session_start();
    include('layouts/header.php');

    if (!empty($_SESSION['cart'])) {
        //let user in
    } else {
        //send user to home
        header('location: index.php');
    }

    ?>


 <head>
     <style>
         /* need to check why is not load from style.css */

         #checkout-form {
             text-align: center;

         }

         #checkout-form .form-group {
             margin-bottom: 20px;
         }

         #checkout-form label {
             display: block;
             font-weight: bold;
         }

         #checkout-form input[type="text"],
         #checkout-form input[type="tel"] {
             width: 100%;
             padding: 8px;
             border-radius: 4px;
             border: 1px solid #ccc;
         }

         #checkout-form .checkout-small-element {
             display: inline-block;
             width: 48%;
             margin: 10px auto;
             text-align: center;
         }

         #checkout-form .checkout-large-element {
             width: 100%;
         }

         #checkout-form .checkout-btn-container {
             margin: 10px;
             text-align: center;
             margin-right: 40px;
         }

         #checkout-form #checkout-btn {
             color: #fff;
             background-color: #fb774b;
             border: none;
             padding: 10px 20px;
             border-radius: 4px;
             cursor: pointer;
         }

         #checkout-form #checkout-btn:hover {
             background-color: black;
         }
     </style>
 </head>



 <!-- Checkout -->
 <section class="my-5 py-5">
     <div class="container-fluid text-center mt-3 pt-5">
         <h2 class="form-weight-bold">Check out</h2>
         <hr class="mx-auto">
     </div>
     <div class="mx-auto container">

     <p class="text-center" style="color:red">
                 <?php if (isset($_GET['message'])) {
                        echo $_GET['message'];
                    } ?>
             </p>
             <?php if (isset($_GET['message'])) { ?>
                 <a class="btn btn-primary" style="margin-left: 600px;"  href="login.php">Login</a>
             <?php } ?>    

         <form method="POST" action="server/placeOrder.php" id="checkout-form">
             <div class="form-group checkout-small-element">
                 <label>Name</label>
                 <input type="text" class="form-control" id="checkout-name" name="name" placeholder="name" required>
             </div>
             <div class="form-group checkout-small-element">
                 <label>Email</label>
                 <input type="text" class="form-control" id="checkout-email" name="Email" placeholder="Email" required>
             </div>
             <div class="form-group checkout-small-element">
                 <label>Phone Number</label>
                 <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
             </div>
             <div class="form-group checkout-small-element">
                 <label>City</label>
                 <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
             </div>
             <div class="form-group checkout-large-element">
                 <label>Address</label>
                 <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
             </div>
             <div class="form-group checkout-btn-container">
                 <p>Total amount:$<?php echo $_SESSION['total']; ?></php>
                 </p>
                 <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
             </div>
         </form>
     </div>
 </section>




 <?php include('layouts/footer.php'); ?>