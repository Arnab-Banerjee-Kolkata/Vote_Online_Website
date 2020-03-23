<?php
session_start();
$aadharNo=$_POST['aadharNo'];
$otp=$_POST['otp'];
$electionId=$_POST['electionId'];

include 'Values.php';
$url=$web_host."/ValidateOtp.php";
$data = array('category' => 'voter','boothId'=>'a1234b','otp' => $otp,'postAuthKey' =>$post_auth_key,'aadhaarNo' =>$aadharNo,'electionId'=>$electionId);
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
    else if(!$json_array['validStatus'])
        echo 'Already Voted!';
    else if(!$json_array['success'])
        echo 'Incorrect OTP. Resend OTP.!';
    else{
        $_SESSION["bo"] =$json_array['boothOtp'];
        $_SESSION["aNo"]=$aadharNo;
        $_SESSION["eid"]=$electionId;
        echo "<script>window.open('identify.php', '_self')</script>";
    }

?>







