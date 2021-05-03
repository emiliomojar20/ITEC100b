<!DOCTYPE html>
<html>
<head>
  	       <link rel="stylesheet" type="text/css" href="	style.css">
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	         <title>	Activity</title>
</head>
<body>

    <form class="box"action="" method="post">

        <h1>Bubs Web Application</h1>
        
        <?php if (isset($_GET['error'])) { ?>
            <center><p class="error"><?php echo $_GET['error']; ?></p></center>
        <?php } ?>
        <input class="input" type="text" name="username" placeholder="Username"><br>

        <input class="input" type="password" name="password" placeholder="Password"><br>

        <center><button type="submit" class="btn" method="post" name="login">Login</button>
        <button type="button" class="btn" name="register" onclick="window.location.href='../Activity4withEventLog/signup.php'">Register</button></center>

        <div class="forgot">
        <a href="../Activity4withEventLog/forgot.php">Forgot password?</a>
        </div>
    </form>


</body>
<?php

    include 'config.php';

    $_SESSION["verify"] = false;
    $_SESSION["code_access"] = false;

    if (isset($_POST['username'])){
        
        $username = stripslashes($_REQUEST['username']); // removes backslashes
        $username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
        
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con,$password);

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $_SESSION["current"] = $currentDate;
        
        $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";
        $result = mysqli_query($con,$query) or die(mysql_error());
        $rows = mysqli_num_rows($result);

        if($rows==1){

            $_SESSION["verify"] = true;
            $_SESSION["code_access"] = true;

            $_SESSION["id"] = $id;
            $_SESSION['username'] = $username;

            $sql = "INSERT INTO `userlog` (user_id, username, activity, dateandtime) VALUES ('$id', '$username', 'Logged In', '$currentDate')";
            $result = mysqli_query($con, $sql);

            header("Location: ../Activity4withEventLog/authenticator.php");

        }else{
           header("Location: index.php?error=Incorect User name or password");
        }

    }else{

    }
?>
</html>