<?php
include 'dbconn.php';
if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      session_start();
      $_SESSION['name'] = $row['name'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>MediaBook-Login</title>
</head>
<body>
<div class="center">
   <style>
   .img-con{
      position: absolute;
      height: 40px;
      margin-left: 50px;
      margin-top: 25px;
   }
   </style>
   <img src="css/images/logo.png" alt="Logo"  class="img-con"><h1>MediaBook</h1>
      <form action="" method="post" enctype="multipart/form-data">
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
        <div class="txt_field">
          <input type="text" name="email" required >
          <span></span>
          <label>E-mail</label>
        </div>
        <div class="txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password</label>
        </div>
        <input type="submit" name="submit" value="Signup">
        <div class="signup_link">
          Not a Account? <a href="register.php">Register Now</a>
        </div>
      </form>
    </div>
</body>
</html>