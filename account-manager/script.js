
function showLastestScoresTable(){
    console.log("showLastestScoresTable");

    document.getElementById("highestTable").classList.add("hidden");
    document.getElementById("lastestTable").classList.remove("hidden");
}

function showHighestScoresTable(){
    document.getElementById("highestTable").classList.remove("hidden");
    document.getElementById("lastestTable").classList.add("hidden");
    console.log("showHighestScoresTable");
}


var canvas=document.getElementById("canvas");
var ctx=canvas.getContext("2d");

var cw=canvas.width;
var ch=canvas.height;
var maxW=128;
var maxH=128;

var input = document.getElementById('input111');
// var output = document.getElementById('file_output');
var output;
input.addEventListener('change', handleFiles);
function handleFiles(e) {
  var img = new Image;
  img.onload = function() {
    var iw=img.width;
    var ih=img.height;
    var scale=Math.min((maxW/iw),(maxH/ih));
    var iwScaled=iw*scale;
    var ihScaled=ih*scale;
    canvas.width=iwScaled;
    canvas.height=ihScaled;
    // ctx.fillStyle = "white";
     
    ctx.drawImage(img,0,0,iwScaled,ihScaled);


output = canvas.toDataURL("image/webp",0.7);
    console.log( output);
    sendImg();
  }
  img.src = URL.createObjectURL(e.target.files[0]);
    // sendImg();

}

function sendImg(){
    console.log(output);
    $.ajax({
        type: "POST",
        url: './account-manager/update-image.php',
        // dataType:'json',
        data: {img: output},
        success:function(data) {
            console.log(data);
            console.log(output);
            alert("Avatar sent");
            location.reload();
        }
    });




}
// if (output != undefined) {
//     sendImg();
// }