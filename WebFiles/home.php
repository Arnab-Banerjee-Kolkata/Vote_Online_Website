<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
    <title>REMOTE POLLING INTERFACE</title>
    <link rel="icon" href="logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
$(document).ready(function(){
  $("#checkbid").click(function(){
    var checkbid=$(this).val();
$.ajax({
url: "chk_session.php",
method: "POST",
data:{checkbid:checkbid},
dataType:"text",
success: function(html){
$('#availability').html(html);
}
});
});
});
    </script>
        <script>
	  function submit_soap(){
		var aadharNo=$("#aadharNo").val();
		var otp=$("#otp").val();
        var electionId=$("#electionId").val();
		$.post("form_post.php",{aadharNo:aadharNo,otp:otp,electionId:electionId},
		function(data){
		  $("#json_response").html(data);
		});
	}
	</script>
    

</head>
<body class="text-light bodies">

<nav class="navbar navbar-expand-md border-bottom navbar-dark">
  <a class="navbar-brand" href="#"><img src="logo.png" width="100" height="100" class="mr-3"></a><span><div style="letter-spacing:3.5px">REMOTE POLLING INTERFACE</div> </span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link disabled"><?php echo $_SESSION['bid']; ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
      <?php if(isset($_SESSION['bid'])){ ?>
  <a class="nav-link" href="form_logout.php">LOGOUT</a>
<?php }else{ ?>
  <a class="nav-link" href="login.php">LOGIN</a>
<?php } ?>
        
      </li>    
    </ul>
  </div> 
</nav><br>
<section class="container-fluid">
<div class="row">
  <div class="col-md-8 p-3">


  <form class="p-5" method="post">
  <div class="form-group box1">
    <label for="boothid">Booth ID :</label>
    <b><?php echo $_SESSION['bid']; ?></b>
  </div>
  <div class="form-group box2">
    <label for="aadharNo">Enter Voter's Adhaar No :</label>
    <input type="text" class="form-control" name="aadharNo" id="aadharNo" required>
  </div>
  <div class="form-group box2">
    <label for="otp">Enter Voter OTP :</label>
    <input type="text" class="form-control" name="otp" id="otp" required>
  </div>
  <div class="form-group box2">
    <label for="electionId">Enter Election ID :</label>
    <input type="text" class="form-control" name="electionId" id="electionId" required>
  </div>
   <input type="button" class="btn btn-primary box3" value="Submit" id="checkbid" onclick="submit_soap()"/><span id="availability"></span>
   <input type="button" class="btn btn-dark box3" onclick="window.location.href = 'instruct.php';" value="Go Back"/>
</form>

<div id="json_response" class="pl-5 text-danger"></div>



  </div>
  <div class="col-md-4">
    <img src="voting.jpg" width="100%" class="border p-3 box4 mb-5">
  </div>
</div>
<div class="py-2 fixed-bottom text-center footer">Copyright 2019</div>
</section>

</body>
</html>
