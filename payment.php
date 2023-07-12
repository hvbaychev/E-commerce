<?php

session_start();
include('layouts/header.php');
include('connection.php');

if(isset($_POST['order_pay_btn'])) {
    $orderStatus = $_POST['order_status'];
    $orderTotalPrice = $_POST['order_total_price'];
}


?>





<!-- Payment -->
<section class="my-5 py-5">
    <div class="container-fluid text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">

    <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0) {?> 
        <p>Total payment: $ <?php echo $_SESSION['total'];?></p>
        <input type="submit" class="btn btn-primary" value="Pay Now"/>
    <?php }elseif(isset($_POST['order_status']) && $_POST['order_status'] == 'not paid') { ?>
        <p>Total Payment: $<?php echo $_POST['order_total_price']; ?></p>
        <input type="submit" class="btn btn-primary" value="Pay Now"/>
    <?php }else{ ?>
        <p>You don`t have an order</p>
        <?php }?>
        
 

    </div>
</section>




<?php include('layouts/footer.php'); ?>
