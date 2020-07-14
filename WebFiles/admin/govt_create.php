<?php
include 'includes/header.php'; 
?>


<body class="p-md-5 p-3 bodycolor">
<?php
include 'includes/scripts.php';?>
<div id="screen">
<?php include 'includes/admin_navbar.php'; ?>
<section class="mainframe p-md-5 p-3">

<div class="text-center" style="min-height: 70vh;">
<h3 class="h3 heading mt-3 text-center">CREATE ELECTION</h3>
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">

<div id="efrm" class="mb-5 mx-5">
     <select class="form-control mb-2 box1 navshadow border-0" id="type" name="type">
        <option value="-1" disabled selected>SELECT TYPE OF ELECTION</option>
        <option value="loksabha">LOK SABHA</option>
        <option value="vidhansabha">VIDHAN SABHA</option>
     </select>
  </div>   


<!--CREATE LOK SABHA ELECTION-->
<div id="loksabhafrm" style="display:none;">
  <h4 class="heading primarytext">CREATE LOK SABHA ELECTION</h4>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

            <div class="alert alert-danger lsdisplay-error" style="display: none"></div>
            <form class="px-2 px-md-5">
            <div class="form-group ">
              <label for="ls_ename" class="my-2">Create Election Name :</label>
              <input type="text" id="ls_ename" name="ls_ename" maxlength="50" class="form-control rounded-pill navshadow" placeholder="Max characters:50" required>
            </div>
            <div class="form-group">
              <label for="datepicker" class="my-2">Enter Election Year:</label>
              <input type="text" id="datepicker" name="datepicker" class="form-control rounded-pill navshadow" readonly placeholder="YYYY" required>
            </div>
          <input type="submit" id="lokbutton" class="btn submitbtn rounded-pill px-5 m-3" value="Create" />
          </form>
          <div id="ls_create_election"></div>        
  
    </div>
    <div class="col-md-2"></div>
  </div>
</div>

<!--CREATE VIDHAN SABHA ELECTION-->
<div id="vidhansabhafrm" style="display:none;">
  <h4 class="heading primarytext">CREATE VIDHAN SABHA ELECTION</h4>
   <div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">

            <div class="alert alert-danger display-error" style="display: none"></div>
            <form class="px-2 px-md-5">
            <div class="form-group ">
              <label for="vs_ename" class="my-2">Create Election Name :</label>
              <input type="text" maxlength="50" class="form-control rounded-pill navshadow" id="vs_ename" name="vs_ename" required placeholder="Max characters:50">
            </div>
            <div class="form-group">
              <label for="vsdatepicker" class="my-2">Enter Election Year:</label>
              <input type="text" id="vsdatepicker" name="vsdatepicker" class="form-control rounded-pill navshadow" placeholder="YYYY" readonly required>
            </div>
             <div class="form-group mb-5">
              <label for="vs_stateselected" class="mb-0">Select State:</label>           
              <select class="form-control rounded-pill" id="vs_stateselected" name="vs_stateselected" required>
              <option value="-1">SELECT STATE</option>
         
         <?php
          include '../Values.php';
          $url=$web_host."/ShowStateList.php";
          $data = array('postAuthKey' =>$post_auth_key);
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


              if(!$json_array['validAuth'])
                  echo 'Unauthorised access!';
              else if(!$json_array['success'])
                  echo 'Technical Error!';
              else
              {
                  display_states($json_array);
              }
              function display_states($json_rec){
              if($json_rec){
                      
                foreach($json_rec as $key=> $value){
                  if(is_array($value)){
                    display_states($value);
                  }else if($key=='name'){
                    $name=$value;
                  }
                  else if($key=='code')
                    {echo '<option value="'.$value.'">'.$name.'&nbsp;-- ( <b>'.$value.'</b> )'.'</option>';}
                   
                } 
              } 
            }

          ?>
          </select>
          </div>
          <input type="submit" id="vidhanbutton" class="btn submitbtn rounded-pill px-5 m-3" value="Create" />
          </form>
          <div id="vs_create_election"></div>   

       
  </div>
  <div class="col-md-2"></div>
  </div>   
  
</div>

