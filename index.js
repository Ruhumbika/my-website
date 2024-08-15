//registration

const reg_email= document.getElementById("uemail");
const reg_password=document.getElementById("upassword");
const email_structure=/^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
function go(){
    var a = document.getElementById("error5");
     if(reg_password<10 && reg_email!=email_structure){
             a.style.display="block";
     }
}