<?php
session_start();
include './includes/header.php'; 
?>
<script>
    function load_new_content(){
        var state=$("#state option:selected").val();
    $.post("showoverallresult.php",{id:id,type:type,year:year},
    function(data){
      $("#json_response").html(data);
    });
  }*/
</script>
<body class="p-md-5 p-3 bodycolor">
<div id="screen">

<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
        <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="js/theme.js"></script>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <i class='fas fa-bars navbtn btn'></i>
  </button>

  
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto mr-md-5">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class='fas fa-home'></i> HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="#"><i class='fas fa-chart-line'></i> ELECTION RESULTS</a>
      </li>
      <?php if(isset($_SESSION['bid'])){ ?>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <b><?php echo $_SESSION['bid']; ?></b>
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item btn rounded-pill navbtn" type="button" onclick="return calllogout();"><i class='fas fa-sign-out-alt'></i> LOGOUT</a><span id="logout_response"></span>
        <a class="dropdown-item btn rounded-pill navbtn" type="button" href="instruct.php"><i class='fas fa-info-circle'></i> Read Instructions</a>
      </div>
    </li>
      <?php }else{ ?>
       <li class="nav-item">
      <a type="button" class="btn rounded-pill navbtn px-3" href="login.php"><i class='fas fa-sign-in-alt'></i> LOGIN</a>
      </li>   
      <?php } ?>      
    </ul>
</div>
</nav>

<section class="mainframe">

<div class="row">
<div class="col-md-2"></div>

<div class="col-md-8 py-5">
<div class="text-center" style="min-height: 70vh;">

<h3 class="h3 box4 heading">STATEWISE LOK SABHA ELECTION RESULT</h3>
<form action="#" class="text-center" method="post">
      <select class="form-control mb-2 box1" id="state" name="state">
      <option value="-1">SELECT STATE</option>
<?php

include 'Values.php';
$url=$web_host."/ShowStateList.php";
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


    if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
    else if(!$json_array['success'])
        echo 'Technical Error!';
    else
    {
        display_states($json_array);
    }

    function display_states($json_rec){
    if($json_rec){
            
      foreach($json_rec as $key=> $value){
        if(is_array($value)){
          display_states($value);
        }else if($key=='name'){
          $name=$value;
        }
        else if($key=='code'){
          {echo '<option value="'.$value.'">'.$name.'&nbsp;-- ( <b>'.$value.'</b> )'.'</option>';}
        } 
      } 
    } 
  }

?>
</select>
<input type="submit" class="btn box3 submitbtn rounded-pill px-5 mx-3" value="View Result" name="submitstate">
</form><br>
<div id="json_response"></div>



<?php
if(isset($_POST['submitstate']))
{
$stateCode=$_POST['state'];

$currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentURL .= $_SERVER["SERVER_NAME"];
    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentURL .= ":".$_SERVER["SERVER_PORT"];
    } 
    $currentURL .= $_SERVER["REQUEST_URI"];
$url_components = parse_url($currentURL); 
parse_str($url_components['query'], $params); 
      
// Display result 
$id=$params['id'];
$type=$params['type'];
$year=$params['year'];  

echo'<ul class="nav nav-pills justify-content-center">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="pill" href="#overall">OVERALL TRENDS</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#constituency">CONSTITUENCY TRENDS</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane container active py-4" id="overall"><h3 class="heading">OVERALL TRENDS  ('.$stateCode.')</h3>';

}?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
<script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart','table']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Party Name', 'Seats Won','Party Symbol'],  

<?php
    
include 'Values.php';
$url=$web_host."/OverallElectionResult.php";
$data = array('postAuthKey' =>$post_auth_key, 'electionId' =>$id, 'type' =>$type, 'stateCode'=>$stateCode );
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

    if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
    else if(!$json_array['validType'])
        echo 'Invalid Election Type!';
    else if(!$json_array['validElection'])
        echo 'Result calculation has not started!';
    else if(!$json_array['success'])
        echo 'Technical Error!';    
    else
    {
        $totalSeats=$json_array['totalSeats'];
        $status=$json_array['status'];
        $totalWon= 0;
        display_party($json_array);
    }

    function display_party($json_rec){
    if($json_rec){      
      foreach($json_rec as $key=> $value){
        if(is_array($value)){
          display_party($value);}
        else if($key=='electionId'){
          $electionId=$value;}
        else if($key=='partyName'){
          $partyName=$value;}
        else if($key=='seatsWon'){
          global $totalWon;
          $seatsWon=$value;
          $totalWon = $totalWon+$seatsWon;}
        else if($key=='partySymbol'){
          $partySymbol=$value;
          echo "['".$partyName."',".$seatsWon.",'<img src=\'".$partySymbol."\' width=\'100px\'/>'],";
        }
      } 
    } 
  }
