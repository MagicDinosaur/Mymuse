// global constants
var clueHoldTime = 700; 
const cluePauseTime = 333; 
const nextClueWaitTime = 1000;
const progressBar = document.querySelector(".progress-bar");
//global varible
var showAboutUsStatus = false;
var parternLength = 999;
var pattern = []
var progress = 0;
var gamePlaying = false;
var tonePlaying = false;
var volume = 0.6;
var guessCounter = 0;
var strikeCounter = 0;
var myVar = setInterval(Timer, 1000);
var ShowSignOutButton = false;


var script = document.createElement('script');
script.src = 'scripts/jquery-3.6.0.js';
document.getElementsByTagName('head')[0].appendChild(script);

clearInterval(myVar);
var time = 20; 
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

var value = getCookie("user_id");
if(value == undefined){
  document.getElementById("navibutton1").classList.remove("hidden");
  document.getElementById("navibutton2").classList.add("hidden");
}else{
  document.getElementById("navibutton1").classList.add("hidden");
  document.getElementById("navibutton2").classList.remove("hidden");

}
function SignIn(){
  window.location.href = "login.php";
}
function SignOut(){
  document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.cookie = "user_name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.getElementById("navibutton1").classList.remove("hidden");
  document.getElementById("navibutton2").classList.add("hidden");
  location.reload();
  alert("Sign Out");
}
function SignOut_(){
  document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.cookie = "user_name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  window.location.href = "index.php";
  alert("Sign Out");
}

function Timer(){
  let timeRemain = Math.floor(time + clueHoldTime/1000)
  document.getElementById("timer").innerHTML ="Time remain: " + timeRemain +"s";
  time =timeRemain -1;
}
var check;
function showAboutus(){
  // stopGame();
  if(showAboutUsStatus){
  document.getElementById("MyMuseGameContent").classList.add("hidden");
  document.getElementById("MyMuseDashBoardContent").classList.add("hidden");
  document.getElementById("MyMuseAboutusContent").classList.remove("hidden");
  showAboutUsStatus = false;
}else{
  document.getElementById("MyMuseAboutusContent").classList.add("hidden");
  document.getElementById("MyMuseDashBoardContent").classList.add("hidden");
  document.getElementById("MyMuseGameContent").classList.remove("hidden");
  showAboutUsStatus = true;
}
}
function showAccount(){
    var  user =getCookie("user_id");
    if(user == undefined){
      alert("Please sign in first");
    }else{
      window.location.href = "account-info.php";
    }


}
function showDashboard(){
  // stopGame();
  if(showAboutUsStatus){
  document.getElementById("MyMuseGameContent").classList.add("hidden");
  document.getElementById("MyMuseDashBoardContent").classList.add("hidden");
  document.getElementById("MyMuseDashBoardContent").classList.remove("hidden");
  showAboutUsStatus = false;
}else{
  document.getElementById("MyMuseDashBoardContent").classList.add("hidden");
  document.getElementById("MyMuseAboutusContent").classList.add("hidden");
  document.getElementById("MyMuseGameContent").classList.remove("hidden");
  showAboutUsStatus = true;
}

}
function timeOut(){
  if(time<=0){
    console.log("Time Out");
    alert("Time Out")
    stopGame();
    location.reload();
    clearInterval(check);
  }
}

function startGame(){
    //initialize game variables
    strikeCounter = 0;
    check = setInterval(timeOut,1);
    progress = 0;
    gamePlaying = true;
    generatePattern();
    // console.log("Partern generated is "+ pattern);
  // swap the Start and Stop buttons
    document.getElementById("startBtn").classList.add("hidden");
    document.getElementById("stopBtn").classList.remove("hidden");
    playClueSequence();
    myVar = setInterval(Timer, 1000);
}

function insertScore()
{
  $.ajax({
    type: "POST",
    url: 'send_score.php',
    data: {score: progress},
    success:function(data) {
    alert("Score sent"); 
  
     }
});
}
function stopGame(){
  
  gamePlaying = false;
  document.getElementById("timer").innerHTML ="Press Start to begin";
  clearInterval(myVar);

  document.getElementById("startBtn").classList.remove("hidden");
  document.getElementById("stopBtn").classList.add("hidden");



  $user = getCookie("user_id");
  if ($user != undefined) {
  insertScore();
}}

function lightButton(btn){
  document.getElementById("button"+btn).classList.add("lit")
}
function clearButton(btn){
  document.getElementById("button"+btn).classList.remove("lit")
}
function playSingleClue(btn){
  

  if(gamePlaying){
    lightButton(btn);
    playTone(btn,clueHoldTime);

    setTimeout(clearButton,clueHoldTime,btn);
  }
}

function playClueSequence(){

  guessCounter = 0;
  let delay = nextClueWaitTime; //
  for(let i=0;i<=progress;i++){ // 
    setTimeout(playSingleClue,delay,pattern[i])
    // set a timeout to play that clue
    delay += clueHoldTime 
    delay += cluePauseTime;
    var clueHoldTime_new = clueHoldTime-clueHoldTime*0.1
    clueHoldTime = Math.max(clueHoldTime_new,500)
    time = 20
    
  }

}
function loseGame(){
  stopGame();
  
  alert("Gameover!!Your score is " + progress);
  // alert("Game Over. You lost.");
}
function winGame(){
  stopGame();
  alert("Game Over. You won!.");
}
function loseStrike(){
  alert("Oops! That's wrong, you have "+ (3-strikeCounter)+ " strike left!");
}
function guess(btn){
  console.log("user guessed: " + btn);
  if(!gamePlaying){
    clearInterval(myVar);
    return;
  }

  if(pattern[guessCounter] == btn){
    if(guessCounter == progress){
      if(progress == pattern.length - 1){
        winGame();
      }else{
        progress++;
        playClueSequence();
      }
    }else{
      guessCounter++;
    }
  }else{
    if(strikeCounter==2){
      loseGame();
    }else{
     strikeCounter +=1 
     loseStrike();
     clueHoldTime = clueHoldTime+clueHoldTime*(0.2)
     console.log(clueHoldTime);
     playClueSequence();
     
    }
    
  }
}
function generatePattern(){
  pattern =[]
  for(let i = 0; i<parternLength; i++) {
    var min = 1;
    var max = 5;
    pattern.push(Math.floor(Math.random() * (max - min + 1) + min))}
}
// Sound Synthesis Functions
const freqMap = {
  1: 261.6,
  2: 329.6,
  3: 392,
  4: 466.2,
  5: 520
}

function playTone(btn,len){ 
 document.getElementById("buttonsound"+btn).play();
  tonePlaying = true
    setTimeout(function(){
    stopTone()
  },len)
}
function startTone(btn){
  if(!tonePlaying){
    document.getElementById("buttonsound"+btn).play();
    tonePlaying = true

  }
}
function stopTone(){
  g.gain.setTargetAtTime(0,context.currentTime + 0.05,0.025)
  tonePlaying = false
}

// Page Initialization
// Init Sound Synthesizer
var AudioContext = window.AudioContext || window.webkitAudioContext 
var context = new AudioContext()
var o = context.createOscillator()
var g = context.createGain()
g.connect(context.destination)
g.gain.setValueAtTime(0,context.currentTime)
o.connect(g)
o.start(0)