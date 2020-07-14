<?php 
    $errorMSG = "";

if (empty($_POST["admin_id"])) {
    $errorMSG = "<li>Admin ID is required</li>";
} else {
    $admin_id=$_POST['admin_id'];
}

if (empty($_POST["ls_ename"])) {
    $errorMSG = $errorMSG."<li>Election Name is required</li>";
} else {
    $ls_ename=$_POST['ls_ename'];
}

if (empty($_POST["datepicker"])) {
    $errorMSG = $errorMSG."<li>Date is required</li>";
} else {
    $datepicker=$_POST['datepicker'];
}


include '../Values.php';
$url=$web_host."/CreateLokSabhaElection.php";

$data = array('postAuthKey' =>$post_auth_key,'electionName'=>$ls_ename,'electionYear' => $datepicker,'adminId' => $admin_id);
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

