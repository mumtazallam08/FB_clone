<?php
include 'dbconn.php';
if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));   
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');
   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index.php');
         }else{
            $message[] = 'registeration failed!';
         }
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
   <link rel="shortcut icon" href="css/images/logo.png" type="image/x-icon">
   <title>MediaBook-Register</title>
   <link rel="stylesheet" href="css/style.css">
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
        <div class="txt_field"><input type="text" name="name" required><span></span><label>Name</label></div>
        <div class="txt_field"><input type="email" name="email" required><span></span><label>E-mail</label></div>

        <div class="txt_field"><input type="password" name="password" required><span></span><label>Password</label></div>
        <div class="txt_field"><input type="password" name="cpassword" required><span></span><label>Comfirm Password</label></div>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
        <br><br>
        <input type="submit" name="submit" value="Register Now">
        <div class="signup_link">already have an account? <a href="index.php">Signup</a>
        </div>
    </div>
</body>
</html>