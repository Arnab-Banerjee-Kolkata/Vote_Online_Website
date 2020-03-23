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
		<h4 class="text">Please read the following instructions carefully before proceeding:</h4>
		<ul class="text1">
			<li>On clicking the 'Proceed' button you will be required to enter the Voter's Adhaar no and Voter's OTP that has been sent to the voter's application.</li>
            <li>After successful OTP verification, verify voter's photograph with the one generated on screen.</li>
			<li>Then get the unique Booth otp for the particular voter and click on 'Finish' after sharing it.</li>
			<li>Before doing so, please make sure that voter's OTP remains secret between you and the voter in order to avoid any illegal interference with the process of the election.</li>
			<li>Also keep the booth otp secret between you two. For these, having a separate room with only one voter and the agent at a time is preferred.</li>
			<li>If you find that the otp secrecy is hampered, you can regenerate it if the voter has not yet used it.</li>
			<li>If any problem arises, report to <a href='mailto:<nowiki>remotevoting@gmail.com?subject="Report for election"'>remotevoting@gmail.com</a> or call us at<a href="tel:5554280940"> 555-428-0940</a> in emergency.</li>
		</ul>
		<form class="text2" method="post" action="home.php">
		<div class="form-group form-check">
      	<label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember" required> I have read and agree to the <a href="#">Terms and conditions </a>.
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Check this checkbox to continue.</div>
      </label>
    	</div>

        <input type="submit" class="btn btn-dark" id="checkbid" onclick="window.location.href = 'home.php';" value="Proceed"/><span id="availability"></span>
    	<button class="btn btn-dark" onclick="window.location.href = 'index.php';">Go Back</button>
		</form>

	</div>
	<div class="col-md-4">
		<img src="vote.jpg" width="100%" class="border p-3 pic mb-5">
	</div>
</div>
<div class="py-2 fixed-bottom text-center footer">Copyright 2019</div>
</section>
</body>
</html>
