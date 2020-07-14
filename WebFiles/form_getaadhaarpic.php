<?php
$errorMSG = "";

if (empty($_POST["aadhaarNo"])) {
    $errorMSG = "<li>PLEASE ENTER YOUR AADHAAR NUMBER!</<li>";} 
if (!is_numeric($_POST["aadhaarNo"])){
     $errorMSG = $errorMSG."<li>AADHAAR NO. MUST BE NUMERIC.</li>";}
if (substr($_POST["aadhaarNo"], 0, 1)==0){
    $errorMSG = $errorMSG."<li>AADHAAR NO. MUST NOT START WITH 0.</li>";}
if (strlen((string)$_POST["aadhaarNo"])!=12){
    $errorMSG = $errorMSG."<li>AADHAAR NO. MUST HAVE 12 DIGITS.</li>";}
if (!empty($_POST["aadhaarNo"]) && empty($errorMSG)) {
     $aadhaarNo=$_POST['aadhaarNo'];
}


if (empty($_POST["booth_id"])) {
    $errorMSG = "<li>PLEASE ENTER YOUR BOOTH ID!</<li>";
} else {
    $booth_id=$_POST['booth_id'];
}

include 'Values.php';
$url=$web_host."/FetchVoterImage.php";
$data = array('postAuthKey' =>$post_auth_key,'boothId'=>$booth_id,'aadhaarNo' => $aadhaarNo);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);
if ($response === 'FALSE' or $response== NULL) { $errorMSG="<li>Sorry! an error occured. Please try again!</li>"; }
$json_array=json_decode($response, true); 

if(empty($errorMSG)){
    $successarray=array("code"=>11, "web_host"=>$web_host, "msg"=>$json_array);
    echo json_encode($successarray);
    exit;
}
else{
$failarray=array("code"=>10, "msg"=>$errorMSG);    
echo json_encode($failarray);
}

?>
