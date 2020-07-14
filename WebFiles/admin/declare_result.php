<?php include 'includes/header.php'; ?>
<body class="p-md-5 p-3 bodycolor">
<?php include 'includes/scripts.php'; ?>
<div id="screen">
<?php include 'includes/admin_navbar.php'; ?>
<section class="mainframe p-md-5 p-3">
<h3 class="h3 heading mt-3 text-center">DECLARE RESULT</h3>


<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-6">

<div id="electionlist">
<h5 class="text-center heading my-2">List of completed elections:</h5>
<div class="display-list-error alert alert-danger" style="display:none;"></div>
<div id="list_of_elections"></div>
</div>

<div id="constituencylist" style="display: none;">
  <div id="tie_msg" class="text-center text-danger"></div>
  <div class="display-const-error alert alert-danger" style="display:none;"></div>
  <div id="const_response"></div>
  <!-- The Modal -->
              <div class="modal" id="resultmodal">
                <div class="modal-dialog  modal-lg">
                  <div class="modal-content text-dark">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" onclick="window.location.href='declare_result.php';">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                    <div class="result-error alert alert-danger" style="display:none"></div>
                    <div id="result"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-dismiss="modal" onclick="window.location.href='declare_result.php';">Close</button>
                    </div>

                  </div>
                </div>
              </div>
</div>

</div>
<div class="col-sm-3"></div>
</div>
</section>
<?php include '../includes/footer.php'; ?>
</div>
</body>
<script type="text/javascript">
function showConstituency(){
 $("#constituencylist").css("display","block");
 $("#electionlist").css("display","none");
}

