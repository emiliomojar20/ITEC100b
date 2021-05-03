<style type="text/css">
    h3{
    font-family: "Courier New";
    width: 450px;
    height: 30px;
    text-align: center;
    font-size: 20px;
    color: red;
    margin: 0 auto;
    margin-top: 10px;
}
</style>

<?php 
session_start();
require_once "config.php";
    if(!isset($_SESSION["code_access"]) || $_SESSION["code_access"] !== true){
        header("location: index.php");
        exit;
    }else{

        $permitted_chars =rand(100000,999999);

        $duration = floor(time()/(60*5));
        srand($duration);
        $_SESSION["codee"] = substr(str_shuffle($permitted_chars), 0, 6);
                
        date_default_timezone_set('Asia/Manila');

        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $endDate_months = strtotime("+5 minutes", $currentDate_timestamp);
        $packageEndDate = date('Y-m-d H:i:s', $endDate_months);
            
        $_SESSION["current"] = $currentDate;
        $_SESSION["expired"] = $packageEndDate;

        $user_id = $_SESSION["id"];
        $codee = $_SESSION["codee"];
        

        $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$codee', '$currentDate', '$packageEndDate')";
        
        $result = mysqli_query($con,"select * from code where code='$codee'") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($result);
        if($count == 0)
        {
            if(mysqli_query($con, $sql)){
               
            } else{
            echo "ERROR: $sql. " . mysqli_error($con);
            }
        }else{
       
        }

        
    }
?>

  
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Authenticator</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width, initial-scale=1">
    <link rel="stylesheet" href="styless.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

    <body style="background-color:gray;">
            <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                          <h4 id="hh" class="modal-title">ENTER AUTHENTICATION CODE</h4>
                          <form role="form" method="post"><br>
                    <div class="form-group">
                    <input type="text" id="hhh" name="code" class="form-control" placeholder="Authentication Code" maxlength="6"    >    
                   
                </div>
                <div class="form-group">
                   <center> <center><button type="submit" id="btn1" name="login" class="btn btn-primary">SUBMIT</button><BR></center>
                </div>
                  </div>
                  
                </div>
            </div>
        </form>

        <h1 id="h"> AUTHENTICATION CODE </h1>
        <hr class="new">
        <h4 id="code">
            <?php echo $_SESSION["codee"]; ?>       
        </h4><br><br><br><br>
               
</body>

<script type="text/javascript">
	    $(window).on('load', function() {
	        $('#myModal').modal('show');
	    });
</script>

 <?php 

if(!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true){
    header("location: index.php");
    exit;
}
 
require_once "config.php";

$code_err = "";
$_SESSION["code_access"] = true;

if(isset($_POST['login']))
{ 
    if(empty(trim($_POST["code"]))){
        echo "<p class='p'>Enter this code.</p><a href='index.php'></a>";
    } else{ 

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        

        $id_code = mysqli_query($con,"SELECT * FROM code WHERE code='$code' AND id_code=id_code") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($id_code);
        
        if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
        }

        $sql = "SELECT expiration FROM code where code='$code'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div style='display: none;'>"."Expiration: " . $row["expiration"]. "<br>";
                echo $currentDate."<br></div>";
                if(($row["expiration"]) >($currentDate)){

                    $_SESSION["loggedin"] = true;

                    $_SESSION["id"] = $user_id;

                    $user_id = $_SESSION["id"];
                    $user_name = $_SESSION["username"];

                    $sql1 = "INSERT INTO `userlog` (user_id, username, activity, dateandtime) VALUES ('$user_id', '$user_name', 'Entered Successsful Code', '$currentDate')";

                    $result1 = mysqli_query($con, $sql1);

                    header("location: main.php");

                }
                else{
                    echo "<p class='p'>Expired code entered.</p>";
                }
            }
          } else {
            echo "<p class='p'>Wrong code entered.</p>";
          }

          $con->close();
    }
    
    //mysqli_close($con);
}
?>
   
</html>  