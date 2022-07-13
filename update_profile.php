<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

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
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
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
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
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
   <title>update profile</title>
   <link rel="shortcut icon" href="data:image/png;base64,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" type="image/x-icon">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">go back</a>
   </form>

</div>

</body>
</html>