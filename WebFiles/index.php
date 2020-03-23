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
url: "chk_home.php",
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

<body class="text-light container-fluid inbody" style="background-image:url('3.jpg');">
<nav class="navbar navbar-expand-md border-bottom navbar-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="govt_result.php">Public Government Elections</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="nongovt_home.php">Public Non-Government Elections</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled"><?php echo $_SESSION['bid']; ?></a>
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
 
<section class="text-center">
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4"><img src="logo.png" width="60%" class="pt-5"><br></div>
	<div class="col-md-4"></div>
</div>



<h2 class="title h2"><span id="a">REMOTE</span><span id="b"> POLLING</span><span id="c"> INTERFACE</span></h2><br>
<h3 class="heading-primary--main"><i>" No voter to be left behind "</i></h3><br>
<input type="button" class="btn btn-outline-light btn-lg mt-2 proc" style="border-radius:0;" value="Proceed" id="checkbid"/><span id="availability"></span>
<br><br><br>


<div class="py-2 fixed-bottom" style="background: black">&copy; Copyright Reserved</div>
</section>


</body>
</html>
