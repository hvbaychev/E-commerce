<?php


include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products LIMIT 4");  // take only 4 products

$stmt->execute();
$featuredProducts =  $stmt->get_result(); //[]


?>