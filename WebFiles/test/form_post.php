<?php
session_start();
$booth_id=$_POST['booth_id'];
$otp=$_POST['otp'];
$url = 'http://www.remote-voting.rf.gd/ValidateBooth.php';
include 'Values.php';
$data = array('booth_id'=>$booth_id,'otp' => $otp,'postAuthKey' =>$post_auth_key);
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
$json_array=json_decode($response); 
 
// Loop through the associative array
foreach($json_array as $key=>$value){
    if($key=='success' && $value!=1){echo "Incorrect OTP. Resend OTP.";break;}
    elseif($key=='validAuth' && $value!=1) {echo "Unauthorised access!";break;}
    elseif($key=='validStatus' && $value!=1){echo "Already Voted!";break;}
    else{
       echo "successful!";
    }
}


?>