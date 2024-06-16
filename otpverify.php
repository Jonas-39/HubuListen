<?php
session_start(); // Start the session
include('php/config.php'); // Include your database connection file

if (isset($_POST['OTP'])) {
    $enteredOTP = $_POST['OTP'];
    $email = $_SESSION['email']; // Get the email from the session

    // Check if the entered OTP matches the one in the database
    $query = $conn->query("SELECT * FROM users WHERE email='$email' AND otp='$enteredOTP'") or die(mysqli_error($conn));
    $num_rows = $query->num_rows;

    if ($num_rows > 0) {
        // OTP is correct, update the user's verified status
        $conn->query("UPDATE users SET verified=1 WHERE email='$email'") or die(mysqli_error($conn));
        echo "<script>alert('Your email has been successfully verified.');</script>";
        // Redirect to home page or login page
        header('Location: home.php');
        exit();
    } else {
        // OTP is incorrect
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
        // Optionally, redirect back to the OTP verification page
        header('Location: otp.php');
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
