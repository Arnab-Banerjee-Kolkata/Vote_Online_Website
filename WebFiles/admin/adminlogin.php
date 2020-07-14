<?php
session_start();
include 'includes/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<body class="p-md-5 p-3 bodycolor">
<div id="screen">
<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
         <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="../css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="../css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="../js/theme.js"></script>
    <ul class="navbar-nav ml-auto">
       
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
    </ul>
</nav>
 
<section class="mainframe p-md-5 p-3">
<div class="row">
<div class="col-md-3"></div>
  <div class="col-md-6 py-5">
  <div class="text-center surfacestyle pb-5 pt-3">

<h4 class="h4 heading mt-3 box1">LOGIN AS ADMIN</h4>

<div id="adminotpform">
  <form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group box2">
    <label for="admin_id">Enter Admin ID :</label>
    <input type="text" class="form-control rounded-pill navshadow" name="admin_id" id="admin_id" required />
  </div>
 <button type="submit" class="btn box3 submitbtn rounded-pill px-5 m-3" id="getotp">Get Otp</button>
 </form>
</div>

<div id="adminotp_response"></div>

<div id="adminloginform" style="display: none;">
<div class="alert alert-danger display-error" style="display: none"></div>
<form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group box1">
    <label for="admin_otp">Enter Login OTP :</label>
    <input type="text" class="form-control rounded-pill navshadow" name="admin_otp" id="admin_otp" required />
  </div>

  <button type="submit" id="submitlogin" class="btn box2 submitbtn rounded-pill px-5 m-3"> Login </button>
  <input type="button" class="btn box2 backbtn rounded-pill px-5 m-3" onclick="window.location.href = 'adminlogin.php';" value="Go Back"/>
</form>
<div id="login_response"></div>
</div>


</div>
</div>
<div class="col-md-3"></div>
</div>
</section>


<?php include '../includes/footer.php'; ?>
</div>
</body>
<script type="text/javascript">

  $(document).ready(function() {
    var sessionaid=sessionStorage.getItem("adminID");
    var localaid=localStorage.getItem("localadminID");
    if ((typeof sessionaid == 'undefined' || sessionaid == null) && localaid!=null)calllogout();


      $('#getotp').click(function(e){
        e.preventDefault();

       var admin_id = $("#admin_id").val();
       sessionStorage.setItem("tempadminID", admin_id);
       showAdminLoginForm();

      });

       $('#submitlogin').click(function(e){
        e.preventDefault();

        var admin_id=sessionStorage.getItem("tempadminID");
        var admin_otp = $("#admin_otp").val();
        $('#login_response').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "form_adminlogin.php",
            dataType: "json",
            data: {admin_id:admin_id, admin_otp:admin_otp},
            success : function(data){
               $('#login_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       sessionStorage.setItem("adminID", admin_id);
                       localStorage.setItem("localadminID",admin_id); 
                       var url = "index.php";    
                       $(location).attr('href',url);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validOtp===false){
                        $(".display-error").html("Invalid OTP!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.adminSuspended===true){
                        $(".display-error").html("Admin is suspended!");
                        $(".display-error").css("display","block");}
                     else{
                        $(".display-error").html("Incorrect OTP!");
                        $(".display-error").css("display","block");}
                } else{
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-error").html("Something Went Wrong!");
                $(".display-error").css("display","block");
                $('#login_response').html("<b>Loading failed! Click on 'Login' and Try Again</b><br>Response:"+data.msg.success+'<br>'+data.msg.validAuth+'<br>'+data.msg.validOtp+'<br>'+data.msg.adminSuspended); 
                //console.warn(xhr.responseText);
                } 
        });

      });

});    
function calllogout(){
     var admin_id = localStorage.getItem("localadminID");
        $.ajax({
            type: "POST",
            url: "form_adminlogout.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){               
               if (data.code === 11){
                     if(data.msg.success===true){
                      // sessionStorage.removeItem("adminID");
                       localStorage.removeItem("localadminID");
                     }
                     else if(data.msg.validAuth===false)
                     {
                        alert("Unauthorised access!");
                     }
                     else if(data.msg.validAdmin===false){
                        alert("Incorrect Admin ID or already logged out!");
                       }
                     else{
                        alert("Something went wrong!");
                        }
                } else 
                {
                    alert(data.msg);    
                } 
            }
        });
    return false;
     }
  
  
/*function getAdminOtp(){
    //checklogout();
    var admin_id=document.getElementById('admin_id').value;
    //alert(otp);
   /* $.ajax({
            type:"post",
            url:"form_getadminotp.php",
            data: 
            {  
               'admin_id' :admin_id,
            },
            cache:false,
            success: function (html) 
            {
               alert(admin_id);
               showAdminLoginForm();
               $('#adminotp_response').html(html);
               localStorage.setItem("adminID", admin_id);
            }
            });*/
           /* localStorage.setItem("adminID", admin_id);
            showAdminLoginForm();
            return false;
     }*/
function showAdminLoginForm(){
  document.getElementById('adminloginform').style.display='block';
  document.getElementById('adminotpform').style.display='none';
}
 
</script>
</html>
