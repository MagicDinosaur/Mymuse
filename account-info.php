<?php
require_once 'config.php';
global $db;

$user_id = $_COOKIE["user_id"];

$statement = $db->prepare("SELECT userID, score, date, user, email FROM scores INNER JOIN users ON scores.userID=users.id where users.id =:user_id ORDER BY date DESC limit 4;");
$statement->execute(array(':user_id' => $user_id));
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

$user_name = $row[0]['user'];
$user_email = $row[0]['email'];
// $user_score = $row[0]['score'];
$statement1 = $db->prepare("SELECT DISTINCT userID, score, date FROM scores INNER JOIN users ON scores.userID=users.id where userID=:user_id ORDER BY score desc;;");
$statement1->execute(array(':user_id' => $user_id));
// $statement1->execute();
$row1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
$user_score = $row1[0]['score'];
$user_date = $row1[0]['date'];

$statement2 = $db->prepare("SELECT DISTINCT * FROM user_info where userID =:user_id;");
$statement2->execute(array(':user_id' => $user_id));
$row2 = $statement2->fetchAll(PDO::FETCH_ASSOC);

if ($row2[0]['phone'] == null) {
  $phone = "Not Provided";
} else {
  $phone = $row2[0]['phone'];
}
if ($row2[0]['address'] == null) {
  $address = "Not Provided";
} else {
  $address = $row2[0]['address'];
}
if ($row2[0]['description'] == null) {
  $description = "Update your description";
} else {
  $description = $row2[0]['description'];
}
if ($row2[0]['avatar'] == null) {
  $image = "pngwing.com.png";
} else {
  $image = $row2[0]['avatar'];
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />


  <title>MyMuse</title>

  <!-- import the webpage's stylesheet -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="style.css" />

  <!-- import the webpage's javascript file -->

  <script src="script.js" defer></script>
</head>

<body>
  <!-- this is the start of content -->
  <nav class="navbar navbar-expand navbar-light flex-column flex-md-row bd-navbar" style="background-color: #f2cece7b;">
    <a class="navbar-brand" style="color:#9d7b7be6;" href="index.php">MyMuse</a>

    <button id="navibutton2" class="login-button " onclick=SignOut_()>Log Out</button>
    </form>
    </div>
    </div>
  </nav>




  <div class="container py-5">
    <div class="row">
      <div class="col">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src=<?php echo "$image" ?> alt="avatar" class="rounded-circle " style="width: 150px;"/>
            <?php echo "<h5 class=\"my-3\">" . $user_name . "</h5>"; ?>
            <?php
            echo "<p class=\"text-muted mb-1\">" . $description . "</p>";
            ?>
            <input type="file" id="input111" name="uploadfile" style="display:none" />

            <label for="input111">Click me to update avatar</label>

            <canvas id="canvas" width=64 height=64 hidden></canvas>
          </div>
        </div>
        <h5> <b> Update Account Infomation</b></h5>
        <div class="card mb-4 mb-lg-0">
        </div>
        <?php
      include('account-manager/account-info-update.php');
      ?>
        <div class="card mb-4 mb-lg-0 hidden">
        </div>
      </div>
      <div class="col-lg-8">
        <h5> <b>Account Infomation</b></h5>
        <div class="card mb-4">

          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">User Name</p>
              </div>
              <div class="col-sm-9">
                <?php echo "<p class=\"text-muted mb-0\">" . $user_name . "</p>"; ?>

              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <?php echo "<p class=\"text-muted mb-0\">" . $user_email . "</p>"; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">

                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <?php
              echo "<p class=\"text-muted mb-0\">" . $phone . "</p>";
              error_reporting(E_ALL);
              ini_set('display_errors', '1');
              ?>
              </div>
            </div>

            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
                <?php echo "<p class=\"text-muted mb-0\">" . $address . "</p>"; ?>
              </div>
            </div>
          </div>
        </div>
        <h5> <b onclick=showLastestScoresTable()> Lastest Scores </b> | <b onclick=showHighestScoresTable()> Best
            Achievement</b></h5>
        <div class="row">



          <table id="lastestTable" class="table ">
            <thead style="background-color:#f8c2cb73">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Score</th>
                <th scope="col">Time archived</th>

              </tr>
            </thead>
            <tbody>

              <?php
                  $limit = 4;
                  $run = min($limit, count($row));

                  for ($i = 0; $i < $run; $i++) {
                    echo "<tr>";
                    echo "<th scope=\"row\">" . ($i + 1) . "</th>";
                    echo "<td>" . $row[$i]['score'] . "</td>";
                    echo "<td>" . $row[$i]['date'] . "</td>";

                    echo "</tr>";
                  }
    ?>

            </tbody>
          </table>

          <table id="highestTable" class="table hidden">
            <thead style="background-color:#f8c2cb73">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Score</th>
                <th scope="col">Time archived</th>
              </tr>
            </thead>
            <tbody>

              <?php
    $limit = 4;
    $run = min($limit, count($row1));

    for ($i = 0; $i < $run; $i++) {
      echo "<tr>";
      echo "<th scope=\"row\">" . ($i + 1) . "</th>";
      echo "<td>" . $row1[$i]['score'] . "</td>";
      echo "<td>" . $row1[$i]['date'] . "</td>";

      echo "</tr>";
    }

    ?>

            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>




</body>
<script src="account-manager/script.js"></script>
</html>