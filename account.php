<?php
session_start();
include('layouts/header.php');
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_id']);
        header('location: login.php');
        exit;
    }
}

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}
// --------------------------------------------------CHANGE USER PROFILE--------------------------------------------------
// check for update
if (isset($_POST['change-info-btn'])) {
    $name = $_POST['change-name'];
    $city = $_POST['change-city'];
    $address = $_POST['change-address'];
    $phone = $_POST['change-phone'];
    $userId = $_SESSION['user_id'];

    // renew information for data
    $stmtUser = $conn->prepare("UPDATE users SET user_name = ?, phone_number = ? WHERE user_id = ?");
    $stmtUser->bind_param('sii', $name, $phone, $userId);

    $stmtOrder = $conn->prepare("UPDATE orders SET user_phone = ?, user_city = ?, user_address = ? WHERE user_id = ?");
    $stmtOrder->bind_param('issi', $phone, $city, $address, $userId);

    if ($stmtUser->execute() && $stmtOrder->execute()) {
        header('location: account.php?message=Information updated successfully');
        exit;
    } else {
        header('location: account.php?error=Failed to update information');
        exit;
    }
}


// --------------------------------------------------CHANGE PASS--------------------------------------------------


if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // check http if is a POST
    if (isset($_POST['change-pass-btn'])) {  // IF IS pressed btn for change password
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        $userId = $_SESSION['user_id'];  // take user id

        // check the password is same or not
        if ($newPassword === $confirmPassword) {
            // hash password
            $hashedPassword = md5($newPassword);

            // update password in database
            $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
            $stmt->bind_param('si', $hashedPassword, $userId);
            if ($stmt->execute()) {
                header('location: account.php?message=Password changed successfully');
                exit;
            } else {
                header('location: account.php?error=Failed to change password');
                exit;
            }
        } else {
            header('location: account.php?error=Passwords do not match');
            exit;
        }
    }
}
//-----------------------------------------------------GET Orders--------------------------------------------//

if (isset($_SESSION['logged_in'])) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $userId = $_SESSION['user_id'];
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $orders =  $stmt->get_result(); //[]
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

        .orders .order-details-btn{
            color: white;
            background-color: coral;
        }
    </style>
</head>


    <!-- Account -->
    <section class="my-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 text-center mt-3 pt-5">
                    <h3 class="font-weight-bold">Account info</h3>
                    <hr class="mx-auto">
                    <div class="account-info">
                        <p>Name: <span><?php if (isset($_SESSION['user_name'])) {
                                            echo $_SESSION['user_name'];
                                        } ?></span></p>
                        <p>Email: <span><?php if (isset($_SESSION['user_email'])) {
                                            echo $_SESSION['user_email'];
                                        } ?></span></p>
                        <p><a href="#orders" id="order-btn">Your orders</a></p>
                        <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form id="account-form" method="POST" action="account.php">
                        <h3>Change Password</h3>
                        <hr class="mx-auto">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="account-password-confirm" name="confirm-password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Change Password" name="change-pass-btn" class="btn" id="change-pass-btn">
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form id="account-form" method="POST" action="account.php">
                        <h3>Change User Info</h3>
                        <hr class="mx-auto">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="change-name" name="change-name" placeholder="Change Name">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="change-city" name="change-city" placeholder="Change City">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="change-address" name="change-address" placeholder="Change Address">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" id="change-phone" name="change-phone" placeholder="Change Phone">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Change" name="change-info-btn" class="btn" id="change-pass-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- orders -->

    <section id="orders" class="orders container-fluid my-5 py-3">
        <div class="container-fluid mt-2">
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Order Number</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
            </tr>

            <?php while ($row = $orders->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <div class="product info">
                            <!-- <img src="assets/img/featured1.jpg"> -->
                            <div>
                                <p class="mt-3"><?php echo $row['order_id'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span><?php echo $row['order_cost'] ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_status'] ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_date'] ?></span>
                    </td>
                    <td>
                        <form method="POST" action="orderDetails.php">
                            <input type="hidden" name="order_status" value="<?php echo $row['order_status'];?>"/>
                            <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id"/>
                            <input type="submit" class="btn order-details-btn" name="order_details_btn" value="Details"/>
                        </form>
                    </td>

                </tr>

            <?php } ?>
        </table>
    </section>



<?php include('layouts/footer.php'); ?>