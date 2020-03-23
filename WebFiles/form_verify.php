<?php
session_start();

include 'Values.php';

$aadhaarNo=$_SESSION['aNo'];
$electionId=$_SESSION['eid'];

$url=$web_host."/ChangeApproval.php";
include 'Values.php';
$data = array('aadhaarNo'=>$aadhaarNo,'approvalState' =>'1','postAuthKey' =>$post_auth_key,'electionId'=>$electionId);
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
        echo 'Technical Issue!';
    else
    {
       $_SESSION["eid"]=-1;
       echo "<script>window.open('confirm.php', '_self')</script>";
 
    }

?>
