var DisplayRegisterStatus = false;

function DisplayRegister() {

        document.getElementById("MyLoginForm").classList.add("hidden");
        document.getElementById("MyRegisterForm").classList.remove("hidden");
   

}


function DisplayLogin(){
    document.getElementById("MyLoginForm").classList.remove("hidden");
    document.getElementById("MyRegisterForm").classList.add("hidden");
}

