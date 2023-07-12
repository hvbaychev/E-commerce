<?php
session_start();
include('connection.php');

//if user is not log in
if (!isset($_SESSION['logged_in'])){
    header('location: ../checkout.php?message=Please login/register to place an order');
    exit;
}


if(isset($_POST['place_order'])){
    
    //1. get user info and store in date
    $name = $_POST['name'];
    // $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "not paid";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                                        VALUES (?,?,?,?,?,?,?);"); // this is for protection from hackers - best practice

    $stmt->bind_param('isiisss',$order_cost,$order_status,$user_id,$phone,$city,$address,$order_date);

    //if stmt for protection
    $stmtStatus = $stmt->execute();

    if(!$stmtStatus){
        header('location: index.php');
        exit;
    }

    //2. issue new order and store order info in date
    $order_id = $stmt->insert_id;

    // if ($stmt->execute()) {
    //     $order_id = $stmt->insert_id;
    //     echo $order_id;
    // } else {
    //     echo "error: " . $stmt->error;
    // } 
    // -->check for errors


    //3. get product from cart(from session)
    // $_SESSION['cart'] // [4=>[], 5=>[]]
    foreach($_SESSION['cart'] as $key => $value){
        
        $product = $_SESSION['cart'][$key]; // []
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_price = $product['product_price'];
        $product_image = $product['product_image'];
        $product_quantity = $product['product_quantity'];  

        //4. store each single item in order_items date
        $stmtOne = $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date)
                                                VALUES (?,?,?,?,?,?,?,?)");
        $stmtOne->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);

        $stmtOne->execute();
    }
    
    //5. remove everything from cart --> if user complete stmt  ... e.c. delay until payment is dba_open
    // unset($_SESSION['cart']);




    //6. inform user when everything is fine
    header('location: ../payment.php?order_status=order placed successfully'); // return level back with ../

}

?>