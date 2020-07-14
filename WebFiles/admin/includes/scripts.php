<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-latest.js"></script>-->
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>
function checklogout(){
    var localaid=sessionStorage.getItem("adminID");
    //alert(localaid);
    if (typeof localaid == 'undefined' || localaid == null)
    window.location.href="adminlogin.php";
}

function calllogout(){
     var admin_id = sessionStorage.getItem("adminID");
        $.ajax({
            type: "POST",
            url: "form_adminlogout.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){               
               if (data.code ===11){
                     if(data.msg.success===true){
                       sessionStorage.clear();
                       localStorage.removeItem("localadminID");
                       alert("You are logged out! Login again to continue.");
                       var url = "adminlogin.php";    
                       $(location).attr('href',url);
                     }
                     else if(data.msg.validAuth===false){
                        alert("Unauthorised access!");
                        }
                     else if(data.msg.validAdmin===false){
                        alert("Incorrect Admin ID or already logged out!");
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
checklogout();

$('#logoutbtn').click(function(e){
        e.preventDefault();
        return calllogout();
      });
  
            /* Increment the idle time counter every second */ 
            let idleInterval =setInterval(timerIncrement, 60000); 
  
            /* Zero the idle timer 
                on mouse movement */ 
            $(this).mousemove(resetTimer); 
            $(this).keypress(resetTimer); 
            $(this).scroll(resetTimer); 
        }); 
  
        function resetTimer() { 
  
            /* Hide the timer text */ 
            document.querySelector(".timertext").style.display = 'none';               
            currSeconds = 0; 
        } 
  
        function timerIncrement() { 
            currSeconds = currSeconds + 1; 
            if(currSeconds>=20)calllogout();

            if(currSeconds>=10){
            /* Set the timer text to the new value */ 
            document.querySelector(".secs").textContent = currSeconds; 
  
            /* Display the timer text */ 
            document.querySelector(".timertext").style.display = 'block'; 
            }
        } 
    

</script>