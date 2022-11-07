


<?php
require_once './config.php';
function Update($request){
    global $db;
    $_POST = $request;

    $error = array();
  
    if($_COOKIE["user_id"] == ""){
        $error['error'] = "You are not logged in";
        echo"<script type='text/javascript'>alert(\"Wrong User Account\");</script>";
        header("Location: index.php");
    }else{
    $user_id = $_COOKIE["user_id"];
    $statement = $db->prepare("select distinct * from user_info where userID = :userID");
    $statement->execute(array(':userID' => $user_id));
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($row) > 0) {
        // require_once './config.php';
        $statement = $db->prepare("update user_info set phone = :phone, address = :address, description = :description where userID = :userID");
        // $statement = $db->prepare("update user_info set address = :address, phone :=phone, description = :description where userID = :userID");
        print_r(array(':address' => $_POST['address'], ':phone' => $_POST['phone'], ':description' => $_POST['description'], ':userID' => $user_id));

        $statement->execute(array(':address' => $_POST['address'],':phone' => $_POST['phone'], ':description' => $_POST['description'], ':userID' => $user_id));
        // $resp['redirect'] = "account-info.php";
        echo"<script type='text/javascript'>alert(\"Information Updated\");</script>";
        header("Location: account-info.php");
        exit();
    } else {
        // require_once './config.php';
        $statement = $db->prepare("insert into user_info (userID, address, phone, description) values (:userID, :address, :phone, :description)");
        $statement->execute(array(':userID' => $user_id, ':address' => $_POST['address'], ':phone' => $_POST['phone'], ':description' => $_POST['description']));
        // $resp['redirect'] = "account-info.php";
        echo"<script type='text/javascript'>alert(\"Information Updated\");</script>";
        header("Location: account-info.php");

    }
}
}




?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_POST['UpdateInfo'])){
    Update($_POST);
} 


?>

<script src="script.js"></script>
<form method="post">
<div class="form-group">
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
  </div>
    <div class="form-group">
    <input type="text" class="form-control" name="phone" placeholder="Enter your phone number" >
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="address" placeholder="Enter your Address">
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="description" placeholder="Update your description">
  </div>

  <button type="submit" class="login-button" style="padding: 10px;" name ="UpdateInfo">Update</button>

</form>