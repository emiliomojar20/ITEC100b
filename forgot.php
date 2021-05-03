<!DOCTYPE html>
<html lang="en">
<head>
    <title> Forgot Password</title> 

    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"/>
    <meta name="viewport" content="width-device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
</head>  
<body>
         
    <div class="wrapper">
        <div class="form">
            
            <form class="box"action="" method="post" name="login">
            <div class="container">
                <h1 id="hhhh"> CHANGE PASSWORD </h1>
                <form class="form group" action="/authenticator.php">
                    <input class="text" id="username" type="text" name="username" placeholder="Username"><br>
                    <input class="text" id="newpassword" type="password" name="newpassword" placeholder="New Password"><br>
                    <input class="text" id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirm Password">
                </form>
                <br><br>
                <center><button type="submit" class="btn" method="post" name="changepassword">Change Password</button>
                <button type="button" class="btn" name="register" onclick="window.location.href='../Activity4withEventLog/index.php'">Cancel</button>
                </center>          

            </div>
        </div>
    </div>


</body>

<!--<?php 
session_start();
  
require_once "config.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    if(empty(trim($_POST["username"]))){
        echo "<h3>Username is empty.</h3><a href='Login.php'></a>";
    } else{
        $username = trim($_POST["username"]);
    }
     
    if(empty(trim($_POST["password"]))){
        echo "<h3>Password is empty.</h3><a href='Login.php'></a>";
    } else{
        $password = trim($_POST["password"]);
    }
     
    if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            
                            $_SESSION["id"] = $id;

                            $link = "<script>window.open('http://localhost/Activity4withEventLog/authenticator.php')</script>"; 
                            echo $link; 

                        } else{                              
                            echo "<h3>Password is incorrect.</h3>";
                        }
                    }
                } else{ 
                    echo "<h3>Username is incorrect.</h3>";
                }
            } else{
                echo "<h3>Something went wrong.</h3>";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($con);
}
?>-->

<?php
    include 'config.php';

    $_SESSION["verify"] = false;
    $_SESSION["code_access"] = false;

    if (isset($_POST['username'])){
        
        $username = stripslashes($_REQUEST['username']); // removes backslashes
        $username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
        
        $newpassword = stripslashes($_REQUEST['newpassword']);
        $newpassword = mysqli_real_escape_string($con,$newpassword);

        $confirmpassword = stripslashes($_REQUEST['confirmpassword']);
        $confirmpassword = mysqli_real_escape_string($con,$confirmpassword);

        date_default_timezone_set('Asia/Manila');
          $currentDate = date('Y-m-d H:i:s');
          $currentDate_timestamp = strtotime($currentDate);
          $_SESSION["current"] = $currentDate;


        if (empty($username)) {
            echo "<h3>Username is Required.</h3>";
        }else if(empty($newpassword)){
            echo "<h3>New Password is Required.</h3>";  
        }else if(empty($confirmpassword)){
            echo "<h3>Confirmation Password is Required.</h3>";
        }

        if($newpassword !== $confirmpassword){
            echo "<h3>Confirmation Password does not match.</h3>";
        }else if (strlen($newpassword)<=8){
            echo "<h3>Password is atleast 8 characters. </h3>";
        }else if(!preg_match("#[A-Z]+#",$newpassword)) {
            echo "<h3>Password must contain at least 1 upper case.</h3>";
        }else if(!preg_match("#[a-z]+#",$newpassword)){
            echo "<h3>Password must contain at least 1 lower case.</h3>";
        }else if(!preg_match("#[0-9]+#",$newpassword)){
            echo "<h3>Password must contain at least 1 number.</h3>";
        }else if(!preg_match("#[\W]+#",$newpassword))  {
            echo "<h3>Password must contain at least 1 special character.</h3>";
        }
        else{
            $query ="UPDATE `users`  SET password = '$newpassword' WHERE username = '$username'";
            $result = mysqli_query($con,$query) or die(mysql_error());

            $_SESSION["verify"] = true;
            $_SESSION["code_access"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;

            $user_id = $_SESSION["id"];
            $user_name = $_SESSION["username"];

            $sql = "INSERT INTO `userlog` (user_id, username, activity, dateandtime) VALUES ('$user_id', '$user_name', 'Changed Password', '$currentDate')";
            $result = mysqli_query($con, $sql);

            echo "<h4>Password Changed. Go to <a href='../Activity4withEventLog/index.php'> Login <a></h4>";
            //header("location: ../authentication/index.php");
        }

    }else{

    }
?>

</html>