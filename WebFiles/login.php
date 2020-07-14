<?php
include './includes/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<body class="p-md-5 p-3 bodycolor">
<div id="screen">
<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
         <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="js/theme.js"></script>
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
<h4 class="h4 heading mt-3 box1">LOGIN TO YOUR BOOTH ACCOUNT</h4>

<div id="boothotpform">
  <form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group box2">
    <label for="booth_id">Enter Booth ID :</label>
    <input type="text" class="form-control rounded-pill navshadow" name="booth_id" id="booth_id" required />
  </div>
 <button type="submit" class="btn box3 submitbtn rounded-pill px-5 m-3" id="getboothotp">Get Otp</button>
 </form>
</div>

<div id="boothotp_response"></div>

<div id="boothloginform" style="display: none;">
<div class="alert alert-danger display-error" style="display: none"></div>
<form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group box1">
    <label for="booth_otp">Enter Login OTP :</label>
    <input type="text" class="form-control rounded-pill navshadow" name="booth_otp" id="booth_otp" required />
  </div>

  <button type="submit" id="submitboothlogin" class="btn box2 submitbtn rounded-pill px-5 m-3"> Login </button>
  <input type="button" class="btn box2 backbtn rounded-pill px-5 m-3" onclick="window.location.href = 'login.php';" value="Go Back"/>
</form>
<div id="login_response"></div>
</div>
</div>
</div>
<div class="col-md-3"></div>
</div>
</section>


<?php include './includes/footer.php'; ?>
</div>
</body>
<script type="text/javascript">

  $(document).ready(function() {
       $('#getboothotp').click(function(e){
       e.preventDefault();
       var booth_id = $("#booth_id").val();
       sessionStorage.setItem("boothID", booth_id);
       
       $.ajax({
            type: "POST",
            url: "form_getBoothOtp.php",
            dataType: "json",
            data: {booth_id:booth_id},
            success : function(data){
               $('#boothotp_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       showBoothLoginForm();
                       $('#boothotp_response').html('<div class="alert alert-success">An SMS has been sent to your registered mobile number with OTP.</div>'); 
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validBooth===false){
                        $(".display-error").html("Invalid Booth ID!");
                        $(".display-error").css("display","block");}
                     else{
                        $(".display-error").html("Technical Error!");
                        $(".display-error").css("display","block");}
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-error").html(errorThrown);
                $(".display-error").css("display","block");
                $('#boothotp_response').html("<b>Loading failed! Refresh and Try Again</b>"); 
                } 
        });
      });

        $('#submitboothlogin').click(function(e){
        e.preventDefault();        
        var booth_id=sessionStorage.getItem("boothID");
        var booth_otp = $("#booth_otp").val();
        $('#login_response').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "form_login.php",
            dataType: "json",
            data: {booth_id:booth_id, booth_otp:booth_otp},
            success : function(data){
               $('#login_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       localStorage.setItem("localboothID",booth_id); 
                       window.location.replace("instruct.php");
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validBooth===false){
                        $(".display-error").html("Invalid Booth ID!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validLogin===false){
                        $(".display-error").html("Booth already logged in!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.boothSuspended!='undefined' && data.msg.boothSuspended===true){
                        $(".display-error").html("Booth user is suspended!");
                        $(".display-error").css("display","block");}
                     else{
                        $(".display-error").html("Incorrect OTP!");
                        $(".display-error").css("display","block");}
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-error").html(errorThrown);
                $(".display-error").css("display","block");
                $('#login_response').html("<b>Loading failed! Click on 'Login' and Try Again</b>"); 
                } 
        });

      });
    
    var sessionbid=sessionStorage.getItem("boothID");
    var localbid=localStorage.getItem("localboothID");
    if ((typeof sessionbid == 'undefined' || sessionbid == null) && localbid!=null)calllogout();
    
function calllogout(){
     var booth_id = localStorage.getItem("localboothID");
        $.ajax({
            type: "POST",
            url: "form_logout.php",
            dataType: "json",
            data: {booth_id:booth_id},
            success : function(data){               
               if (data.code == "1"){
                     if(data.msg.success===true){
                       localStorage.removeItem("localboothID");
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
  });
  
function showBoothLoginForm(){
  document.getElementById('boothloginform').style.display='block';
  document.getElementById('boothotpform').style.display='none';
}
 
</script>

</html>









