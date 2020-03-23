<?php
session_start();
$type=$_POST['type'];
$stateCode=$_POST['state'];
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


 function submit_soap(){
        var datetime=$("#datetimes").val();
        var type="<?php echo $type; ?>";
        var stateCode= "<?php echo $stateCode; ?>";
        var phaseCode=$("#phase").val();
        var res = datetime.split(" ");
        var startDate=res[0];
        var startTime=res[1];
        var endDate=res[3];
        var endTime=res[4];
        alert(res[0] +" "+ res[1]+" " + res[3]+" " + res[4]+" "+ phaseCode+" " + type+" "+stateCode);
        $.post("form_create2.php",{type:type,stateCode:stateCode,phaseCode:phaseCode,startDate:startDate,startTime:startTime,endDate:endDate,endTime:endTime},
		function(data){
		  $("#json_response").html(data);
		});
	}
    
</script>
<style>
#regForm fieldset:not(:first-of-type) {
    display: none;
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
 <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar"
  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>
</div>

<?php /* echo $type;
echo $stateCode;*/ ?>

<form action="form_create1.php" id="regForm" method="post">

<h2 class="h2 p-5 box4">Create Election:</h3>


<h2 class="box4">Step 2</h2>
    
<div class="form-group box1">
<label for="datetimes">Select Date range</label>
<input type="text" name="datetimes" class="form-control" id="datetimes" />
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
      format: 'YYYY/MM/DD HH:mm:ss'
    }
  });
});
</script>

<?php
include 'Values.php';
$url=$web_host."/GetPhase.php";
$data = array('postAuthKey' =>$post_auth_key,'type' =>$type,'stateCode'=>$stateCode);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
if ($response === 'FALSE') {echo '<div class="alert alert-danger mt-3"><strong>Sorry! an error occured. Please try again!</strong></div>';}
else{
 echo '<div class="form-group box2" id="sphase">
  <label for="phase">Select phase:</label>
  <select class="form-control" id="phase">';
}
echo '<script>
function myFunction() {
  var x = document.getElementById("sphase");
    x.style.display = "none";
}
</script>';
$json_array=json_decode($response, true); 

    if(!$json_array['validAuth']){
        echo '<script>myFunction();</script>';
        echo '</select></div>';
        echo '<div class="alert alert-danger mt-3"><strong>Unauthorised access!</strong></div>';}
    else if(!$json_array['validCombination']){
        echo '<script>myFunction();</script>';
        echo '</select></div>';
        echo'<div class="alert alert-danger mt-3"><strong>Invalid combination!</strong><a href="govt_create.php" class="alert-link">Try again</a></div>';
       }
    else if(!$json_array['success']){
        echo '<script>myFunction();</script>';
        echo '</select></div>';
        echo '<div class="alert alert-danger mt-3"><strong>Technical Issue!</strong></div>';
       }
    else{
        display_phases($json_array); 
        echo '</select></div>';  
    }
    function display_phases($json_rec){
		if($json_rec){
			foreach($json_rec as $key=> $value){
				if(is_array($value)){
					display_phases($value);
				}else if($key=='type'){ 
					$type=$value;
				}
                else if($key=='code'){
                    echo '<option value="'.$value.'">'.$type.'&nbsp;-- ( <b>'.$value.'</b> )'.'</option>';
                    }
				
			}	
		}	
	}
    
    
?>

<input type="button" name="previous" class="previous btn btn-default box3" value="Previous" style="float:left" />
<input type="button" class="btn btn-primary box3" value="Submit" id="checkbid" onclick="submit_soap();" style="float:right"/><span id="availability"></span>
</form><br>
<div id="json_response"></div>
</section><br><br>
<div class="py-2 text-center footer fixed-bottom text-light">Copyright 2019</div>
</body>
</html>
