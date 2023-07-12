<?php

/*
status of order:
not paid
shipped
delivered
*/

session_start();
include('layouts/header.php');
include('server/connection.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])){
    $orderId = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param('i', $orderId);

    $stmt->execute();

    $orderDetails = $stmt->get_result();

    $orderTotalPrice = calculateTotalOrderPrice($orderDetails);

    
}else{
    header('location: account.php');
}


//calculate the total price, take $orderDetails from top
function calculateTotalOrderPrice($orderDetails){
    $total = 0;

    foreach($orderDetails as $row){
        $productPrice = $row['product_price'];
        $productQuantity = $row['product_quantity'];

        $total += $productPrice * $productQuantity;
    }
    return $total;
}

?>


<head>
    <style>
    .orders-heading {
        background-color: darkorange;
        color: white;
    }

    table {
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        width: 70%;
    }

    th,
    td {
        text-align: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: coral;
        color: #333;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: white;
    }

    .orders .order-details-btn {
        color: white;
        background-color: coral;
    }

    .product img {
        max-width: 70px;
        max-height: 70px;
    }
    </style>
</head>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container">
            <img src="assets/img/logo.png">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <?php
                    if (isset($_SESSION['logged_in'])) {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="addProduct.php">Add Product</a>
                              </li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact us</a>
                    </li>
                    <li>
                        <div class="icon-container">
                            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                            <a href="account.php"><i class="fas fa-user"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<!-- order details -->
    <section id="orders" class="orders container-fluid my-5 py-3">
        <div class="container-fluid mt-5">
            <h2 class="font-weight-bold text-center">Order Details</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5 mx-auto" >
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>

            <?php foreach($orderDetails as $row) { ?>
                <tr>
                    <td>
                        <div class="product info">
                            <img src="<?php echo $row['product_image']; ?>">
                            <div>
                                <p class="mt-3"><?php echo $row['product_name']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span>$<?php echo $row['product_price']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['product_quantity']; ?></span>
                    </td>
                </tr>
            <?php } ?>
            
        </table>
    </section>


    <?php 
    if($order_status == "not paid"){ ?>
        <form style="margin-left: 1500px;" method="POST" action="payment.php">
          <input type="hidden" name="order_total_price" value="<?php echo $orderTotalPrice; ?>">
          <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
          <input type="submit" name="order_pay_button" class="btn btn-primary" value="Pay Now">
        </form>

    <?php } ?>



<?php include('layouts/footer.php');?>