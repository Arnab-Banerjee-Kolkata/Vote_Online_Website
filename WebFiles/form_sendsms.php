<?php
session_start();
$publicId=$_POST['publicId'];
$typeselected=$_POST['typeselected'];
$aadhaarNo=$_POST['aadhaarNo'];
$boothId=$_POST['boothId'];

include 'Values.php';
$url=$web_host."/TestSms.php";
$data = array('aadhaarNo' =>$aadhaarNo,'smsAuthKey' =>$sms_auth_key,'boothId'=>$boothId,'electionId'=>$publicId,'type'=>$typeselected);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);
if ($response === 'FALSE' or $response == NULL) { echo '<div class="alert alert-danger">Sorry! an error occured. Please try again!</div>'; }
$json_array=json_decode($response, true); 
 //echo "BoothId=".$boothId."<br>aadhaarNo=".$aadhaarNo."<br>ElectionId=".$publicId."<br>typeSelected".$typeselected."<br>Response=".$response;       //ARNAB TESTING
    if($json_array['success'])
        echo '<div class="alert alert-success">A sms has been sent to voter\'s registered mobile number.</div>';
    else if(!$json_array['validBooth'])
        echo '<div class="alert alert-danger">Invalid Booth / Logged out Booth!</div>';
    else if(!$json_array['validAadhaar'])
    {
        echo '<div class="alert alert-danger">Invalid Aadhaar Number</div>';
       // echo "SmsAuthKey=".$sms_auth_key."<br>BoothId=".$boothId."<br>aadhaarNo=".$aadhaarNo."<br>ElectionId=".$publicId."<br>typeSelected".$typeselected."<br>Response=".$response;       //ARNAB TESTING
    }
    else if(!$json_array['validSmsAuth'])
        echo '<div class="alert alert-danger">Invalid Auth Key!</div>';
    else if(!$json_array['validType'])
        echo '<div class="alert alert-danger">Invalid Election Type!</div>';
    else if(!$json_array['validVoter'])
        echo '<div class="alert alert-danger">Voter has already voted!</div>';
    else if(!$json_array['validLimit'])
        echo '<div class="alert alert-danger">Sms limit has been reached for the voter for this election from this booth!</div>';
    else{
         echo '<div class="alert alert-danger">Technical Error!</div>';
    }
?>