?>
]);  
                var piechart_options = {  
                      title:'<?php echo $totalWon.'/'.$totalSeats?>',titleTextStyle: {color: '#6b51e1', fontSize: 20},
                      colors: ['#99ff33', '#ffff66', '#00cc99', '#ff9900', '#f6c7b6'], 
                      backgroundColor:'transparent',
                      legend:{position: 'bottom', textStyle: {color: '#6b51e1', fontSize: 20}},
                      pieSliceBorderColor:'#8C78E8',
                      pieSliceTextStyle:{color:'black'},
                      //is3D:true,  
                      pieHole: 0.4  
                     };  
                var piechart = new google.visualization.PieChart(document.getElementById('piechart'));  
                piechart.draw(data, piechart_options);  
          
           

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: false,allowHtml:true,width: '100%', height: '100%',color:'red'});
      }
     
      
</script> 
<div class="row">
<div class="col-sm-6">
<div id="piechart" style="width:100%; height: 500px;"></div> 
</div>
<div class="col-sm-6">
<div id="table_div" style="color:black;"></div>
</div>
</div>
<div style="position:absolute;bottom:50vh;font-size:20px;color:red;">
<?php 
if(!$stateCode)
    echo 'Please select a state!';
else if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
else if(!$json_array['validType'])
        echo 'Invalid Election Type!';
else if(!$json_array['validElection'])
        echo 'invalid election Id or Result calculation has not started!';
else if(!$json_array['success'])
        echo 'Technical Error!';  
?>
</div>

  </div>
  <div class="tab-pane container fade py-4" id="constituency"><h3 class="heading">CONSTITUENCY TRENDS (<?php  echo $stateCode;?>)</h3>
  
<?php

$url=$web_host."/ConstituencyWiseResult.php";
$data = array('postAuthKey' =>$post_auth_key, 'electionId' =>$id, 'type' =>$type, 'stateCode'=>$stateCode );
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

    if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
    else if(!$json_array['validType'])
        echo 'Invalid Election Type!';
    else if(!$json_array['validState'])
        echo 'Invalid State Code!';
    else if(!$json_array['validElection'])
        echo 'invalid election Id or Result calculation has not started!';
    else if(!$json_array['success'])
        echo 'Technical Error!';    
    else
    { 
        $status=$json_array['status'];
        echo '<table class="table table-bordered text-info">
    <thead>
      <tr>
        <th class="heading">Constituency</th>
        <th class="heading">Won By</th>
      </tr>
    </thead>
  </table>';
        display_cons($json_array);
    }

    function display_cons($json_rec){
    if($json_rec){      
      foreach($json_rec as $key=> $value){
        if(is_array($value)){
          display_cons($value);}
        else if($key=='constituencyName'){
          $constituencyName=$value;}
        else if($key=='candidateName'){
          $candidateName=$value;}
        else if($key=='partyName'){
          $partyName=$value;}
        else if($key=='partySymbol'){
          $partySymbol=$value;}
        else if($key=='voteCount'){
          $voteCount=$value;
          echo $stateCode;
          echo '<div class="text-center my-3 border">
    <div class="row m-0 p-0">
    <div class="col-sm-5 bg-info"> <h5 class="py-3">'.$constituencyName.'<br>'.$stateCode.'</h5></div>
    <div class="col-sm-7"> <h5 class="py-3">'.$candidateName.'<br>'.$partyName.'<br>
      Votes:'.$voteCount.'</h5></div>
    </div>
  </div>';
        }
      } 
    } 
  }
  
?>
 
               



  </div>
</div>


    
  


</div>
</div>
<div class="col-md-2"></div>
</div>
</section>
<?php include './includes/footer.php'; ?>
</div>
<?php include './includes/scripts.php'; ?>

</body>
</html>