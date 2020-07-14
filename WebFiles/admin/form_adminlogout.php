<?php
$errorMSG = "";

if (empty($_POST["admin_id"])) {
    $errorMSG = "Admin ID is expired!";
} else {
    $admin_id=$_POST['admin_id'];
}

include '../Values.php';
$url=$web_host."/AdminLogout.php";

$data = array('postAuthKey' =>$post_auth_key,'adminId'=>$admin_id);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
if ($response === 'FALSE' or $response==NULL) { $errorMSG="Sorry! an error occured. Please try again!"; }
$json_array=json_decode($response, true); 

if(empty($errorMSG)){
    echo json_encode(['code'=>11, 'msg'=>$json_array]);
	exit;
}


echo json_encode(['code'=>10, 'msg'=>$errorMSG]);

?>
