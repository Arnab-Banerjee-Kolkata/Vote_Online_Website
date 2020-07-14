<?php 
$errorMSG = "";

if (empty($_POST["partyName"])) {
    $errorMSG = "<li>Party name is required</<li>";
} else {
    $name=$_POST['partyName'];
}
if (empty($_POST["admin_id"])) {
    $errorMSG = $errorMSG."<li>Admin ID is required</<li>";
} else {
    $admin_id=$_POST['admin_id'];
}
if (empty($_POST["symbol"])) {
    $errorMSG = $errorMSG."<li>Symbol is required</<li>";
} else {
    $symbol=$_POST['symbol'];
}

include '../Values.php';
$url=$web_host."/AddParty.php";
$data = array('postAuthKey' =>$post_auth_key,'name'=>$name,'adminId'=>$admin_id,'symbol'=>$symbol);
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

