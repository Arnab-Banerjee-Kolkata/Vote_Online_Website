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
		var aadhaarNo="<?php echo $_SESSION['aNo']; ?>";
        var electionId= "<?php echo $_SESSION['eid']; ?>";
		$.post("form_verify.php",{aadhaarNo:aadhaarNo,electionId:electionId},
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
  <div class="col-md-4"></div>
  <div class="col-md-4 mx-auto">
        <div class="card text-dark text-center box4" style="width:100%">
  <img class="card-img-top" src="voting.jpg" alt="Card image" style="width:100%">
  <div class="card-body">
    <h4 class="card-title">Aadhaar No:<?php echo $_SESSION['aNo'];?><br>Election ID:<?php echo $_SESSION['eid'];?></h4>
  </div>
</div>
<form action="confirm.php" class="p-3 mb-5">
   <input type="button"  style="width: 40%" class="btn btn-success box1 mx-2" id="checkbid" value="Verified" onclick="submit_soap()"/><span id="availability"></span>
   <input type="button" style="width: 40%" class="btn btn-danger box2 mx-2" value="Cancel" name="cancel" onclick="redirect()"/>
</form>
<script>
function redirect(){
        <?php $_SESSION['eid']=-1;?>
        window.location="home.php";
    }
</script>
<div id="json_response" class="pl-5 text-danger"></div><br>
  </div>
  <div class="col-md-4"></div>
</div>

<div class="py-2 fixed-bottom text-center footer">Copyright 2019</div>
</section>
</body>
</html>