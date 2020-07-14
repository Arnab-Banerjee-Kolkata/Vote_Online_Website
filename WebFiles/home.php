<?php
include './includes/header.php'; 
?>
<style>
.steps-form {
    display: table;
    width: 100%;
    position: relative; }
.steps-form .steps-row {
    display: table-row; }
.steps-form .steps-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
     }
.steps-form .steps-row .steps-step {
    display: table-cell;
    text-align: center;
    position: relative; }
.steps-form .steps-row .steps-step p {
    margin-top: 0.5rem; }
/*.steps-form .steps-row .steps-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important; }*/
.steps-form .steps-row .steps-step .btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
    margin-top: 0; 
    background:#dd99ff;
    color:white;
    font-weight:bold;}
</style>
<body class="p-md-5 p-3 bodycolor">
<?php include './includes/scripts.php'; ?>
<div id="screen">
<?php include './includes/booth_navbar.php';?>  
<section class="mainframe">

<div class="boothhead text-center">
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8 py-5">
<h2 class="h2 heading">Online Governmental Booth</h2>
<!-- Stepper -->
    <div class="steps-form">
      <div class="steps-row setup-panel">
        <div class="steps-step">
          <button type="button" class="btn btn-circle" id="step1btn" style="background:#ffc14d;">1</button>
          <p>Aadhaar ID Entry</p>
        </div>
        <div class="steps-step">
          <button type="button" class="btn btn-circle" id="step2btn">2</button>
          <p>Image Verification</p>
        </div>
        <div class="steps-step">
          <button type="button" class="btn btn-circle" id="step3btn">3</button>
          <p>Eligibility Check</p>
        </div>
        <div class="steps-step">
          <button type="button" class="btn btn-circle" id="step4btn">4</button>
          <p>Approval To Vote</p>
        </div>
      </div>
    </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>


<div class="text-center p-md-5 p-3" style="min-height: 70vh;">

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6 mt-4 surfacestyle">

<div id="step1" class="py-md-5 mt-md-3" style="min-height:50vh;">
  <div class="alert alert-danger display-step1-error" style="display: none"></div>
  <form class="p-4 was-validated" method="post" action="#">
  <div class="form-group box1">
    <label for="publicelectionId">Select Election :</label>    
    <select class="form-control rounded-pill navshadow" id="publicelectionId" name="publicelectionId" required>
    <option value="">Select Election</option>
          <?php
          include 'Values.php';
          $url=$web_host."/ShowPublicElections.php";
          $data = array('postAuthKey' =>$post_auth_key);
          echo $postAuthKey;
          $options = array(
              'http' => array(
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                  'method'  => 'POST',
                  'content' => http_build_query($data)
              )
          );
          $context  = stream_context_create($options);
          $response = file_get_contents($url, false, $context);
          if ($response === 'FALSE' or $response==NULL) { echo '<div class="alert alert-danger">Sorry! an error occured. Please try again!</div>'; }
          $json_array=json_decode($response, true); 


              if(!$json_array['validAuth'])
                  echo '<div class="alert alert-danger">Unauthorised access!</div>';
              else if(!$json_array['success'])
                  echo '<div class="alert alert-danger">Technical Error!</div>';
              else
              {
                  display_publicElections($json_array);
              }

              function display_publicElections($json_rec){
              if($json_rec){
                      
                foreach($json_rec as $key=> $value){
                  if(is_array($value)){
                    display_publicElections($value);
                  }else if($key=='electionId'){
                    $electionId=$value;
                  }
                  else if($key=='name'){
                    $name=$value;}
                 else if($key=='type'){
                    $type=$value;}
                else if($key=='status'){
                    $status=$value;}
                  else if($key=='year' and $status==1){
                    echo '<option value="'.$electionId.'">'.$name.'('.$value.')--'.$type.'</option>';} 
                } 
              } 
            }

          ?>
          </select>
  </div>
  <div class="form-group box1">
    <label for="aadhaarNo">Enter Voter's Aadhaar No :</label>
    <input type="text" class="form-control rounded-pill navshadow" maxlength="12" inputmode="numeric" placeholder="XXXX-XXXX-XXXX" name="aadhaarNo" id="aadhaarNo" required>
  </div>
   <button type="submit" id="submit_aadhaar" class="btn box2 submitbtn rounded-pill px-5 m-3">Submit</button>
   <input type="button" class="btn box2 backbtn rounded-pill navshadow px-5 m-3" onclick="window.location.href = 'home.php';" value="Reset"/>
