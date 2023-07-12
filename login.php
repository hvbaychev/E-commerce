<?php
session_start();
include('layouts/header.php');


include('server/connection.php');

if(isset($_SESSION['logged_in'])){ //dont have access to login.php if im already logged
    header('location: account.php');
    exit;
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $password);
    if ($stmt->execute()) {
        $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->fetch();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            // $_SESSION['user_password'] = $user_password;
            $_SESSION['logged_in'] = true;

            header('location: account.php?message=logged in successfully');
        }else{
            header('location: login.php?error=could not verify your account!');
        }
        
    } else {
        //error
        header('location: login.php?error=something went wrong!');
    }
}


?>


    <!-- Login -->
    <section class="my-5 py-5">
        <div class="container-fluid text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <p style="color:red" class="text center">
                <?php
                if (isset($_GET['error'])) {
                    echo $_GET['error'];
                }
                ?>
            </p>
            <form id="login-form" method="POST" action="login.php">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login">
                </div>
                <div class="form-group">
                    <a id="register-url" class="btn" href="register.php">Don't have account? Register!</a>
                </div>

            </form>
        </div>
    </section>





<?php include('layouts/footer.php');?>