<?php
session_start();
include('layouts/header.php');
include('server/connection.php');



if(isset($_SESSION['logged_in'])){  // if user has already register, then take user to account page
    header('location: account.php');
    exit;
}


if (isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if($password !== $confirmPassword){
        header('location: register.php?error=password don`t match');
    }
    elseif(strlen($password) < 6){
        header('location: register.php?error=password must be at least 6 characters');
    //if is not error
    }else{
        //check where there is a user with this email or not
        $stmtOne = $conn->prepare("SELECT user_email FROM users WHERE user_email = ?");
        $stmtOne->bind_param('s', $email);
        $stmtOne->execute();
        $stmtOne->bind_result($num_rows);
        $stmtOne->store_result();
        $stmtOne->fetch();
        
        //if there is a user already register with this email, cannot continue
        // $num_rows = $stmtOne->num_rows;
        if($num_rows != 0){
            header('location: register.php?error=user with this email already exist!');
        // if no user register with this email before
        }else{
        //create a new user
        $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password)
                        VALUES (?,?,?)");
        
        $stmt->bind_param('sss',$name,$email,md5($password)); // md5 hash password
          
        //if acc was created successfully
        if($stmt->execute()){
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;
            header('location: account.php?register=You register successfully!');
        //account cannot be created
        }else{
            header('location: register.php?error=could not create an account at the moment!');
        }
        }
    }
}
?>

  
  <!-- Register -->
  <section class="my-5 py-5">
    <div class="container-fluid text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if(isset($_GET['error'])) echo $_GET['error'];?></p>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirm-password" placeholder="Confirm-Password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="register-btn" name="register" value="Register">
            </div>
            <div class="form-group">
                <a id="login-url" class="btn" href="login.php">Do you have an account? Login</a>
            </div>

        </form>
    </div>
  </section>
  

  
<?php include('layouts/footer.php'); ?>