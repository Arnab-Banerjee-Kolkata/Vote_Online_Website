<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>
function checklogout(){
    var localbid=sessionStorage.getItem("boothID");
    //alert(localaid);
    if (typeof localbid == 'undefined' || localbid == null)
    window.location.href="login.php";
}

function calllogout(){
     var booth_id = sessionStorage.getItem("boothID");
        $.ajax({
            type: "POST",
            url: "form_logout.php",
            dataType: "json",
            data: {booth_id:booth_id},
            success : function(data){            
               if (data.code ===11){
                     if(data.msg.success===true){
                       sessionStorage.clear();
                       localStorage.removeItem("localboothID");
                       alert("You are logged out!");
                       var url = "login.php";    
                       $(location).attr('href',url);
                     }
                     else if(data.msg.validAuth===false){
                        alert("Unauthorised access!");
                        }
                     else if(data.msg.validBooth===false){
                        alert("Incorrect Booth ID or already logged out!");
                       }
                     else{
                        alert("Something went wrong!");
                        }
                } else {
                    alert(data.msg);
                } 
            }
        });
    return false;
     }
var currSeconds = 0;    

$(document).ready(function() { 

$('#logoutbtn').click(function(e){
        e.preventDefault();
        return calllogout();
      });
var sessionBID=sessionStorage.getItem("boothID");  
if(sessionBID)
{
            /* Increment the idle time counter every second */ 
            let idleInterval =setInterval(timerIncrement, 60000); 
  
            /* Zero the idle timer 
                on mouse movement */ 
            $(this).mousemove(resetTimer); 
            $(this).keypress(resetTimer); 
            $(this).scroll(resetTimer); 
}            
}); 
  
function resetTimer() { 
document.querySelector(".timertext").style.display = 'none';               
currSeconds = 0; } 
  
function timerIncrement() { 
    currSeconds = currSeconds + 1; 
    if(currSeconds>=30)calllogout();

    /* Set the timer text to the new value */
    if(currSeconds>=10)
    document.querySelector(".secs").textContent = currSeconds; 
  
    /* Display the timer text */ 
    document.querySelector(".timertext").style.display = 'block'; 
        }    
  
</script>