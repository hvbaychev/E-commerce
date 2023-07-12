<?php
session_start();
include('layouts/header.php');
include('server/connection.php');


if(isset($_POST['search'])){
    // use the search section
    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ?");
    $stmt->bind_param('si',$category, $price);
    $stmt->execute();
    $products =  $stmt->get_result(); //[]

}else{
    //return all products
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products =  $stmt->get_result(); //[]
}
?>
<head>
    <style>
          #search {
            margin-top: 1000px;

        }

        form {
            max-width: 300px;
        }

        .container {
            padding: 0;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .product-item .img-fluid {
            width: 400px;
            height: 400px;
            object-fit: cover;
        }

        .buy-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: coral;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .buy-btn:hover {
            background-color: #ff7f50;
        }
    </style>
</head>


    <section class="row mx-auto container-fluid">

        <div class="col-lg-3 col-md-4 col-sm-12">
            <section id="search" class="my-5 py-5">
                <div class="container-fluid my-5 py-5">
                    <form method="POST" action="shop.php">
                        <div>
                            <div>
                                <p>Search Products</p>
                            </div>
                            <p>Category</p>
                            <div class="form-check">
                                <input class="form-check-input" value="shoes" type="radio" name="category" id="category_one" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Shoes
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" value="coats" type="radio" name="category" id="category_two" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Coats
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" value="watches" type="radio" name="category" id="category_tree" checked>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Watches
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" value="bags" type="radio" name="category" id="category_four" checked>
                                <label class="form-check-label" for="flexRadioDefault4">
                                    Bags
                                </label>
                            </div>

                        </div>

                        <div class="container-fluid mt-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <p>Price</p>
                                <input type="range" class="form-range w-50" name="price" value="100" min="1" max="1000" id="customRange2">
                                <div class="w-50">
                                    <span style="float: left">1</span>
                                    <span style="float: right">1000</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-3 mx-3">
                            <input type="submit" name="search" value="Search" class="btn btn-primary">
                        </div>

                    </form>
                </div>
            </section>
        </div>


        <div class="product text-center col-lg-9 col-md-8 col-sm-12">
            <section id="featured" class="my-5 pd-5">
                <div class="container">
                    <h3>Our Product</h3>
                    <hr class="mx-auto">
                    <p><b>ALL PRODUCTS</b></p>
                </div>


                <section>
                    <div class="row mx-auto">
                        <?php while ($row = $products->fetch_assoc()) { ?>
                            <div class="product-item col-lg-3 col-md-4 col-sm-12">
                                <img class="img-fluid mb-3" src="<?php echo $row['product_image']; ?>">
                                <div class="star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                                <a class="btn buy-btn" href="<?php echo "singleProduct.php?product_id=" . $row['product_id']; ?>">BUY NOW</a>
                            </div>
                        <?php } ?>
                    </div>
                </section>
            </section>
        </div>
    </section>


<?php include('layouts/footer.php');?>