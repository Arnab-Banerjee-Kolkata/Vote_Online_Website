<?php
include 'includes/header.php'; 
?>
<body class="p-md-5 p-3 bodycolor">
<?php include 'includes/scripts.php'; ?>
<div id="screen">
<?php include 'includes/admin_navbar.php'; ?>
<section class="mainframe p-md-5 p-3">


<div class="row">
 <div class="col-lg-1"></div>
 <div class="col-lg-10 p-3 text-center">
            <h4 class="h4 heading mt-3 box1">ADD PARTY</h4>
            <div id="partyname_form">
           
            <form class="px-2 px-md-5 was-validated" action="#" method="post">
                <div class="form-group box2">
                  <label for="partyname" class="my-2">Create Party Name :</label>
                  <input type="text" maxlength="10" class="form-control rounded-pill navshadow" id="partyname" name="partyname" required style="text-transform:uppercase;">
                </div>
             <button type="submit" id="getSymbols" class="btn box3 submitbtn rounded-pill px-5 m-3">Create</button>
            </form>
            </div>
        
            <div id="symbol_form" style="display: none;">
             <div class="display-error alert alert-danger" style="display:none;"></div>
              <h6 class="h6 heading mt-3 box1">SELECT A PARTY SYMBOL</h6>
              <!-- The Modal -->
              <div class="modal" id="addpartymodal">
                <div class="modal-dialog  modal-lg">
                  <div class="modal-content text-dark">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" onclick="window.location.href='index.php';">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div id="party_response"></div>
                    <div class="display-party-error alert alert-danger" style="display:none;"></div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-dismiss="modal" onclick="window.location.href='index.php';">Close</button>
                    </div>

                  </div>
                </div>
              </div>
              <div id="symbol_response"></div>
              
            </div>
            
        
 </div>
<div class="col-lg-1"></div>
</div>   
</div>

</section>
<?php include '../includes/footer.php'; ?>
</div>
<script type="text/javascript">

$(document).ready(function() {
      $('#getSymbols').click(function(e){
        e.preventDefault();
        showSymbols();
        var name = $("#partyname").val();
        var party_name = name.toUpperCase();
       // alert(party_name);
        sessionStorage.setItem("PartyName", party_name);
        var admin_id=sessionStorage.getItem("adminID");
        $('#symbol_response').html("<b>Loading response...Please wait!</b>");
        $.ajax({
            type: "POST",
            url: "getPartySymbols.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data)
            {              
               $('#symbol_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){                      
                       display_symbols(data.msg.symbolList);                    
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".display-error").css("display","block");
                        return calllogout();}
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
                $('#symbol_response').html("<b>Loading failed! Click on 'Login' and Try Again</b>"); 
                } 
        });
});
});
function showSymbols(){
 $("#symbol_form").css("display","block");
 $("#partyname_form").css("display","none");
}

function display_symbols(arr) {
$('#symbol_response').html('<div class="row">'); 
$(arr).each(function(i) {
if(arr[i].status==0){
    $('#symbol_response').append('<div class="col-lg-2 col-md-3 col-6" style="float:left" data-toggle="modal" data-target="#addpartymodal" onclick=selectSymbols(\''+arr[i].path+'\');><img class="img-fluid navshadow" src="'+arr[i].path+'" alt="Party Symbol" style="width:100%;height:200px;"><div class="heading bg-success pt-3 pb-2 navshadow"><h5>USE</h5></div></div>');
}
else if(arr[i].status==1){
   $('#symbol_response').append('<div class="col-lg-2 col-md-3 col-6" style="float:left"><img class="img-fluid navshadow" src="'+arr[i].path+'" alt="Party Symbol" style="width:100%;height:200px;opacity:0.6;"><div class="heading bg-secondary pt-3 pb-2 navshadow"><h5>TAKEN</h5></div></div>');
}
});
}

function selectSymbols(path){
  var imgpath=path;
  var party_name=sessionStorage.getItem("PartyName");
  var adminId=sessionStorage.getItem("adminID");
  $('#party_response').html("<b>Loading response...Please wait!</b>");
     $.ajax({
            type: "POST",
            url: "addParty.php",
            dataType: "json",
            data: {partyName:party_name,admin_id:adminId,symbol:imgpath},
            success : function(data)
            {              
               $('#party_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){                      
                       $('#party_response').html('<div class="alert alert-success">Party has been added!</div>');                    
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-party-error").html("Unauthorised access!");
                        $(".display-party-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-party-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".display-party-error").css("display","block");
                        return calllogout();}
                    else if(data.msg.validName===false){
                        $(".display-party-error").html("Party name is already taken!");
                        $(".display-party-error").css("display","block");}
                     else if(data.msg.validSymbol===false){
                        $(".display-party-error").html("Symbol path is already taken!");
                        $(".display-party-error").css("display","block");}
                     else{
                        $(".display-party-error").html("Technical Error!");
                        $(".display-party-error").css("display","block");}
                } else {
                    $(".display-party-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-party-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-party-error").html("Something Went Wrong!");
                $(".display-party-error").css("display","block");
                $('#party_response').html("<b>Loading failed! Click on 'Login' and Try Again</b>"); 
                } 
        });
}     
</script>

</body>
</html>
