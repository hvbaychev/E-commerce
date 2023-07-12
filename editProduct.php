<?php

session_start();
include('layouts/header.php');
include('server/connection.php');


if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-product-btn'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productCategory = $_POST['product_category'];
    $productPrice = $_POST['product_price'];
    $productDescription = $_POST['product_description'];
    if (isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0) {
        $productImage = $_FILES['product_image']['name'];
        $productImageTmp = $_FILES['product_image']['tmp_name'];
        $productImagePath = 'upload/' . $productImage;
    }
    $stmtPic = $conn->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $stmtPic->bind_param("i", $productId);
    $stmtPic->execute();
    $result = $stmtPic->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldImageName = $row['product_image'];
    }

    $oldImagePath = $oldImageName;
    if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
    }
    move_uploaded_file($productImageTmp, $productImagePath);
    $updateImageStmt = $conn->prepare("UPDATE products SET product_image = ? WHERE product_id = ?");
    $updateImageStmt->bind_param("si", $productImagePath, $productId);
    $updateImageStmt->execute();

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $productId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $updateStmt = $conn->prepare("UPDATE products SET product_name = ?, product_category = ?, product_price = ?, product_description = ? WHERE product_id = ?");
        $updateStmt->bind_param("ssdsi", $productName, $productCategory, $productPrice, $productDescription, $productId);
        if ($updateStmt->execute()) {
            header('location: products.php?message=Product updated successfully');
            exit;
        } else {
            header('location: editProduct.php?id=' . $productId . '&error=Failed to update product');
            exit;
        }
    } else {
        header('location: products.php?error=Unauthorized access');
        exit;
    }
} else {

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];


        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {

            header('location: products.php?error=Product not found');
            exit;
        }
    } else {

        header('location: products.php');
        exit;
    }
}


?>

<head>
    <style>
        #edit-product-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 200px auto;
            max-width: 1000px;
        }

        #edit-product-form h3 {
            margin-bottom: 20px;
            text-align: center;
        }

        #edit-product-form .form-group {
            margin-bottom: 20px;
        }

        #edit-product-form label {
            font-weight: bold;
        }

        #edit-product-form .btn {
            background-color: orange;
            color: #fff;
        }
    </style>
</head>


    <div class="container">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="edit-product-form" method="POST" action="editProduct.php" enctype="multipart/form-data">
                <h3>Edit Product</h3>
                <div class="form-group">
                    <a href="products.php" class="btn btn-primary">View Products</a>
                </div>
                <hr class="mx-auto">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" value="<?php echo $product['product_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="product_category">Product Category</label>
                    <input type="text" class="form-control" id="product_category" name="product_category" placeholder="Enter Product Category" value="<?php echo $product['product_category']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price" value="<?php echo $product['product_price']; ?>" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" placeholder="Enter Product Description" required><?php echo $product['product_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" class="form-control" id="product_image" name="product_image">
                </div>
                <div class="form-group">
                    <input type="submit" value="Update Product" class="btn" name="update-product-btn" id="update-product-btn">
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary" onclick="goBack()">Back</button>
                </div>
            </form>
        </div>
    </div>


    
    <script>
        function goBack() {
            history.back();
        }
    </script>

<?php include('layouts/footer.php');?>