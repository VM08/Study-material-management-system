<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Of Semester</title>
   <link rel="stylesheet" href="profile.css">
   <link rel="stylesheet" href="Button.css">
    <link rel="shortcut icon" href="data:image/png;base64,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" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <center>
        <header>
    <table cellspacing="15">
        <tr>
            <td class="div" class="left">
                <a href="index.html"><img src="home.png" alt="home" height="70" width="70"></a>
            </td>
            <td class="div">
                <h3>
                    COMPUTER SCIENCE AND ENGINEERING
                    <br>
                    Syllabus And Study Materials
                </h3>
                SEMESTER LIST
            </td>
            <td class="div" class="right">
                Profile layout
                <br>/<br>
                Update profile
            </td>
            <td class="none">
                <a href="update_profile.php">
                    <?php
                        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                        if(mysqli_num_rows($select) > 0){
                            $fetch = mysqli_fetch_assoc($select);
                        }
                        if($fetch['image'] == ''){
                            echo '<img src="images/default-avatar.png">';
                        }else{
                            echo '<img src="uploaded_img/'.$fetch['image'].'">';
                        }
                    ?>
                </a>
            </td>
        </tr>
    </table>
</header>
    <footer class="gra"> 
        <table cellspacing="35px">
            <tr>
                <td class="content">
                <div class="contain">
                    <a href="Sem List/sem 1 dir/sem1.html" target="_blank">
                        <span>
                             SEMESTER I
                        </span>
                    </a>
                </div>
                </td>
                <td class="content">
                <div class="contain">
                    <a href="Sem List/sem 2 dir/sem2.html" target="_blank">
                        <span>
                             SEMESTER II
                        </span>
                    </a>
                </div>
                </td>
                <td  class="content">
                <div class="contain">
                    <a href="Sem List/sem 3 dir/sem3.html" target="_blank">
                        <span>
                             SEMESTER III
                        </span>
                    </a>
                </div>
                </td>
            </tr> 
            <tr> 
                <td class="content"> 
                <div class="contain">
                    <a href="Sem List/sem 4 dir/sem4.html" target="_blank">
                        <span>
                            SEMESTER IV
                        </span>
                    </a>
                </div>
                </td> 
                    <td>
                      
                    </td>
                <td  class="content">
                <div class="contain">
                    <a href="Sem List/sem 5 dir/sem5.html" target="_blank">
                        <span>
                        SEMESTER V
                        </span>
                    </a>
                    </div>
                </td>
            </tr>
            <tr>                   
            <td  class="content">
                <div class="contain">
                    <a href="#">
                        <span>
                    SEMESTER VI
                        </span>
                    </a>
                    </div>
                </td>      
            <td  class="content">
            <div class="contain">
                <a href="Sem List/sem 7 dir/sem7.html" target="_blank">
                    <span>
                    SEMESTER VII
                    </span>
                </a>
            </div>
            </td> 
            <td  class="content">
            <div class="contain">
                <a href="Sem List/sem 8 dir/sem8.html" target="_blank">
                    <span>
                    SEMESTER VIII
                    </span>
                </a>
            </div>
            </td> 
            </tr>
        </table>
    </footer>
    </center>  
</body>
</html>