$(document).ready(function() {
            var admin_id='dummy';
            $.ajax({
                  type:"POST",
                  url:"CompletedElectionList.php",
                  dataType: "json",
                  data: {admin_id:admin_id},
                  success: function(data) 
                  {
                     $('#list_of_elections').html("<b>Loaded Successfully!</b>");
                     if (data.code ===11){
                     if(data.msg.success===true){
                      $('#list_of_elections').html("");
                       display_elections(data.msg.elections);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-list-error").html("Unauthorised access!");
                        $(".display-list-error").css("display","block");}
                     else{
                        $(".display-list-error").html("Technical error!!");
                        $(".display-list-error").css("display","block");}
                } else {
                    $(".display-list-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-list-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-list-error").html("Something Went Wrong!");
                $(".display-list-error").css("display","block");
                $('#list_of_elections').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
});

function display_elections(arr) {
$(arr).each(function(i) {
if(arr[i].status==2){
    $('#list_of_elections').append('<div class="media border p-3" onclick="submit_soap(\''+arr[i].electionId+'\',\''+arr[i].type+'\');"><div class="media-body"><h5>'+arr[i].name+'('+arr[i].type+')<small style="float:right;"><i>'+arr[i].year+'</i></small></h5><br>'+arr[i].stateName+'</div></div>');
}
});
}
function submit_soap(id,type){
        var id=id;
        var type=type;
        var adminId=sessionStorage.getItem("adminID");
       // alert(id+type+adminId);
        $('#const_response').html("<b>Loading response...Please Wait!</b>");
         $.ajax({
                  type:"POST",
                  url:"ShowConstituencyList.php",
                  dataType: "json",
                  data:{electionId:id, type:type, admin_id:adminId},
                  success: function(data) 
                  {
                    showConstituency();
                     $('#const_response').html("<b>Loaded Successfully!</b>");
                     if (data.code ===11){
                     if(data.msg.success===true){
                       $('#const_response').html("");
                       sessionStorage.setItem("admin_eid",id);
                       sessionStorage.setItem("admin_etype",type);
                       display_with_button(data.msg.constituencyList);
                       display_without_button(data.msg.declaredList);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-const-error").html("Unauthorised access!");
                        $(".display-const-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-const-error").html("Invalid Admin ID or Admin logged out!");
                        $(".display-const-error").css("display","block");
                        calllogout();}
                     else if(data.msg.validType===false){
                        $(".display-const-error").html("Invalid Type!");
                        $(".display-const-error").css("display","block");}
                     else if(data.msg.validElection===true){
                        $(".display-const-error").html("Invalid Election!");
                        $(".display-const-error").css("display","block");}
                     else{
                        $(".display-const-error").html("Technical error!!");
                        $(".display-const-error").css("display","block");}
                } else {
                    $(".display-const-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-const-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-const-error").html("Something Went Wrong!");
                $(".display-const-error").css("display","block");
                $('#const_response').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
        return false;
        }
    
function display_with_button(arr) {
$(arr).each(function(i) {
if('stateName' in arr[i]){
    $('#const_response').append('<div class="media p-3"><div class="media-body"><h5 class="m-3">'+arr[i].name+' ['+arr[i].stateName+']<button style="float:right;" data-toggle="modal" data-target="#resultmodal" class="btn submitbtn rounded-pill px-5" onclick="return getresult(\''+arr[i].name+'\');">Declare</button></h5></div></div>');
}
else{
     $('#const_response').append('<div class="media p-3"><div class="media-body"><h5 class="m-3">'+arr[i].name+'<button style="float:right;" data-toggle="modal" data-target="#resultmodal" class="btn submitbtn rounded-pill px-5" onclick="return getresult(\''+arr[i].name+'\');">Declare</button></h5></div></div>');
}
});
}
function display_without_button(arr) {
$(arr).each(function(i) {
if('stateName' in arr[i]){
    if(arr[i].tie===true){
            $('#tie_msg').html('THERE IS A TIE FOR WINNING POSITION.');
            $('#const_response').append('<div class="media border border-warning p-3"><div class="media-body"><h5 class="m-3">'+arr[i].name+' ['+arr[i].stateName+']<small class="px-3 text-muted" style="float:right;"><i class="fas fa-check-circle"></i> Declared</small></h5></div></div>');
    }
    else{
        $('#const_response').append('<div class="media p-3"><div class="media-body"><h5 class="m-3">'+arr[i].name+' ['+arr[i].stateName+']<small class="px-3 text-muted" style="float:right;"><i class="fas fa-check-circle"></i> Declared</small></h5></div></div>');
    }
}
else{
     if(arr[i].tie===true){
            $('#tie_msg').html('THERE IS A TIE FOR WINNING POSITION.');
            $('#const_response').append('<div class="media border border-warning p-3"><div class="media-body"> <h5 class="m-3">'+arr[i].name+'<small class=" px-3 text-muted" style="float:right;"><i class="fas fa-check-circle"></i> DECLARED</small></h5></div></div>');
    }
    else{
        $('#const_response').append('<div class="media p-3"><div class="media-body"><h5 class="m-3">'+arr[i].name+'<small class=" px-3 text-muted" style="float:right;"><i class="fas fa-check-circle"></i> DECLARED</small></h5></div></div>');
    }
}
});
}

function getresult(name){
        var cname=name;
        var eid=sessionStorage.getItem("admin_eid");
        var etype=sessionStorage.getItem("admin_etype");
        var adminId=sessionStorage.getItem("adminID");
        alert(eid+''+etype+''+adminId+' '+cname);
        $('#result').html("<b>Loading response...Please Wait!</b>");
          $.ajax({
            type: "POST",
            url: "CalculateResult.php",
            dataType: "json",
            data: {adminId:adminId, electionId:eid, type:etype, conname:cname},
            success : function(data){
               $('#result').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.sub.success===true){
                         $('#result').html('<div class="alert alert-success">Result Has Been Declared!</div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".result-error").html("Unauthorised access!");
                        $(".result-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".result-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".result-error").css("display","block");
                        calllogout();}
                     else if(data.msg.validType===false){
                        $(".result-error").html("Invalid Election Type!");
                        $(".result-error").css("display","block");}
                     else if(data.msg.validElection===false){
                        $(".result-error").html("Invalid Election ID!");
                        $(".result-error").css("display","block");}
                    else if(data.msg.validConstituency===false){
                        $(".result-error").html("Invalid Constituency name!");
                        $(".result-error").css("display","block");}
                    else if(data.msg.validResult===false){
                        $(".result-error").html("This result has already been declared!");
                        $(".result-error").css("display","block");}
                    else if(data.msg.sub.validInternalAuth===false){
                        $(".result-error").html("Internal auth key is incorrect!");
                        $(".result-error").css("display","block");}
                    else if(data.msg.sub.validParentOp===false){
                        $(".result-error").html("Parent elections have not been updated!");
                        $(".result-error").css("display","block");}
                    else if(data.msg.sub.tie===false){
                        $(".result-error").html("There is a tie in this constituency!");
                        $(".result-error").css("display","block");}
                     else{
                        $(".result-error").html("Technical error!");
                        $(".result-error").css("display","block");}
                } else {
                    $(".result-error").html("<ul>"+data.msg+"</ul>");
                    $(".result-error").css("display","block");
                } 
            },
            error: function() {
                $(".result-error").html("Something Went Wrong!");
                $(".result-error").css("display","block");
                $('#result').html("<b>Loading failed! Click on 'Login' and Try Again</b>"); 
                } 
        });
     }


</script> 

</script>
</html>