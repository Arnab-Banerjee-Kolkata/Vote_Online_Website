<?php
session_start();
$type=$_POST['type'];
$stateCode=$_POST['stateCode'];
$phaseCode=$_POST['phaseCode'];
$startTime=$_POST['startTime'];
$startDate=$_POST['startDate'];
$endTime=$_POST['endTime'];
$endDate=$_POST['endDate'];
include 'Values.php';
$url=$web_host."/CreatePubGovtElection.php";
$data = array('postAuthKey' =>$post_auth_key,'stateCode'=>$stateCode,'phaseCode'=>$phaseCode,'type' =>$type,'startTime' =>$startTime,'startDate'=>$startDate,'endTime'=>$endTime,'endDate'=>$endDate);
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
        echo'<div class="alert alert-danger mt-4"><strong>Unauthorised access!</strong></div>';
    else if(!$json_array['validTime'])
        echo'<div class="alert alert-danger mt-4"><strong>Time is invalid!</strong></div>';
    else if(!$json_array['success'])
         echo'<div class="alert alert-danger mt-4"><strong>Something went wrong!</strong></div>';
    else{
        echo'<div class="alert alert-success mt-3">
    <strong>Your Election is created successfully!</strong> Your Election id is'." ".$json_array['electionId'].'! You can now modify your election <a href="modify.php" class="alert-link">here</a>.</div>';
    }
    
    
?>