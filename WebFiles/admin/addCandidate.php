<?php 
$errorMSG = "";

if (empty($_POST["name"])) {
    $errorMSG = $errorMSG."<li>Candidate Name is required</<li>";
} else {
    $name=$_POST['name'];
}

if (empty($_POST["stateElectionId"])) {
    $errorMSG = $errorMSG."<li>State ID is required</<li>";
} else {
    $stateElectionId=$_POST['stateElectionId'];
}

if (empty($_POST["constituencyname"])) {
    $errorMSG = $errorMSG."<li>Constituency Name is required</<li>";
} else {
    $constituencyName=$_POST['constituencyname'];
}

if (empty($_POST["party"])) {
    $errorMSG = $errorMSG."<li>Party is required</<li>";
} else {
    $partyName=$_POST['party'];
}

if (empty($_POST["admin_id"])) {
    $errorMSG = $errorMSG."<li>OTP is required</<li>";
} else {
    $admin_id=$_POST['admin_id'];
}
    
   
include '../Values.php';
$url=$web_host."/AddCandidate.php";
$data = array('postAuthKey' =>$post_auth_key,'name' =>$name,'stateElectionId'=>$stateElectionId,'constituencyName' =>$constituencyName,'partyName'=>$partyName,'adminId'=>$admin_id);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);
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

