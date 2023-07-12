<?php


include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category = 'coats' LIMIT 4");


$stmt->execute();
$coatProducts =  $stmt->get_result(); //[]

?>