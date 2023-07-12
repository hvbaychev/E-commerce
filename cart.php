<?php
session_start();
include('layouts/header.php');



if(isset($_POST['add-to-cart'])){   //check if user click on <button class="buy-btn" type="submit" name="add-to-cart">Add to Cart</button> in singleProduct.php row 111
    //if user already added product to cart
    if(isset($_SESSION['cart'])){

        
        $productsArrayIds = array_column($_SESSION['cart'], "product_id"); // return array product id [2,3,4,10,15]
        //if product has already been added to cart or not
        if(!in_array($_POST['product_id'], $productsArrayIds)){
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];

            $productArray = array(
                'product_id' =>  $_POST['product_id'],
                'product_image' => $_POST['product_image'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_quantity' => $_POST['product_quantity'],
            );
            $_SESSION['cart'][$product_id] = $productArray;

        //product already been added
        }else{
            echo '<script>alert("Product was already added to cart!")</script>';
        }

        //if this is the first product session from scratch
    }else{

        $product_id =  $_POST['product_id'];
        $product_image =  $_POST['product_image'];
        $product_name =  $_POST['product_name'];
        $product_price =  $_POST['product_price'];
        $product_quantity =  $_POST['product_quantity'];

        $productArray = array(
            'product_id' =>  $product_id,
            'product_image' => $product_image,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_quantity' => $product_quantity
        );
        $_SESSION['cart'][$product_id] = $productArray;
        // session store array , but is needed unique ID and i take from product_id [ 2 => [], 3 => [], 5 => []];
        // session array had session array
    }

    // //calculate token_get_all
    // calculateTotalCart();

}// remove product from the card
elseif(isset($_POST['remove_product'])){
    $product_id = $_POST['product_id'];
    foreach($_SESSION['cart'] as $key => $product){ //take session foreach and check id and if id is same unset session like a key
        if($product['product_id'] === $product_id){
            unset($_SESSION['cart'][$key]);
        }
    }
    //unset($_SESSION['cart'][$product_id]);
}
elseif(isset($_POST['edit_quantity'])){
    //get ID and quantity from the form
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    // get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];
    // update product quantity
    $product_array['product_quantity'] = $product_quantity;
    // return array back its place
    $_SESSION['cart'][$product_id] = $product_array;
}

function calculateTotalCart(){
    $total = 0;
    foreach($_SESSION['cart'] as $key => $value){
        $product = $_SESSION['cart'][$key];
        $price =  $product['product_price'];
        $quantity = $product['product_quantity'];
        $total += $price * $quantity;

    }
    $_SESSION['total'] = $total;
    return $total;
    
}

?>

    <!-- cart -->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach($_SESSION['cart'] as $key => $value) { ?>

            <tr>
                <td>
                    <div class="product-info">
                        <img src="<?php echo $value['product_image'];?>">
                        <div>
                            <p><?php echo $value['product_name']; ?></p>
                            <small><span>$</span><?php echo $value['product_price'];?></small>
                            <br>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>">
                                <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                            </form>
                        </div>
                    </div>
                </td>

                <td>
                         <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                        <input type="number" name="product_quantity" value="<?php echo $value['product_quantity'];?>" />
                        <input type="submit" class ="edit-btn" value="edit" name="edit_quantity"/>
                    </form>
                    
                </td>
                <td>
                    <span>$</span>
                    <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price'];?></span>  <?php // calculate the total price of single product ?>
                </td>
            </tr>
            <?php } ?>
        </table>

        

        <div class="cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>$<?php echo calculateTotalCart(); // call directly function for calculate?></td>
                </tr>
            </table>
        </div>

        <div class="checkout-container">
            <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout"></input>
            </form>
        </div>

    </section>


<?php include('layouts/footer.php');?>



  