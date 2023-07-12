<?php
session_start();
include('layouts/header.php');
include('server/connection.php');


if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}


$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM products JOIN users ON products.user_id = users.user_id WHERE users.user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

//------------------------------------------DELETE PRODUCT-----------------------------//

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = $_POST['id'];

    // check if user add the items
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $productId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // delete the product
        $deleteStmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $deleteStmt->bind_param("i", $productId);
        if ($deleteStmt->execute()) {
            // return in the same page
            header("Location: products.php");
            exit;
        } else {
            echo "Failed to delete product";
        }
    } else {
        echo "Unauthorized access";
    }
} else {
    echo "Invalid request";
}

?>

<head>       
    <style>
        .table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            margin-top: 200px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table td.actions {
            display: flex;
            justify-content: space-around;
        }

        .table td.actions a {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
        }

        .table td.actions .btn-primary {
            background-color: #007bff;
        }

        .table td.actions .btn-danger {
            background-color: #dc3545;
        }

        .alert {
            margin-top: 20px;
            padding: 12px;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>




    <div class="col-lg-12">
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
        } elseif (isset($_GET['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_GET['message'] . '</div>';
        }
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Product Price</th>
                    <th>Product Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_category']; ?></td>
                        <td><?php echo $row['product_price']; ?></td>
                        <td><?php echo $row['product_description']; ?></td>
                        <td>
                            <a href="editProduct.php?id=<?php echo $row['product_id']; ?>" class="btn btn-primary">Edit</a>
                            <form method="POST" action="products.php" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['product_id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-left: 1290px;">
    <a href="addProduct.php" class="btn btn-primary">Add Products</a>
    </div>





<?php include('layouts/footer.php'); ?>