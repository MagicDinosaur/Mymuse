<?php
require_once 'config.php';
$user_id = $_COOKIE["user_id"];
date_default_timezone_set("America/New_York");
// header('Content-Type: application/json');
echo "<script>console.log(\"test\")</script>";
$aResult = array();
if( !isset($_POST['score']) ) { $aResult['error'] = 'No score set!'; }
$score = $_POST['score'];
$date = date('Y-m-d H:i:s');
$statement1 = $db->prepare("insert into scores (userID, score,date) values (:id, :score,:date)");
$statement1->execute(array(':id' => $user_id, ':score' => $score, ':date' => $date));
$aResult['status'] = 'success';
// echo json_encode($aResult);
return $aResult;
?>


