

<div class ="PersonalDashBoard" style="margin-bottom: 10px;">

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


function get_rank(){
    require_once 'config.php';
    $db = new PDO('mysql:host=us-cdbr-east-06.cleardb.net;dbname=heroku_78c23a779fcb235', 'bb38448cc7530c', 'b83a2b78');

    $statement = $db->prepare("SELECT DISTINCT userID, score,  email, user FROM scores INNER JOIN users ON scores.userID=users.id ORDER BY score desc");

    $statement->execute();
    // $statement->bind_result($rs);
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $row;
}

function your_rank($user_id) {
    $row = get_rank();
    $i=0;
    if (count($row) > 0) {
        
        while($row[$i]['userID'] != $user_id) {
            $i++;
            if ($row[$i]['userID'] == $user_id){
                break;
            } 
        }
        $user_name = $_COOKIE['user_name'];
        $ranking = $i+1;
        echo "<h3>Hi $user_name &#128570 Your ranking is: $ranking";
    }
    
}


if(!isset($_COOKIE["user_name"])) {

    echo "<h3> Hi there &#128570 . Please login to save archivement and view rank</h3>";
  } else {
    $user_id = $_COOKIE["user_id"];
    your_rank($user_id);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
  }

?>


</div>

<table class="table">
  <thead style ="background-color:#f8c2cb73">
    <tr>
      <th scope="col">Rank</th>
      <!-- <th scope="col">UserID</th> -->
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Score</th>
      <!-- <th scope="col">Handle</th> -->
    </tr>
  </thead>
  <tbody>

<?php

require_once 'config.php';

//$db = new PDO('mysql:host=localhost;dbname=wp_final', 'root', '');
$db = new PDO('mysql:host=us-cdbr-east-06.cleardb.net;dbname=heroku_78c23a779fcb235', 'bb38448cc7530c', 'b83a2b78');
$statement = $db->prepare("SELECT DISTINCT userID, score, email, user FROM scores INNER JOIN users ON scores.userID=users.id ORDER BY score desc");
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

$limit = 7;
$run = min(count($row), $limit);
$count = 1;
for ($i = 0; $i < $run; $i++) {
    echo "<tr>";
    // echo "<th>".($i+1)."</th>";
    echo "<th>".$count."</th>";

    echo "<th>".$row[$i]['user']."</th>";
    echo "<th>".$row[$i]['email']."</th>";
    if($row[$i]['score'] != $row[($i+1)]['score']){
        $count = $count + 1;
    }
    echo "<td>".$row[$i]['score']."</td>";
    // echo "<td>".$count."</td>";

    echo "</tr>";
}
?> 
  </tbody>
</table>


 