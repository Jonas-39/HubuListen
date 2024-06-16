<?php 
session_start(); // Start the session

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("php/config.php");

if(isset($_POST['signup'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    // Verifying the unique email
    $verify_query = mysqli_query($conn,"SELECT Email FROM users WHERE Email='$email'");
    $check = mysqli_num_rows($verify_query); // Corrected the variable name

    // Function to generate OTP
    function generateOTP($length = 6) {
        $characters = '0123456789';
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $otp;
    }

    // Generate OTP
    $otp = generateOTP();
    $verified = 0;

    if ($check > 0) {
        echo "<script>alert('EMAIL ALREADY EXISTS')</script>";
    } else {
        mysqli_query($conn,"INSERT INTO users(Username,Email,Age,Password,otp,verified) VALUES('$username','$email','$age','$password','$otp','$verified')") or die(mysqli_error($con));

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lj_budlao@outlook.com'; // Update with your SMTP username
            $mail->Password = 'luckyjame2023'; // Update with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('lj_budlao@outlook.com', 'Hub U listen');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Registration';
            $mail->Body = 'Hello ' . $username . ', your OTP for email verification is: ' . $otp;

            $mail->send();

            // Store OTP and user email in session
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            echo "<script>alert('Successfully Created')</script>";
            // Redirect to OTP verification page
            header('Location: otp.php');
            exit();
        } catch (Exception $e) {
            // Log error for debugging
            error_log("Error sending email: " . $e->getMessage(), 0);
            echo "Message could not be sent. Please try again later.";
        }
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
    <title>Register</title>
    <!-- 
    - favicon link
  -->
  <link rel="shortcut icon" href="./assets/images/lgo.png" type="image/svg+xml">
  <style>
    
        body {
            background-image: url('./assets/images/hubhub.png'); 
            background-size: auto;
            background-position: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="box form-box">
        <header>Sign Up</header>
        <form action="" method="post"> <!-- Ensure form submits to the same file -->
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" autocomplete="off" required>
            </div>
            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="signup" value="Register" required>
            </div>
            <div class="links">
                Already a member? <a href="index.php">Sign In</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
