<!-- <script src="script.js"></script> -->
<?php

$user_id = $_COOKIE["user_id"];

$aResult1 = array();
if( !isset($_POST['img']) ) { $aResult1['error'] = "NÈ KHÔNG NHẬN ĐÂU NÈ"; }
else{
$img = $_POST['img'];
// $date = date('Y-m-d H:i:s');
$user_id = $_COOKIE["user_id"];
$db = new PDO();
$statement1 = $db->prepare("update user_info set avatar=:img where userID = :userID");

$statement1->execute(array(':img' => $img, ':userID' => $user_id));
$aResult1['status'] = 'success';
}
echo json_encode($aResult1);
return $aResult1;

?>