</form>
<div id="aadhaarpic"></div>
</div>


<div id="step2" class="py-md-5 py-3 mt-md-3" style="display:none;min-height:50vh;">
<h3 class="h3 heading box1">Select any one way of verification : </h3>
    <div class="row p-5 box2">
    <div class="col-md-4">
         <div class="card rounded-circle m-2">
                <img src="images/otp.png" class="img-fluid" data-toggle="modal" data-target="#otpmodal">
          </div>    
          <h6>OTP Verification</h6>
              
    </div>
    <div class="col-md-4">
         <div class="card rounded-circle m-2">
            <img src="images/fingerprint.png" class="img-fluid" width="100%">         
          </div>
          <h6>Finger-print Verification</h6>
    </div>
    <div class="col-md-4">
         <div class="card rounded-circle m-2  ">         
            <img src="images/retinal.png" class="img-fluid" width="100%">          
          </div>
          <h6>Retinal Verification</h6>
    </div>

    </div>
</div>
<!--OTP-->
      <div class="modal text-dark" id="otpmodal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title">Confirmation!</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                          You selected <b>OTP Verification</b>! Are you sure you want to proceed?
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <input type="submit" class="btn submitbtn rounded-pill navshadow px-5 m-1" value="Proceed" name=" " onclick="showstep3();" data-dismiss="modal" />
                          <button type="button" class="btn backbtn rounded-pill px-5 m-1" data-dismiss="modal">Cancel</button>
                        </div>
                  <!--onclick="return sendtextsms()"-->
                      </div>
                    </div>
            </div>


<div id="step3" class="py-md-5 mt-md-3" style="display:none;min-height:50vh;">
<div id="smsreport"></div>
<h5 class="box1 py-3">AADHAAR NUMBER : <span id="aadhaarheading"></span></h5>
<div class="alert alert-danger display-step3-error" style="display: none"></div>
 <form class="p-4 was-validated" method="post" action="#">
 <div class="form-group box1">
    <label for="voterotp">Enter Voter's OTP :</label>
    <input type="text" class="form-control rounded-pill navshadow" maxlength="8" inputmode="numeric"  placeholder="Eg. 12528765" name="voterotp" id="voterotp" required>
  </div>
   <button type="submit" id="submit_otp" class="btn box2 submitbtn rounded-pill px-5 m-3">Submit</button>
   <input type="button" class="btn box2 backbtn rounded-pill navshadow px-5 m-3" onclick="showstep2();" value="Go Back"/>
</form>
<div id="beforeload"></div>
</div>


<div id="step4" class="py-md-5 mt-md-3" style="display:none;min-height:50vh;">
<div id="eligible"></div>
<button type="button" class="btn box1 submitbtn rounded-pill px-5 m-3" onclick="location.reload();">Finish</button>
<button type="button" class="btn box1 backbtn rounded-pill px-5 m-3" onclick="showstep3();">Go Back</button>
</div>
</div>
</div>

</div>

<div class="col-md-3"></div>
</div>

</div>
</section>
<?php include './includes/footer.php'; ?>
</div>
<script type="text/javascript">

