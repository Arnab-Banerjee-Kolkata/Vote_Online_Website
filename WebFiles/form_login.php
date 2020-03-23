<?php
session_start();

include 'Values.php';

$booth_id=$_POST['booth_id'];
$otp=$_POST['otp'];

$url=$web_host."/ValidateBooth.php";
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
$json_array=json_decode($response, true); 

    //echo json_encode($json_array);

    if(!$json_array['validAuth'])
        echo 'Unauthorised access!';
    else if(!$json_array['validBooth'])
        echo 'Invalid Booth';
    else if(!$json_array['validLogin'])
        echo 'Only one login per booth is allowed at a time';
    else if(!$json_array['success'])
        echo 'Incorrect OTP';
    else
    {
        $_SESSION["bid"] =$booth_id;
       echo "<script>window.open('instruct.php', '_self')</script>";
 
    }

?>
