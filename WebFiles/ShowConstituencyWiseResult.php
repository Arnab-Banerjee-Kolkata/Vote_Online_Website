<?php
$errorMSG = "";

if (empty($_POST["id"])) {
    $errorMSG = "<li>Election ID is required</<li>";
} else {
    $id=$_POST['id'];
}

if (empty($_POST["type"])) {
    $errorMSG = "<li>Type is required</<li>";
} else {
    $type=$_POST['type'];
}

if (empty($_POST["stateCode"])) {
    $errorMSG = "<li>State Code is required</<li>";
} 
else if($_POST["stateCode"]=="vidhan"){
    $stateCode='';
}
else {
    $stateCode=$_POST['stateCode'];
}
include './Values.php';
$url=$web_host."/ConstituencyWiseResult.php";
$data = array('postAuthKey' =>$post_auth_key, 'electionId' =>$id, 'type' =>$type, 'stateCode'=>$stateCode );
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