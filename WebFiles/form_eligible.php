<?php
$errorMSG = "";
if (empty($_POST["aadhaarNo"])) {
    $errorMSG = "<li>Aadhaar no. is required</<li>";
} else {
    $aadhaarNo=$_POST['aadhaarNo'];
}

if (empty($_POST["publicId"])) {
    $errorMSG = $errorMSG."<li>Election ID is required</<li>";
} else {
    $publicId=$_POST['publicId'];
}

if (empty($_POST["typeselected"])) {
    $errorMSG = $errorMSG."<li>Election Type is required</<li>";
} else {
    $typeselected=$_POST['typeselected'];
}

if (empty($_POST["voterotp"])) {
    $errorMSG = $errorMSG."<li>PLEASE ENTER VOTER\'S OTP.</<li>";
} 
if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["voterotp"])){
    $errorMSG = $errorMSG."<li>OTP MUST NOT HAVE SPECIAL CHARACTERS.</<li>";
} 
if(strlen((string)$_POST["voterotp"])>8){
    $errorMSG = $errorMSG."<li>OTP IT MUST HAVE MAXIMUM 8 DIGITS.</<li>";
} 
if (!empty($_POST["voterotp"]) && empty($errorMSG)) {
    $voterotp=$_POST['voterotp'];
}

if (empty($_POST["boothId"])) {
    $errorMSG = $errorMSG."<li>Booth ID is required</<li>";
} else {
    $boothId=$_POST['boothId'];
}

include 'Values.php';
$url=$web_host."/ValidateVoterOtp.php";
$data = array('postAuthKey' =>$post_auth_key,'boothId'=>$boothId,'aadhaarNo' =>$aadhaarNo,'voterOtp' => $voterotp,'electionId'=>$publicId,'type' => $typeselected);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);
if ($response === 'FALSE' or $response == NULL) {$errorMSG="<li>Sorry! an error occured. Please try again!</li>"; }
$json_array=json_decode($response, true); 

if(empty($errorMSG)){
    $successarray=array("code"=>11, "msg"=>$json_array);
    echo json_encode($successarray);
    exit;
}
else{
$failarray=array("code"=>10, "msg"=>$errorMSG);    
echo json_encode($failarray);
}

?>