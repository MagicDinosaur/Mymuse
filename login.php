<?php

?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
function Verify($request){
    $_POST = $request;
    require_once 'config.php';

    $error = array();
    $res = array();
    
    if (empty($_POST['email'])) {
        $error[] = "Email field is required";
        // header("login.php");
        // exit();
    }
    
    if (empty($_POST['password'])) {
        $error[] = "Password field is required";
        header("login.php");
    }

    // if ($_POST['password'] != $_POST['password_confirm']) {
    //     $error[] = "Password and confirm password does not match";
    // }

    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Enter Valid Email address";
        header("login.php");
        exit();

    }
    
    if (count($error) > 0) {
        $resp['msg'] = $error;
        $resp['status'] = false;
        // echo "<script>"json_encode($resp);
        echo"<script type='text/javascript'>alert('".json_encode($resp)."');</script>";
        header("login.php");
        // exit();
    }else{
    $statement = $db->prepare("select * from users where email = :email");
    $statement->execute(array(':email' => $_POST['email']));
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($row) > 0) {
        if (!password_verify($_POST['password'], $row[0]['password'])) {
            echo"<script type='text/javascript'>alert(\"Password is not valid\");</script>";
            $error[] = "Password is not valid";
            $resp['msg'] = $error;
            $resp['status'] = false;
            // echo json_encode($resp);
            echo"<script type='text/javascript'>alert(\"Password is not valid\");</script>";
            header("Location: login.php");
            
            exit();
            
        }
        $cookie_name = "user_id";
        $cookie_value = $row[0]['id'];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        $cookie_name1 = "user_name";
        $cookie_value1 = $cookie_value = $row[0]['user'];;
        setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/"); 
        // $_SESSION['user_id'] = $row[0]['user_id'];
        // $resp['redirect'] = "dashboard.php";
        $resp['status'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error[] = "Email does not match";
        $resp['msg'] = $error;
        $resp['status'] = false;
        // echo json_encode($resp);
        exit;
    }
}
}

function Register($request){
    $_POST = $request;
    require_once 'config.php';
    $error = array();
    // if (empty($_POST['email'])) {
    //     $error[] = "Email field is required";
    //     // header("login.php");
    //     // exit();
    // }
    // echo"Missing fileds";
    if (empty($_POST['password']) || empty($_POST['repeatpassword']) || empty($_POST['username']) || empty($_POST['email'])) {
        $error[] = "Password field is required";
        echo"<script type='text/javascript'>alert(\"Missing fileds\");</script>";
    }
    if ($_POST['password'] != $_POST['repeatpassword']) {
        $error[] = "Password and confirm password does not match";
        echo"<script type='text/javascript'>alert(\"Password and confirm password does not match\");</script>";
    }
    $statement = $db->prepare("select * from users where email = :email or user = :user");
    $statement->execute(array(':email' => $_POST['email'], ':user' => $_POST['username']));
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($row) > 0) {
        $error[] = "Email or username already exists";
        echo"<script type='text/javascript'>alert(\"Email or username already exists\");</script>";
        header("Location: index.php");
        exit;
    }
        $statement = $db->prepare("insert into users (user, email, password) values (:user, :email, :password)");
       
        $statement->execute(array(':user' => $_POST['username'], ':email' => $_POST['email'], ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)));
        $resp['redirect'] = "login.php";
        $resp['status'] = true;
        
        $cookie_name = "user_id";
        $cookie_value = $db->lastInsertId();

        date_default_timezone_set("America/New_York");
        $date = date('Y-m-d H:i:s');
        $statement1 = $db->prepare("insert into scores (userID, score,date) values (:id, 0,:date)");
        $statement1->execute(array(':id' => $cookie_value, ':date' => $date));
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        $cookie_name1 = "user_name";
        $cookie_value1 = $_POST['username'];
        setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/"); 

        if(isset($_COOKIE['user_id'])){
            header("Location: index.php");
        }
    
}

       

?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_POST['login'])) {
    Verify($_POST);
}else if(isset($_POST['register'])) {
    Register($_POST);
}
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <title>MyMuse</title>

    <!-- import the webpage's stylesheet -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css" />


<!-- import the webpage's javascript file -->
<script src="login.js" defer></script>
  </head>
  <body>
    <!-- this is the start of content -->
   
    <nav class="navbar navbar-expand navbar-light flex-column flex-md-row bd-navbar"  style="background-color: #f2cece7b;">
      <a class="navbar-brand" style = "color:#9d7b7be6;"href="index.php">MyMuse Login</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

      </div>
    </nav>


<div id = "MyMuseWelcomeContent" style=" margin-top: 40px;">

    <h1 class="title" style="font-weight: bold;">MyMuse</h1>

    <p>
      Welcome to my final project!! Hope you enjoy it
    </p>

    </div>
<div id = "MyLoginForm" class="MyMuseFormLogin" style="width : 25%; margin:0 auto;" >
    
<form method="post">
  <div class="form-group">
    <label>Enter your information</label>
    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" >
  </div>
  <div class="form-group">
    <input type="password" class="form-control" name="password" placeholder="Password">
  </div>

  <button type="submit" class="login-button" style="padding: 10px;" name ="login">Login</button>
</form>




<p>Haven't had an account yet?!! Register in <strong onclick=DisplayRegister()>here</strong></p>
</div>
<div id = "MyRegisterForm" class="MyMuseFormRegister hidden"  style="width : 25%; margin:0 auto;" >
<form method = "post">
<div class="form-group">
      <label for="exampleInputEmail1">Enter your information</label>
      <input type="text" class="form-control" name="username" placeholder="Your User Name">
    </div>
    <div class="form-group">
    
      <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" >
    </div>
    <div class="form-group">
      <!-- <label for="exampleInputPassword1">Password</label> -->
      <input type="password" class="form-control" name="password" placeholder="Password">
      
    </div>

    <div class="form-group">

      <input type="password" class="form-control" name="repeatpassword" placeholder="Repeat your password">
      
    </div>
    
    <button type="submit" class="login-button" style="
      padding: 10px;" name ="register">Register</button>
    </form>
      <p>Already a member? Login in  <strong onclick=DisplayLogin()>here</strong></p>
  </div>

</div>
</div>
  </body>
  
</html>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>









