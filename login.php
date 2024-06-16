<?php
session_start();
include("classes/connect.php");
include("classes/login.php");

$username = "";
$password = "";
$site = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login = new Login();
    $result = $login->evaluate($_POST);

    if ($result != "") {
        echo $result;
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $site = $_POST['site'];
        $email = $_POST['email'];

        if ($_POST['otp'] == $_SESSION['otp']) {
            header("Location: index.php");
            die;
        } else {
            echo "Invalid OTP. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-form-container">
        <form method="post" id="login-form">
            <h2>Login</h2><br>
            <div class="form-field">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-field">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-field">
                <label for="site">Role:</label>
                <select id="site" name="site" required>
                    <option value="">Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="form-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-field">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
        <div class="register-link">
            <a href="register.php" style="color: black;">Do not have an account? Register</a>
        </div>
        <br>
        <div class="forgot-password">
            <a href="forgot_password.php" style="color: black; text-decoration: none;">Forgot Password?</a>
        </div>
    </div>
    
</body>
</html>
