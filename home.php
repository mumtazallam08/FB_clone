<!DOCTYPE html>
<?php

include 'dbconn.php';
session_start();
$user_id = $_SESSION['name'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}
if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user` SET name = '$update_name', email = '$update_email' WHERE name = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user` SET password = '$confirm_pass' WHERE name = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }
   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user` SET image = '$update_image' WHERE name = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }
}
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
<link rel="stylesheet" href="style.css">
<title>MediaBook</title>
<style>
#mychatDIV, #myvDIV {
width: 400px;
height: 500px;
border-radius: 10px;
padding: 50px 0;
text-align: center;
background-color: lightblue;
margin-top: 20px;
display: none;
}

.display-cee{
		height:300px;
		background-color: skyblue;
		margin-bottom:4%;
		overflow:auto;
		padding:15px;
	}
    </style>
</head>
<body>
    <nav>
        <div class="nav-left">
            <img src="images/logo.png" alt="Logo">
            <input type="text" placeholder="Search Mediabook..">
        </div>

        <div class="nav-middle">
            <a href="#" class="active"><img src="images/home.png" alt="Home" class="profile-mid"></a>
            <a href="#" onclick="myfFunction()"><img src="images/friends.png" alt="friends" class="profile-mid"></a>
            <a href="#" ><img src="images/videos.png" alt="Video" class="profile-mid"></a>
            <a href="#" onclick="myFunction()"><img src="images/group.jpg" alt="Group"  class="profile-mid"></a>
        </div>
        <div class="nav-right">
        <a onclick="document.getElementById('id01').style.display='block'" >
         <?php
         $select = mysqli_query($conn, "SELECT * FROM `user` WHERE name = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png" class="profile-left">';
         }else{
            echo '<img style="height: 40px; width: 40px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;" src="uploaded_img/'.$fetch['image'].'">';
         }
         ?>
            </a>
            <a href="#"><img src="images/notifi.png" alt="Notification"  style="width: 30px"></a>
            <a href="logout.php"><img src="images/logout.png" alt="friends" class="profile-left"></a>
        </div>
    </nav>


    <div class="container">
        <div class="left-panel">
            <ul><li>
                <div class="profile-left" >
                <?php
                 if($fetch['image'] == ''){
                  echo '<img src="images/default-avatar.png" style="height: 40px; width: 40px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;">';
                  }else{
                  echo '<img style="height: 40px; width: 40px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;" src="uploaded_img/'.$fetch['image'].'">';
                    }
                ?>
                 </div><p style="margin: 20px"><h3><?php echo $fetch['name']; ?></h3></p>
                </li>
                <li onclick="myfFunction()"><img src="images/friends.png" alt="friends" class="profile-left"><p class="left-con">Friends</p></li>
                <li><img src="images/videos.png" alt="friends" class="profile-left"><p class="left-con">Videos</p></li>
                <li><img src="images/pages.png" alt="friends" class="profile-left"><p class="left-con">Pages</p></li>
                <li><img src="images/group.jpg" alt="friends"  class="profile-left"><p class="left-con">Groups</p></li>
                <li><img src="images/bookmark.png" alt="friends" class="profile-left"><p class="left-con">Bookmark</p></li>
                <li><img src="images/message.png" alt="friends" class="profile-left"><p class="left-con">Inbox</p></li>
                <li><img src="images/event.png" alt="friends" class="profile-left"><p class="left-con">Events</p></li>
                <li><img src="images/ads.png" alt="friends" class="profile-left"><p class="left-con">Ads</p></li>
                <li><img src="images/offers.png" alt="friends" class="profile-left"><p class="left-con">Offers</p></li>
                <li><img src="images/job.png" alt="friends" class="profile-left"><p class="left-con">Jobs</p></li>
                <li><img src="images/favorite.png" alt="friends" class="profile-left"><p class="left-con">Favourites</p></li>
                </ul>
          
             <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Advance</a>
                <a href="#">More</a>
             </div>
            </div>
         <div class="middle-panel">

            <div class="story-section">

                <div class="story create">
                    <div class="dp-image">
                     <?php
                     if($fetch['image'] == ''){
                     echo '<img src="images/default-avatar.png" >';
                       }else{
                      echo '<img src="uploaded_img/'.$fetch['image'].'">';
                     }
                      ?>
                    </div>
                    <span class="dp-container">
                        <img src="images/plus.jpg"></img>
                    </span>
                    <span class="name">Create Story</span>
                </div>
                <div class="story">
                    <img src="./images/model.jpg" alt="">
                    <div class="dp-container">
                        <img src="images/default-avatar.png" alt="">
                    </div>
                </div>

                <div class="story">
                    <img src="./images/boy.jpg" alt="">
                    <span class="dp-container">
                        <img src="images/default-avatar.png" alt="">
                    </span>

                </div>

                <div class="story">
                    <img src="./images/mountains.jpg" alt="">
                    <span class="dp-container">
                        <img src="images/default-avatar.png" alt="">
                    </span>
                </div>
            </div>
            <div class="post" >
                <div class="post-top">
                    <div class="dp">
                        <img src="./images/girl.jpg" alt="">
                    </div>
                    <input type="text" placeholder="What's on your mind, Aashish ?" />
                </div>
                
                <div class="post-bottom">
                    <div class="action">
                        <i class="fa fa-video"></i>
                        <span>Live video</span>
                    </div>
                    <div class="action">
                        <i class="fa fa-image"></i>
                        <span>Photo/Video</span>
                    </div>
                    <div class="action">
                        <i class="fa fa-smile"></i>
                        <span>Feeling/Activity</span>
                    </div>
                </div>
            </div>

            <div class="post" style="position: relatives;">
                <div class="post-top">
                    <div class="dp">
                        <img src="./images/girl.jpg" alt="">
                    </div>
                    <div class="post-info">
                        <p class="name">Anuska Sharma</p>
                        <span class="time">12 hrs ago</span>
                    </div>
                    <i class="fas fa-ellipsis-h"></i>
                </div>

                <div class="post-content">
                    Roses are red <br>
                    Violets are blue <br>
                    I'm ugly & you are too😏
                </div>
                
                <div class="post-bottom">
                    <div class="action">
                        <i class="far fa-thumbs-up"></i>
                        <span>Like</span>
                    </div>
                    <div class="action">
                        <i class="far fa-comment"></i>
                        <span>Comment</span>
                    </div>
                    <div class="action">
                        <i class="fa fa-share"></i>
                        <span>Share</span>
                    </div>
                </div>
            </div>
            <div class="containerone" style="position: absolute;">
        </div>
         </div>
                <div id="mychatDIV" >
    <?php 
include "chatpage.php"
?>        </div>
        <div class="right-panel">
            <div class="pages-section right-profile">   
              <div class="update-profile">
             <div id="id01" class="w3-modal">
           <div class="w3-modal-content w3-card-4">
           <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img style="height: 150px; width: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;" src="images/default-avatar.png">';
         }else{
            echo '<img style="height: 150px; width: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;" src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit"  value="Update Profile" name="update_profile" class="box btn">
    </form>
</div> 
    </div>
    
</body>

<script>
var modal = document.getElementById('id01');
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
function myFunction() {
  var x = document.getElementById("mychatDIV");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
</html>