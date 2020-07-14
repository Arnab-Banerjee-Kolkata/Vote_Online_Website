<?php 
session_start();
   
    $admin_id=$_POST['admin_id'];
    $stateCode=$_POST['stateCode'];
    $type=$_POST['type'];     
include '../Values.php';
          $url=$web_host."/GetPhase.php";
          $data = array('postAuthKey' =>$post_auth_key,'adminId'=>$admin_id,'stateCode'=>$stateCode,'type'=>$type);
          $options = array(
              'http' => array(
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                  'method'  => 'POST',
                  'content' => http_build_query($data)
              )
          );
          $context  = stream_context_create($options);
          $response = file_get_contents($url, false, $context);

          if ($response === 'FALSE' or $response==NULL) { echo "Sorry! an error occured. Please try again!"; }
          $json_array=json_decode($response, true); 

            if($json_array['success'])
              {
            echo'
             <label for="vsphaseselected" class="my-2">Select Phase:</label> 
            <select class="form-control rounded-pill navshadow border-0" id="vsphaseselected" name="vsphaseselected" required>
              <option value="-1">SELECT PHASE</option>';
              display_phases($json_array);
            echo '</select>';
              }
            else if(!$json_array['validAuth'])
                echo '<div class="alert alert-danger">Unauthorised access!</div>';
            else if(!$json_array['validAdmin'])
                echo '<div class="alert alert-danger">Invalid Admin ID!</div>';
            else if(!$json_array['validCombination']){
                echo '<div class="alert alert-danger">Invalid combination of State Code and Type of Election!</div>';
            }
            else
              echo '<div class="alert alert-danger">Technical Error!</div>';

              function display_phases($json_rec){
              if($json_rec){
                      
                foreach($json_rec as $key=> $value){
                  if(is_array($value)){
                    display_phases($value);
                  }else if($key=='type'){
                    $type=$value;
                  }
                  else if($key=='code'){
                    {echo '<option value="'.$value.'">'.$type.'&nbsp;-- ( <b>'.$value.'</b> )'.'</option>';}
                  } 
                } 
              } 
            }

          ?>