function showstep1(){
  document.getElementById('step1').style.display='block';
  document.getElementById('step1btn').style.background='#ffc14d';
  document.getElementById('step2').style.display='none';
  document.getElementById('step2btn').style.background=null;
  document.getElementById('step3').style.display='none';
  document.getElementById('step3btn').style.background=null;
  document.getElementById('step4').style.display='none';
  document.getElementById('step4btn').style.background=null;
}
function showstep2(){
  document.getElementById('step2').style.display='block';
  document.getElementById('step2btn').style.background='#ffc14d';
  document.getElementById('step1').style.display='none';
  document.getElementById('step1btn').style.background=null;
  document.getElementById('step3').style.display='none';
  document.getElementById('step3btn').style.background=null;
  document.getElementById('step4').style.display='none';
  document.getElementById('step4btn').style.background=null;
  
}
function showstep3(){
  document.getElementById('step3').style.display='block';
  document.getElementById('step3btn').style.background='#ffc14d';
  document.getElementById('step2').style.display='none';
  document.getElementById('step2btn').style.background=null;
  document.getElementById('step1').style.display='none';
  document.getElementById('step1btn').style.background=null;
  document.getElementById('step4').style.display='none';
  document.getElementById('step4btn').style.background=null;
  
}
function showstep4(){
  document.getElementById('step4').style.display='block';
  document.getElementById('step4btn').style.background='#ffc14d';
  document.getElementById('step2').style.display='none';
  document.getElementById('step2btn').style.background=null;
  document.getElementById('step3').style.display='none';
  document.getElementById('step3btn').style.background=null;
  document.getElementById('step1').style.display='none';
  document.getElementById('step1btn').style.background=null;
  
}

 $(document).ready(function() {
      checklogout();

      $('#submit_aadhaar').click(function(e){
        e.preventDefault();

       var aadhaarNo=$("#aadhaarNo").val();
       var publicId=$("#publicelectionId").val();
       var selectedopt=$( "#publicelectionId option:selected" ).text();
       var booth_id= sessionStorage.getItem("boothID");
            $.ajax({
            type: "POST",
            url: "form_getaadhaarpic.php",
            dataType: "json",
            data: {aadhaarNo:aadhaarNo, booth_id:booth_id},
            success : function(data){
               $('#aadhaarpic').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                        $('#aadhaarpic').html('<div class="row"><div class="col-md-2"></div><div class="col-md-8 mx-auto"><div class="card text-center box4" style="width:100%"><img class="card-img-top" src="'+data.web_host+'/'+data.msg.imagePath+'" alt="Aadhaar image" style="width:100%"><div class="card-body"><h4 class="card-title">Aadhaar No:'+aadhaarNo+'</h4></div></div><form method="post" class="p-3 mb-5"><input type="button" class="rounded-pill px-5 py-1 m-1 box1 btn-success" value="Accept" onclick="showstep2();"/><input type="button" class="rounded-pill px-5 py-1 m-1 box1 btn-danger" value="Reject" onclick="location.reload();"/></form><br></div><div class="col-md-2"></div></div>');
                        $(".display-step1-error").css("display","none");
                        $('#aadhaarheading').html(aadhaarNo);
                        sessionStorage.setItem("currentAadhaar", aadhaarNo); 
                        sessionStorage.setItem("boothElectionId", publicId);
                        sessionStorage.setItem("boothSelectedOption", selectedopt);
                       // alert("election id:"+publicId+" selected option:"+selectedopt);
                        document.getElementById("aadhaarheading").innerHTML = sessionStorage.getItem("currentAadhaar");
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-step1-error").html("Unauthorised access!");
                        $(".display-step1-error").css("display","block");}
                     else if(data.msg.validBooth===false){
                        $(".display-step1-error").html("Invalid Booth or booth not logged in!");
                        $(".display-step1-error").css("display","block");calllogout();
                        }
                     else if(data.msg.validAadhaar===false){
                        $(".display-step1-error").html("Invalid Aadhaar Number!");
                        $(".display-step1-error").css("display","block");}
                     else{
                        $(".display-step1-error").html("Techninal Error!");
                        $(".display-step1-error").css("display","block");}
                } else {
                    $(".display-step1-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-step1-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-step1-error").html("Something Went Wrong!");
                $(".display-step1-error").css("display","block");
                $('#aadhaarpic').html("<b>Loading failed! Click on 'Submit' and Try Again</b>"); 
                } 
        
      });
  });


/*function sendtextsms(){
    var selected_option=localStorage.getItem("boothSelectedOption");
    var splittedstr=selected_option.split("--");
    var typeselected=splittedstr[1];
    var aadhaarNo=localStorage.getItem("currentAadhaar");
    var publicId=localStorage.getItem("boothElectionId");
    var boothId= localStorage.getItem("boothID");
    //alert(boothId);
    $.ajax({
            type:"post",
            url:"form_sendsms.php",
            data:
            {
                'aadhaarNo':aadhaarNo,
                'publicId':publicId,
                'typeselected':typeselected,
                'boothId':boothId
            },
            cache:false,
            success: function (html) 
            {
              // alert(typeselected);
               showstep3();
               $('#smsreport').html(html);
               localStorage.setItem("boothElectionType", typeselected); 
            }
            });
            return false;  
}
*/

$('#submit_otp').click(function(e){
        e.preventDefault();        
       var selected_option=sessionStorage.getItem("boothSelectedOption");//off when sms is on
       var splittedstr=selected_option.split("--");//off when sms is on
       var typeselected=splittedstr[1];//off when sms is on

       // var typeselected=sessionStorage.getItem("boothElectionType");//ON when sms is on
        var aadhaarNo=sessionStorage.getItem("currentAadhaar");
        var publicId=sessionStorage.getItem("boothElectionId");
        var voterotp=$("#voterotp").val();
        var boothId= sessionStorage.getItem("boothID");
        $('#beforeload').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "form_eligible.php",
            dataType: "json",
            data: {aadhaarNo:aadhaarNo, publicId:publicId, typeselected:typeselected, voterotp:voterotp, boothId:boothId},
            success : function(data){
               $('#beforeload').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.returnValue.garbageVoted.success===true){
                       showstep4();
                       $('#eligible').html('<div class="alert alert-success"><h3>BOOTH OTP :'+data.msg.boothOtp+'</h3></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-step3-error").html("Unauthorised access!");
                        $(".display-step3-error").css("display","block");}
                     else if(data.msg.validBooth===false){
                        $(".display-step3-error").html("Invalid Booth or booth not logged in!");
                        $(".display-step3-error").css("display","block");
                        calllogout();}
                     else if(data.msg.validAadhaar===false){
                        $(".display-step3-error").html("Invalid Aadhaar Number!");
                        $(".display-step3-error").css("display","block");}
                     else if(data.msg.validApproval===false){
                        $(".display-step3-error").html("Please wait until previous voter is done!");
                        $(".display-step3-error").css("display","block");}
                     else if(data.msg.validOtp===false){
                        $(".display-step3-error").html("Invalid Voter OTP!");
                        $(".display-step3-error").css("display","block");}
                     else if(data.msg.returnValue.validVoterStatus===false){
                        $(".display-step3-error").html("Voter cannot vote again!");
                        $(".display-step3-error").css("display","block");}
                     else if(data.msg.returnValue.validInternalAuth===false || data.msg.returnValue.garbageVoted.validInternalAuth2===false){
                        $(".display-step3-error").html("Technical Error: Invalid internal auth! Please try again.");
                        $(".display-step3-error").css("display","block");}
                     else{
                        $(".display-step3-error").html("Technical Error! Please try again.");
                        $(".display-step3-error").css("display","block");}
                } else {
                    $(".display-step3-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-step3-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-step3-error").html("Something Went Wrong!");
                $(".display-step3-error").css("display","block");
                $('#beforeload').html("<b>Loading failed! Click on 'Submit' and Try Again</b>"); 
                } 
        });

      });

});      
</script>

</body>
</html>
