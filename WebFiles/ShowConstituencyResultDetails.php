<?php
$errorMSG = "";

if (empty($_POST["stateid"])) {
    $errorMSG = "<li>State Election ID is required</<li>";
} else {
    $stateid=$_POST['stateid'];
}

if (empty($_POST["constituencyName"])) {
    $errorMSG = "<li>Constituency Name is required</<li>";
} 
else {
    $constituencyName=$_POST['constituencyName'];
}
include './Values.php';
$url=$web_host."/ConstituencyResultDetails.php";
$data = array('postAuthKey' =>$post_auth_key, 'stateElectionId' =>$stateid, 'constituencyName' =>$constituencyName);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
if ($response === 'FALSE' or $response==NULL) { $errorMSG="<li>Sorry! an error occured. Please try again!</li>"; }
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