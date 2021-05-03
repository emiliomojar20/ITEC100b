<!DOCTYPE html>
<html>
<head>
	<title>SIGN UP</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<body>
 
          <form class ="box"method="post">
            <div class="wrapper">
                <div class="form2">
                    <h1 id="hhhh"> USER REGISTRATION </h1> <br>
                  <input type = "text" class="input" name = "name"  placeholder = "Name"> <br>
                              
                  <input type = "text" class="input" name = "email"  placeholder = "E-mail Address" > <br>
                                 
                  <input type = "text" class="input" name = "username"  placeholder = "Username" > <br>

                  <input type = "password" class="input" name = "password"  placeholder = "Password"> <br>

                   <input type = "password" class="input" name = "confirm"  placeholder = "Confirm"> <br>

                  <h1><input type = "submit"  class="btn" value = "Register" >
                  <input type = "button" class="btn" value = "Cancel" onclick="window.location.href = '../Activity4withEventLog/index.php';"></h1>
              </div>
            </div>  

          </form>  


<?php
  require_once "config.php";

  if (isset($_REQUEST['username'])){

      $name = $_POST['name'];
      $name = stripslashes($_REQUEST['name']);
      $name = mysqli_real_escape_string($con,$name);
      
      $email = $_POST['email'];
      $email = stripslashes($_REQUEST['email']);
      $email = mysqli_real_escape_string($con,$email);
      
      $username = $_POST['username'];
      $username = stripslashes($_REQUEST['username']);
      $username = mysqli_real_escape_string($con,$username);
      
      $password = $_POST['password'];
      $password = stripslashes($_REQUEST['password']);
      $password = mysqli_real_escape_string($con,$password);

      $confirm = $_POST['confirm'];
      $confirm = stripslashes($_REQUEST['confirm']);
      $confirm = mysqli_real_escape_string($con,$confirm);

      $current_date = date("Y-m-d");
      $my_date = strtotime($current_date);
      $my_date = mysqli_real_escape_string($con,$my_date);

      date_default_timezone_set('Asia/Manila');
      $currentDate = date('Y-m-d H:i:s');
      $currentDate_timestamp = strtotime($currentDate);
      $_SESSION["current"] = $currentDate;

    if (empty($name)) {
      echo "<h3>Name is Required.</h3>";
    }else if(empty($email)){
      echo "<h3>Email is Required.</h3>";  
    }else if(empty($username)){
      echo "<h3>Username is Required.</h3>";
    }else if(empty($password)){
      echo "<h3>Password is required.</h3>";
    }else if(empty($confirm)){
      echo "<h3>Password Confirmation is Required.</h3>";    
    }
      
    if($password !== $confirm){
      echo "<h3>Confirmation Password does not match.</h3>";
    }else if (strlen($password)<=8){
      echo "<h3>Password is atleast 8 characters. </h3>";
    }else if(!preg_match("#[A-Z]+#",$password)) {
      echo "<h3>Password must contain at least 1 upper case.</h3>";
    }else if(!preg_match("#[a-z]+#",$password)){
       echo "<h3>Password must contain at least 1 lower case.</h3>";
    }else if(!preg_match("#[0-9]+#",$password)){
      echo "<h3>Password must contain at least 1 number.</h3>";
    }else if(!preg_match("#[\W]+#",$password))  {
      echo "<h3>Password must contain at least 1 special character.</h3>";
    }else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
      echo "<h3>Email is Invalid.</h3>";
    }

    else{
      $sql = "INSERT INTO `users` (name, email, username, password, created_at) VALUES ('$name','$email','$username','$password','$currentDate')";
      $result = mysqli_query($con, $sql);
      
      if($result){
        header("Location: ../Activity4withEventLog/index.php");
      }else{

      }
    }
}

      
?>   
</body>
</html>