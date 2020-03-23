<?php
session_start();
$booth_id=$_SESSION['bid'];
include 'Values.php';
$url=$web_host."/BoothLogout.php";
$data = array('booth_id'=>$booth_id,'postAuthKey' =>$post_auth_key);

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
    else if(!$json_array['validBooth'])
        echo 'Invalid Booth';
    else if(!$json_array['success'])
        echo 'Technical Issue';
    else
    {
       session_destroy();
       echo "<script>window.open('index.php', '_self')</script>";
 
    }

?>

