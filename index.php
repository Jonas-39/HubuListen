<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login</title>
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
            <?php 
             
              include("php/config.php");
              if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($conn,$_POST['email']);
                $password = mysqli_real_escape_string($conn,$_POST['password']);

                $result = mysqli_query($conn,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['age'] = $row['Age'];
                    $_SESSION['id'] = $row['Id'];
                }else{
                    echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                       </div> <br>";
                   echo "<a href='index.php'><button class='btn'>Go Back</button>";
         
                }
                if(isset($_SESSION['valid'])){
                    header("Location: index.html");
                }
              }else{

            
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
               

                <div class="field">
                     
             <!--<a href="forgot_password.php">Forgot Password?</a>-->
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                  
                      Don't have account? <a href="register.php">Sign Up Now</a>


                 
           
           
                            
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
      <script>
        document.getElementById('get-otp-btn').addEventListener('click', function() {
            var email = document.getElementById('email').value;
            if (email) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'otp.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                    }
                };
                xhr.send('email=' + encodeURIComponent(email));
            } else {
                alert('Please enter your email address.');
            }
        });
    </script>
</body>
</html>