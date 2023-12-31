<?php
session_start();

include("php/config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
    $result = mysqli_query($con, $query) or die("Select Error: " . mysqli_error($con));
    $row = mysqli_fetch_assoc($result);
    if(is_array($row) && !empty($row) && isset($_POST['remember_me']) && $_POST['remember_me'] == 'on'){
        if ($row['Email'] != null) {
            setcookie('username',$row['Email'],time()+60*60*24*30);
            setcookie('password',$row['Password'],time()+60*60*24*30);
        }

    }else{
        if (is_array($row) && !empty($row)) {
            setcookie('username',$row['Username'],30);
            setcookie('password',$row['Password'],30);
        }

    }

    if (is_array($row) && !empty($row)) {   
        $_SESSION['valid'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['age'] = $row['Age'];
        $_SESSION['id'] = $row['Id'];

        if ($row['Email'] == "sohaibbouktiba2004@gmail.com") {
            header("Location: admin/admin.php");
        } else {
            header("Location: home/home.php");
        }
        exit(); // Exit after setting the header location
    } else {
        $error_message = "Wrong Username or Password";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login</title>
    <style>
        body{
            background-image: url(home/images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-transform: none;
        }
        .form-box form .btn{
            padding-bottom:33px;
        }
        .form-box form .links{
            margin-top:22px;
        }
        #remember_me {
            accent-color: #d3ad7f; /* Set the background color for the checked state */
        }

        
    </style>
</head>
<body>
<div class="container">
    
    <?php

    $username_cookie='';
    $password_cookie='';
    $set_remember="";

    if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
        $username_cookie=$_COOKIE['username'];
        $password_cookie=$_COOKIE['password'];
        $set_remember="checked='checked'";	
    }

    ?>
    <div class="box form-box">
        <header ><i class="fas fa-user fa-sm"></i> Login</header>
        <form action="" method="post">
            <div class="field input">
                <label for="email" style="font-size: 20px;text-transform: none;">Email</label>
                <input type="text" name="email" id="email" value="<?php echo $username_cookie?>" style="text-transform: none;" required>
            </div>

            <div class="field input">
                <label for="password" style="font-size: 20px;">Password</label>
                <input type="password" name="password" id="password" style="text-transform: none;" value="<?php echo $password_cookie?>" autocomplete="off" required>
            </div>
            <div style="font-size:18px">
                <input type="checkbox" name="remember_me" id="remember_me" style="background-color: #C38154;" <?php echo $set_remember?>>
                <label for="remember_me" >  Remember Me</label>
            </div>

            <div class="field">
                <input type="submit" style="font-weight: 300;font-size:20px" class="btn" name="submit" value="Login">
            </div>
            <div class="links" style="font-size: 18px;">
                Don't have an account? <a href="register.php" style="color:#C38154">Sign Up Now</a>
            </div>
        </form>
        <?php if (isset($error_message)) : ?>
            <div class="message" style="font-size: 16px;">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
