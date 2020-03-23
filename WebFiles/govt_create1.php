<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
    <title>PUBLIC GOVERNMENT ELECTIONS</title>
    <link rel="icon" href="logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
		var type=$("#type").val();
		var state=$("#state").val();
		$.post("form_create.php",{type:type,state:state},
		function(data){
		  $("#json_response").html(data);
		});
  }
	</script>
<style>
#regForm {
  font-family: Raleway;}
#prevBtn,#nextBtn{border-radius: 0;}
  .parallax {
  color:white;
  background: url(2.png), rgba(0,0,0,0.8);
  min-height: 190px; 
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-blend-mode: multiply;
}
.parallax2 {
  color:white;
  background: url(1.jpg), rgba(0,0,0,0.85);
  min-height: 400px; 
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-blend-mode: multiply;
}
</style>
</head>
<body class="bodies text-center">
<div class="parallax">
 <marquee><h4 class="pt-5">It is easy to create Public Goverment Election Now!</h4></marquee>
</div>
<nav class="navbar navbar-expand-md border-bottom navbar-dark">
  <a class="navbar-brand" href="#"><img src="logo.png" width="100" height="100" class="mr-3"></a><span><div style="letter-spacing:3.5px" class="text-light">REMOTE POLLING INTERFACE</div> </span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="govt_result.php">ELECTION RESULTS</a>
    </li>
      <?php if(isset($_SESSION['bid'])){ ?>
      <li class="nav-item">
        <a class="nav-link" href="#" active>CREATE ELECTION</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">MODIFY ELECTION</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="form_logout.php">LOGOUT</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#"><?php echo $_SESSION['bid']; ?></a>
      </li>
        <?php }else{ ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">LOGIN</a>
      </li>
        <?php } ?>    
    </ul>
  </div> 
</nav><br>
<section class="container mb-5">
<div class="parallax2">
<div class="row">
  <div class="col-md-2 col-sm-0">
    
  </div>
  <div class="col-md-8 col-sm-0">
   
<form id="regForm" method="post">
<h2 class="h2 p-5 box4">Create Election:</h3>

<div class="form-group box1">
    <label for="date">Select Date range</label>
    <input type="text" name="datetimes" class="form-control" />
</div>
<script>
$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    showDropdowns:true,
    timePicker24Hour:true,
    timePickerSeconds: true,
    alwaysShowCalendars:true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'YYYY/MM/DD hh:mm:ss A'
    }
  });
});
</script>

    <div class="form-group box2">
      <label for="type">Select Type of Election:</label>
      <select class="form-control" id="type" name="type">
<?php

include 'Values.php';

$url=$web_host."/TypesAndStates.php";
$data = array('postAuthKey' =>$post_auth_key);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === 'FALSE') { echo "Sorry! an error occured. Please try again!"; }
$json_array=json_decode($response, true); 

    //echo json_encode($json_array);

    if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
    else if(!$json_array['success'])
        echo 'Technical Error!';
    else
    {
        display_types($json_array);
        /*display_states($json_array);*/
    }
    function display_states($json_rec){
		if($json_rec){
            
			foreach($json_rec as $key=> $value){
				if(is_array($value)){
					display_states($value);
				}else if($key=='code'){
					$code=$value;
				}
                else if($key=='name'){
					{echo '<option value="'.$code.'">'.$value.'&nbsp;-- ( <b>'.$code.'</b> )'.'</option>';}
				}	
			}	
		}	
	}
/*$json_rec['states']['0']['code']*/
function display_types($json_rec){
		if($json_rec){
			foreach($json_rec as $key=> $value){
				if(is_array($value)){
					display_types($value);
				}
                else if($key=='type'){
                   {echo '<option>'.$value.'</option>';}

				}	
			}	
		}}
?>
</select>
</div>
    <div class="form-group box3">
      <label for="state">Select States</label>
      <select class="form-control" id="state" name="state">
        <?php; display_states($json_array)?>
      </select>
    </div>
    <input type="button" class="btn btn-primary box3" value=">" id="checkbid" onclick="submit_soap();hide();"/><span id="availability"></span>
    <script>
    function hide(){
    var x = document.getElementById("checkbid");
    if (x.style.display === "none") {
    x.style.display = "block";} else {
    x.style.display = "none";}}
    </script> 
<div id="json_response"></div>
</form>





<!--<input type="submit" class="btn btn-dark" id="checkbid" onclick="window.location.href = 'home.php';" value="Proceed"/><span id="availability"></span>-->
</section><br><br>
<div class="py-2 text-center footer fixed-bottom text-light">Copyright 2019</div>
</body>
</html>