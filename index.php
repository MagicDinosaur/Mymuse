<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css" />
  <!-- import the webpage's javascript file -->
  <script src="script.js" defer></script>
</head>

<body style="max-width: 1300px; margin: auto;">
  <!-- this is the start of content -->
  <audio src="https://cdn.glitch.global/fb615b7b-feaf-4d06-ae34-4f7cd68c67a7/button1.mp3?v=1647067138644"
    id="buttonsound1"></audio>
  <audio src="https://cdn.glitch.global/fb615b7b-feaf-4d06-ae34-4f7cd68c67a7/button2.mp3?v=1647067144810"
    id="buttonsound2"></audio>
  <audio src="https://cdn.glitch.global/fb615b7b-feaf-4d06-ae34-4f7cd68c67a7/button3.mp3?v=1647067148027"
    id="buttonsound3"></audio>
  <audio src="https://cdn.glitch.global/fb615b7b-feaf-4d06-ae34-4f7cd68c67a7/button4.mp3?v=1647067151505"
    id="buttonsound4"></audio>
  <audio src="https://cdn.glitch.global/fb615b7b-feaf-4d06-ae34-4f7cd68c67a7/button5.mp3?v=1647067154361"
    id="buttonsound5"></audio>
  <nav class="navbar navbar-expand navbar-light flex-column flex-md-row bd-navbar" style="background-color: #f2cece7b;">
    <a class="navbar-brand" style="color:#9d7b7be6;" href="index.php">MyMuse</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="#" style="color:#9d7b7be6;" onclick="showAboutus()">About us </a>
        <a class="nav-item nav-link" href="#" style="color:#9d7b7be6;" onclick="showDashboard()">Dashboard</a>
        <!-- <a class="nav-item nav-link" href="account-info.php"style = "color:#9d7b7be6;">Account</a> -->
        <a class="nav-item nav-link" href="#" style="color:#9d7b7be6" onclick="showAccount()">Account</a>

        <button id="navibutton1" class="login-button" onclick=SignIn()>Log In</button>
        <button id="navibutton2" class="login-button hidden" onclick=SignOut()>Log Out</button>
      </div>
    </div>
  </nav>
  <div id="MyMuseWelcomeContent" style=" margin-top: 40px;">
    <h1 class="title" style="font-weight: bold;">MyMuse</h1>
    <p>
      Welcome to my project!! Hope you enjoy it.<br>
      This is a memory game, you just need to remember and repeat the partern<br> <b>Note: Checklist could be found on
        "About us" page.
      </b></p>

  </div>
  <div id="MyMuseAboutusContent" class="hidden">
    <?php include './about-us.php'; ?>
  </div>
  <div id="MyMuseDashBoardContent" class="hidden">
    <?php include './dashboard.php'; ?>
  </div>
  </div>
  <div id="MyMuseGameContent">
    <div>
      <h3 id="timer">Press Start to begin</h3>
    </div>
    <div class="controlButton">
      <div class="center">
        <button id="startBtn" onclick="startGame()">
          Start
        </button>
        <button id="stopBtn" class="hidden" onclick="stopGame()">
          Stop
        </button>
      </div>
    </div>
    <div id="gameButtonArea">
      <button id="button1" onclick="guess(1)" onmousedown="startTone(1)" onmouseup="stopTone()"></button>
      <button id="button2" onclick="guess(2)" onmousedown="startTone(2)" onmouseup="stopTone()"></button>
      <button id="button3" onclick="guess(3)" onmousedown="startTone(3)" onmouseup="stopTone()"></button>
      <button id="button4" onclick="guess(4)" onmousedown="startTone(4)" onmouseup="stopTone()"></button>
      <button id="button5" onclick="guess(5)" onmousedown="startTone(5)" onmouseup="stopTone()"></button>
    </div>
  </div>
  </div>
</body>

</html>