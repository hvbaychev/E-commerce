<?php
session_start();
include('layouts/header.php');
include('server/connection.php');

// check if user is already login
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

// check for send form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-product-btn'])) {

    $productName = $_POST['product_name'];
    $productCategory = $_POST['product_category'];
    $productPrice = $_POST['product_price'];
    $productDescription = $_POST['product_description'];
    $productImage = $_FILES['product_image']['name'];
    $productImageTmp = $_FILES['product_image']['tmp_name'];
    $productImagePath = 'upload/' . $productImage;

    move_uploaded_file($productImageTmp, $productImagePath);

    // Get the user_id from the session
    $userId = $_SESSION['user_id'];


    $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_price, product_description, product_image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdssi', $productName, $productCategory, $productPrice, $productDescription, $productImagePath, $userId);
    if ($stmt->execute()) {
        header('location: products.php?message=Product added successfully');
        exit;
    } else {
        header('location: addProduct.php?error=Failed to add product');
        exit;
    }
}
?>

<head>
<style>
        .col-lg-6 {
            margin: 20px auto;
            margin-top: 200px;
        }

        #add-product-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        #add-product-form h3 {
            margin-bottom: 20px;
            text-align: center;
        }

        #add-product-form .form-group {
            margin-bottom: 20px;
        }

        #add-product-form label {
            font-weight: bold;
        }

        #add-product-form .btn {
            background-color: orange;
            color: #fff;
        }
    </style>
</head>





    <!-- addproducts -->
    <div class="col-lg-6 col-md-12 col-sm-12">
        <form id="add-product-form" method="POST" action="addProduct.php" enctype="multipart/form-data">
            <h3>Add Product</h3>
            <div class="form-group">
                <a href="products.php" class="btn btn-primary">View Products</a>
            </div>
            <hr class="mx-auto">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" required>
            </div>
            <div class="form-group">
                <label for="product_category">Product Category</label>
                <input type="text" class="form-control" id="product_category" name="product_category" placeholder="Enter Product Category" required>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price</label>
                <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price" required>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description" placeholder="Enter Product Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" class="form-control" id="product_image" name="product_image" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Product" class="btn" name="add-product-btn" id="add-product-btn">
            </div>
            <div class="form-group">
                <button class="btn btn-secondary" onclick="goBack()">Back</button>
            </div>
        </form>
    </div>








    <script>
        function goBack() {
            history.back();
        }
    </script>

<?php include('layouts/footer.php');?>