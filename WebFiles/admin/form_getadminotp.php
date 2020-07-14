<?php
session_start();

$admin_id=$_POST['admin_id'];

include '../Values.php';
$url=$web_host."/SendAdminOtp.php";

$data = array('postAuthKey' =>$post_auth_key,'adminId'=>$admin_id);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
 
if ($response === 'FALSE' or $response==NULL) { echo "Sorry! an error occured. Please try again!"; }
$json_array=json_decode($response, true); 
//echo $response;

    if($json_array['success']){
       echo '<div class="alert alert-success">An SMS has been sent to your registered mobile number with OTP.</div>';
    }
    else if(!$json_array['validAuth'])
        echo '<div class="alert alert-danger">Unauthorised access!</div>';
    else if(!$json_array['validAdmin'])
        echo '<div class="alert alert-danger">Incorrect Admin ID!</div>';
    else
         echo '<div class="alert alert-danger">Technical Error!</div>';

?>