</div>
<div class="col-md-2"></div>
</div>
</div>
</section>
<?php include '../includes/footer.php'; ?>
</div>
<script>
(function()
{
  function toggle_t()
  {
    var d = document;
    var cntn = d.getElementById("efrm");
    var val = d.getElementsByName("type")[0];
    cntn.addEventListener("change",fillup);
    function fillup()
    {
      if(val.value != "-1")
      {
        var t;
        if(val.value == "loksabha"){
          document.getElementById("loksabhafrm").style.display="block";
          document.getElementById("vidhansabhafrm").style.display="none";
          
        }
        else if(val.value == "vidhansabha"){
          document.getElementById("vidhansabhafrm").style.display="block";
          document.getElementById("loksabhafrm").style.display="none";

        }
      }
    }
  }
  toggle_t();
  })();


  $(document).ready(function() {

              $('#lokbutton').click(function(e){
              e.preventDefault();

              var admin_id=sessionStorage.getItem("adminID");
              var ls_ename=$("#ls_ename").val();
              var datepicker=$("#datepicker").val();
             // alert("Your inputs:"+ls_ename+' '+datepicker);
              $(".lsdisplay-error").css("display","none");
              $('#ls_create_election').html("<b>Loading response...Please Wait!</b>");
              $.ajax({
                  type: "POST",
                  url: "CreateLokSabhaElection.php",
                  dataType: "json",                  
                  data: {admin_id:admin_id, ls_ename:ls_ename, datepicker:datepicker},
                  success : function(data){
                   //  var obj = JSON.parse(data); 
                     $('#ls_create_election').html("<b>Loaded Successfully!</b>"); 
                     if (data.code===11){
                           if(data.msg.success===true){
                             $('#ls_create_election').html("<div class='alert alert-success'>Lok Sabha Election has been created successfully.</div>"); 
                           }
                           else if(data.msg.validAuth===false){
                              $(".lsdisplay-error").html("Unauthorised access!");
                              $(".lsdisplay-error").css("display","block");}
                           else if(data.msg.validAdmin===false){
                              $(".lsdisplay-error").html("Invalid Admin or logged out Admin!");
                              $(".lsdisplay-error").css("display","block");
                              return calllogout(); }
                           else if(data.msg.validName===false){
                              $(".lsdisplay-error").html("Invalid Name!");
                              $(".lsdisplay-error").css("display","block");}
                           else if(data.msg.validYear===false){
                              $(".lsdisplay-error").html("Year is lesser than current year!");
                              $(".lsdisplay-error").css("display","block");}
                           else if(data.msg.validElection===false){
                              $(".lsdisplay-error").html("Election has already been created!");
                              $(".lsdisplay-error").css("display","block");}
                           else{
                              $(".lsdisplay-error").html("Techinal Error!");
                              $(".lsdisplay-error").css("display","block");}
                      } else {
                          $(".lsdisplay-error").html("<ul>"+data.msg+"</ul>");
                          $(".lsdisplay-error").css("display","block");
                      } 
                  },
                error: function() {
                $(".lsdisplay-error").html("Something Went Wrong!");
                $(".lsdisplay-error").css("display","block");
                $('#ls_create_election').html("<b>Loading failed! Click on 'Create' and try Again</b>"); 
                } 
              });

            });  


        $('#vidhanbutton').click(function(e){
        e.preventDefault();

        var admin_id=sessionStorage.getItem("adminID");
        var vs_ename=$("#vs_ename").val();
        var datepicker=$("#vsdatepicker").val();
        var vs_stateselected=$("#vs_stateselected").val();
       // alert("Your inputs:"+vs_ename+' '+datepicker+' '+vs_stateselected);
        $('#vs_create_election').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "CreateVidhanSabhaElection.php",
            dataType: "json",
            data: {admin_id:admin_id, vs_ename:vs_ename, datepicker:datepicker, vs_stateselected:vs_stateselected},
            success : function(data){
               $('#vs_create_election').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       $('#vs_create_election').html("<div class='alert alert-success'>Vidhan Sabha Election has been created successfully.</div>");
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-error").html("Invalid Admin or logged out Admin!");
                        $(".display-error").css("display","block");
                        return calllogout(); }
                     else if(data.msg.validName===false){
                        $(".display-error").html("Invalid Name!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validYear===false){
                        $(".display-error").html("Year is lesser than current year!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validElection===false){
                        $(".display-error").html("Election has already been created!");
                        $(".display-error").css("display","block");}
                     else{
                        $(".display-error").html("Technical Error!");
                        $(".display-error").css("display","block");}
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                } 
            },
             error: function() {
                $(".display-error").html("Something Went Wrong!");
                $(".display-error").css("display","block");
                $('#vs_create_election').html("<b>Loading failed! Click on 'Create' and Try Again</b>"); 
                }  
        });

      });


  }); 
  $("#datepicker").datepicker({
    format: " yyyy",
    viewMode: "years", 
    minViewMode: "years",
    startDate: "now()" 
});
$("#vsdatepicker").datepicker({
    format: " yyyy",
    viewMode: "years", 
    minViewMode: "years",
    startDate: "now()" 
}); 
</script>

</body>
</html>