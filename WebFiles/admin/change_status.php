<?php
include 'includes/header.php'; 
?>
<style>
.butt{width:180px;}
.disabled:active{transform: translateY(0px);}
.disabled:hover{background-color:#d9534f;}
.nav .nav-item .row .col-md-4 .activestyle{background-color: '#ffc14d';}
</style>
<body class="p-md-5 p-3 bodycolor">
<?php include 'includes/scripts.php'; ?>
<div id="screen">
<?php include 'includes/admin_navbar.php'; ?>

<section class="mainframe p-md-5 p-3">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10 py-5">
  <div class="text-center" style="min-height: 70vh;">
  <h4 class="h4 heading mt-3 box1">CHANGE ELECTION STATUS</h4>

<ul class="nav nav-pills">
  <li class="nav-item mx-2" id="countrycard">
    <a class="nav-link active" href="#">PUBLIC ELECTIONS</a>
  </li>
  <li class="nav-item mx-2" id="statecard" style="display:none;">
    <a class="nav-link" href="#">STATE LEVEL</a>
  </li>
  <li class="nav-item mx-2" id="phasecard" style="display:none;">
    <a class="nav-link" href="#">PHASE LEVEL</a>
  </li>
</ul>
    <!--COUNTRY ELECTIONS-->
    <div id="country">
            <div class="country_errors alert alert-danger" style="display: none;"></div>
            <div id="countryelections"></div>
    </div>


   <!--STATE ELECTIONS-->
    <div id="state" style="display:none;">
            <h6 class="heading my-3 text-right primarytext"><span class="ename"></span></h6>
            <div class="state_errors alert alert-danger" style="display: none;"></div>
            <div id="stateelections"></div>
    </div>


<!--PHASE ELECTION-->
    <div id="phase" style="display:none;">
           <h6 class="heading my-3 text-right primarytext"><span class="ename"></span></h6>
           <div class="phase_errors alert alert-danger" style="display: none;"></div>
           <div id="phaseelections"></div>
    </div>


  </div>
</div>
</div>

</section>
<?php include '../includes/footer.php'; ?>
</div>
<script type="text/javascript">
function updateName(name){
    $('.ename').html(name);
}
  $(document).ready(function() {
        var dummy='dummy';
        $('#countryelections').html("<b>Loading public elections...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "GetPublicElections.php",
            dataType: "json",
            data: {dummy:dummy},
            success : function(data){
               $('#countryelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       display_countryElections(data.msg.elections);
                     }
                     else if(data.msg.validAuth===false){
                        $(".country_errors").html("Unauthorised access!");
                        $(".country_errors").css("display","block");}
                     else{
                        $(".country_errors").html("Technical Issue!");
                        $(".country_errors").css("display","block");}
                } else {
                    $(".country_errors").html("<ul>"+data.msg+"</ul>");
                    $(".country_errors").css("display","block");
                } 
            },
            error: function() {
                $(".country_errors").html("Something Went Wrong!");
                $(".country_errors").css("display","block");
                $('#countryelections').html("<b>Loading failed! Please Refresh the page and Try Again</b>"); 
                } 
      });
  });

function display_countryElections(arr) {
$('#countryelections').html('<div class="table-responsive"><table class="table table-striped" id="tab_logic"><thead class="text-primary"><tr><th>ELECTION NAME</th><th>ELECTION TYPE</th><th>ELECTION YEAR</th><th>ELECTION STATUS &nbsp;</th><th></th></tr></thead><tbody>'); 
$(arr).each(function(i) {
     switch (arr[i].status) { 
	case 0: 
		var statustext="PENDING";
        var clss='btn-primary';
		break;
    case 1: 
		var statustext="LIVE";
        var clss='btn-success';
		break;    
	case 2: 
		var statustext="RESULT PENDING";
        var clss='btn-warning';
		break;
	case 3: 
		var statustext="RESULT DECLARED";
        var clss='btn-info';
		break;		
	case 4: 
		var statustext="CANCELLED";
        var clss='btn-danger disabled';
		break;
    case 5: 
		var statustext="TIE IN A CONSTITUENCY";
        var clss='btn-danger';
		break;    
	default:
		alert('Something went wrong!Please Refresh and try again');
     }
    if(arr[i].type=="LOK SABHA"){
        if(arr[i].status=='0' || arr[i].status=='1' || arr[i].status=='2' || arr[i].status=='4' || arr[i].status=='5')    
    $('#tab_logic').append('<tr><td>'+arr[i].name+'</td><td>'+arr[i].type+'</td><td>'+arr[i].year+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-danger" onclick="change(4,\''+arr[i].electionId+'\',\''+arr[i].type+'\');" data-toggle="modal" data-target="#statusModal" style="cursor:pointer;">CANCELLED</a></div></div></td><td><a href="#" onclick="showstateform('+arr[i].electionId+');updateName(\''+arr[i].name+'\');">View State Elections</a></td></tr>');
    }
    else{
        if(arr[i].status=='0' || arr[i].status=='1' || arr[i].status=='2' || arr[i].status=='4' || arr[i].status=='5')    
    $('#tab_logic').append('<tr><td>'+arr[i].name+' [<span class="primarytext">'+arr[i].stateName+'</span>]</td><td>'+arr[i].type+'</td><td>'+arr[i].year+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-danger" onclick="change(4,\''+arr[i].electionId+'\',\''+arr[i].type+'\');" data-toggle="modal" data-target="#statusModal" style="cursor:pointer;">CANCELLED</a></div></div></td><td><a href="#" onclick="showphaseform(\''+arr[i].electionId+'\',\''+arr[i].type+'\');updateName(\''+arr[i].name+'\');">View Phase Elections</a></td></tr>');
       }
});
$('#countryelections').append('</tbody></table></div>');
}
function change(status,eid,type){
   // alert(status);
   switch (status) { 
	case 1: 
		var text="LIVE";
		break;
	case 2: 
		var text="RESULT PENDING";
		break;
	case 3: 
		var text="RESULT DECLARED";
		break;		
	case 4: 
		var text="CANCELLED";
		break;
	default:
		alert('Something went wrong!Please Refresh and try again');
}
    $('#countryelections').append('<div class="modal text-dark" id="statusModal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Confirmation!</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body">Are you sure you want to change the status to \''+text+'\'?</div><div class="modal-footer"><input type="submit" class="btn submitbtn rounded-pill navshadow px-5 m-1" value="Proceed" name=" " onclick="changecountrystatus(\''+status+'\',\''+eid+'\',\''+type+'\');" data-dismiss="modal" /><button type="button" class="btn backbtn rounded-pill px-5 m-1" data-dismiss="modal">Cancel</button></div></div></div></div>');
}
function changecountrystatus(status,eid,type){
    var status=status;
    var eid = eid;
   // alert(status+' '+eid);
    var admin_id=sessionStorage.getItem("adminID");
    if(type=="LOK SABHA")
    var level='COUNTRY';
    else
    var level='STATE';
    //alert('Request:admin id: '+admin_id+' status: '+status+' election id: '+eid+' level: '+level);
        $.ajax({
            type: "POST",
            url: "ChangeElectionStatus.php",
            dataType: "json",
            data: {admin_id:admin_id,status:status,eid:eid,level:level},
            success : function(data){
               if (data.code===11){
                     if(data.msg.success===true){
                       alert('Status changed successfully!');
                       location.reload();
                     }
                     else if(data.msg.validAuth===false){
                        alert("Unauthorised access!");}
                     else if(data.msg.validAdmin===false){
                       alert("Incorrect Admin ID or logged out admin!");
                       calllogout();
                        }
                     else if(data.msg.validLevel===false){
                        alert("Invalid Election Type!");}
                     else if(data.msg.validElection===false){
                        alert("Invalid Election ID");}
                     else if(data.msg.validStatus===false){
                        alert("Election cannot be changed to new status!");}
                     else{
                        alert("Technical Error! Please Try Again.");}
                } else {
                   alert(data.msg);
                } 
            },
            error: function() {
                alert("Something went wrong! Please Try Again.");
                } 
        });
}

function showstateform(id){
  sessionStorage.setItem("currentCountryId", id);
  $("#statecard a").addClass("active");
  $("#countrycard a").removeClass("active");
  $("#country").css("display","none");
  $("#phasecard a").removeClass("active");
  $("#phase").css("display","none");
  $("#state").css("display","block");
  $("#statecard").css("display","block");
  $('#countrycard').click(function(){
         location.reload();
      });
  var admin_id=sessionStorage.getItem("adminID");
  var countryid=id;
  var type="LOK SABHA";
  $('#stateelections').html("<b>Loading state elections...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "GetStateElections.php",
            dataType: "json",
            data: {admin_id:admin_id,type:type,countryid:countryid},
            success : function(data){
               $('#stateelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       display_stateElections(data.msg.elections);
                     }
                     else if(data.msg.validAuth===false){
                        $(".state_errors").html("Unauthorised access!");
                        $(".state_errors").css("display","block");}
                    else if(data.msg.validAdmin===false){
                        $(".state_errors").html("Invalid Admin or logged out Admin!");
                        $(".state_errors").css("display","block");
                        calllogout();}
                    else if(data.msg.validType===false){
                        $(".state_errors").html("Invalid Election Type!");
                        $(".state_errors").css("display","block");}
                    else if(data.msg.validElection===false){
                        $(".state_errors").html("Invalid Country Election ID!");
                        $(".state_errors").css("display","block");}
                     else{
                        $(".state_errors").html("Technical Issue!");
                        $(".state_errors").css("display","block");}
                } else {
                    $(".state_errors").html("<ul>"+data.msg+"</ul>");
                    $(".state_errors").css("display","block");
                } 
            },
            error: function() {
                $(".state_errors").html("Something Went Wrong!");
                $(".state_errors").css("display","block");
                $('#stateelections').html("<b>Loading failed! Please Refresh the page and Try Again</b>"); 
                } 
      });
 } 

function display_stateElections(arr) {
$('#stateelections').html('<div class="table-responsive"><table class="table table-striped" id="state_table"><thead class="text-primary"><tr><th>ELECTION STATE</th><th>ELECTION YEAR</th><th>ELECTION STATUS &nbsp;</th><th></th></tr></thead><tbody>'); 
$(arr).each(function(i) {
     switch (arr[i].status) { 
	case 0: 
		var statustext="PENDING";
        var clss='btn-primary';
		break;
    case 1: 
		var statustext="LIVE";
        var clss='btn-success';
		break;    
	case 2: 
		var statustext="RESULT PENDING";
        var clss='btn-warning';
		break;
	case 3: 
		var statustext="RESULT DECLARED";
        var clss='btn-info';
		break;		
	case 4: 
		var statustext="CANCELLED";
        var clss='btn-danger disabled';
		break;
    case 5: 
		var statustext="TIE IN A CONSTITUENCY";
        var clss='btn-danger';
		break;    
	default:
		alert('Something went wrong!Please Refresh and try again');
     }
    
if(arr[i].status=='0' || arr[i].status=='1' || arr[i].status=='2' || arr[i].status=='4' || arr[i].status=='5')    
    $('#state_table').append('<tr><td>'+arr[i].stateName+'('+arr[i].stateCode+')</td><td>'+arr[i].year+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-danger" onclick="changestate(4,\''+arr[i].electionId+'\');" data-toggle="modal" data-target="#statestatusModal" style="cursor:pointer;">CANCELLED</a></div></div></td><td><a href="#" onclick="showphaseform(\''+arr[i].electionId+'\',\'LOK SABHA\');">View Phase Elections</a></td></tr>');
});
$('#stateelections').append('</tbody></table></div>');
}

function changestate(status,eid){
   // alert(status);
   switch (status) { 
	case 1: 
		var text="LIVE";
		break;
	case 2: 
		var text="RESULT PENDING";
		break;
	case 3: 
		var text="RESULT DECLARED";
		break;		
	case 4: 
		var text="CANCELLED";
		break;
	default:
		alert('Something went wrong!Please Refresh and try again');
}
    $('#stateelections').append('<div class="modal text-dark" id="statestatusModal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Confirmation!</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body">Are you sure you want to change the status to \''+text+'\'?</div><div class="modal-footer"><input type="submit" class="btn submitbtn rounded-pill navshadow px-5 m-1" value="Proceed" name=" " onclick="changestatestatus(\''+status+'\',\''+eid+'\');" data-dismiss="modal" /><button type="button" class="btn backbtn rounded-pill px-5 m-1" data-dismiss="modal">Cancel</button></div></div></div></div>');
}
function changestatestatus(status,eid){
    var status=status;
    var eid = eid;
   // alert(status+' '+eid);
    var admin_id=sessionStorage.getItem("adminID");
    var level='STATE';
    //alert('Request:admin id: '+admin_id+' status: '+status+' election id: '+eid+' level: '+level);
        $.ajax({
            type: "POST",
            url: "ChangeElectionStatus.php",
            dataType: "json",
            data: {admin_id:admin_id,status:status,eid:eid,level:level},
            success : function(data){
               if (data.code===11){
                     if(data.msg.success===true){
                       alert('Status changed successfully!');
                       var countryid=sessionStorage.getItem("currentCountryId");
                       showstateform(countryid);
                     }
                     else if(data.msg.validAuth===false){
                        alert("Unauthorised access!");}
                     else if(data.msg.validAdmin===false){
                       alert("Incorrect Admin ID or logged out admin!");
                       calllogout();
                        }
                     else if(data.msg.validLevel===false){
                        alert("Invalid Election Type!");}
                     else if(data.msg.validElection===false){
                        alert("Invalid Election ID");}
                     else if(data.msg.validStatus===false){
                        alert("Election cannot be changed to new status!");}
                     else{
                        alert("Technical Error! Please Try Again.");}
                } else {
                   alert(data.msg);
                } 
            },
            error: function() {
                alert("Something went wrong! Please Try Again.");
                } 
        });
}

function showphaseform(stateid,type){
  sessionStorage.setItem("currentStateId",stateid);
  sessionStorage.setItem("currentType",type);
  $("#phasecard a").addClass("active");
  $("#countrycard a").removeClass("active");
  $("#statecard a").removeClass("active");
  $("#country").css("display","none");
  $("#state").css("display","none");
  $("#phase").css("display","block");
  $("#phasecard").css("display","block");
   $('#countrycard').click(function(){
         location.reload();
      });
   $('#statecard').click(function(){
       var countryid=sessionStorage.getItem("currentCountryId");
       showstateform(countryid);
      });
  var admin_id=sessionStorage.getItem("adminID");
  var stateid=stateid;
  var type=type;
  $('#phaseelections').html("<b>Loading phase elections...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "GetPhaseElections.php",
            dataType: "json",
            data: {admin_id:admin_id,type:type,stateid:stateid},
            success : function(data){
               $('#phaseelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       display_phaseElections(data.msg.phaseElections);
                     }
                     else if(data.msg.validAuth===false){
                        $(".phase_errors").html("Unauthorised access!");
                        $(".phase_errors").css("display","block");}
                    else if(data.msg.validAdmin===false){
                        $(".phase_errors").html("Invalid Admin or logged out Admin!");
                        $(".phase_errors").css("display","block");
                        calllogout();}
                    else if(data.msg.validType===false){
                        $(".phase_errors").html("Invalid Election Type!");
                        $(".phase_errors").css("display","block");}
                    else if(data.msg.validElection===false){
                        $(".phase_errors").html("Invalid Country Election ID!");
                        $(".phase_errors").css("display","block");}
                     else{
                        $(".phase_errors").html("Technical Issue!");
                        $(".phase_errors").css("display","block");}
                } else {
                    $(".phase_errors").html("<ul>"+data.msg+"</ul>");
                    $(".phase_errors").css("display","block");
                } 
            },
            error: function() {
                $(".phase_errors").html("Something Went Wrong!");
                $(".phase_errors").css("display","block");
                $('#phaseelections').html("<b>Loading failed! Please Refresh the page and Try Again</b>"); 
                } 
      });
 } 
function display_phaseElections(arr) {
$('#phaseelections').html('<div class="table-responsive"><table class="table table-striped" id="phase_table"><thead class="text-primary"><tr><th>PHASE CODE</th><th>ELECTION STATUS &nbsp;</th><th></th></tr></thead><tbody>'); 
$(arr).each(function(i) {
     switch (arr[i].status) { 
	case 0: 
		var statustext="PENDING";
        var clss='btn-primary';
		break;
    case 1: 
		var statustext="LIVE";
        var clss='btn-success';
		break;    
	case 2: 
		var statustext="RESULT PENDING";
        var clss='btn-warning';
		break;
	case 3: 
		var statustext="RESULT DECLARED";
        var clss='btn-info';
		break;		
	case 4: 
		var statustext="CANCELLED";
        var clss='btn-danger disabled';
		break;
    case 5: 
		var statustext="TIE IN A CONSTITUENCY";
        var clss='btn-danger';
		break;    
	default:
		alert('Something went wrong!Please Refresh and try again');
     }
    
if(arr[i].status=='0')    
    $('#phase_table').append('<tr><td>'+arr[i].phaseCode+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-success" onclick="changephase(1,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">LIVE</a><a class="dropdown-item text-danger" onclick="changephase(4,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">CANCELLED</a></div></div></td></tr>');
else if(arr[i].status=='1')    
     $('#phase_table').append('<tr><td>'+arr[i].phaseCode+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-warning" onclick="changephase(2,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">RESULT PENDING</a><a class="dropdown-item text-danger" onclick="changephase(4,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">CANCELLED</a></div></div></td></tr>');
else if(arr[i].status=='5')    
     $('#phase_table').append('<tr><td>'+arr[i].phaseCode+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-info" onclick="changephase(3,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">RESULT DECLARED</a><a class="dropdown-item text-danger" onclick="changephase(4,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">CANCELLED</a></div></div></td></tr>');
else
     $('#phase_table').append('<tr><td>'+arr[i].phaseCode+'</td><td><div class="dropdown"><button type="button" class="btn butt '+clss+' dropdown-toggle text-white" data-toggle="dropdown">'+statustext+'</button><div class="dropdown-menu"><a class="dropdown-item text-danger" onclick="changephase(4,\''+arr[i].id+'\');" data-toggle="modal" data-target="#phasestatusModal" style="cursor:pointer;">CANCELLED</a></div></div></td></tr>');
});
$('#phaseelections').append('</tbody></table></div>');
}

function changephase(status,eid){
   // alert(status);
   switch (status) { 
	case 1: 
		var text="LIVE";
		break;
	case 2: 
		var text="RESULT PENDING";
		break;
	case 3: 
		var text="RESULT DECLARED";
		break;		
	case 4: 
		var text="CANCELLED";
		break;
	default:
		alert('Something went wrong!Please Refresh and try again');
}
    $('#phaseelections').append('<div class="modal text-dark" id="phasestatusModal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Confirmation!</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body">Are you sure you want to change the status to \''+text+'\'?</div><div class="modal-footer"><input type="submit" class="btn submitbtn rounded-pill navshadow px-5 m-1" value="Proceed" name=" " onclick="changephasestatus(\''+status+'\',\''+eid+'\');" data-dismiss="modal" /><button type="button" class="btn backbtn rounded-pill px-5 m-1" data-dismiss="modal">Cancel</button></div></div></div></div>');
}
function changephasestatus(status,eid){
    var status=status;
    var eid = eid;
   // alert(status+' '+eid);
    var admin_id=sessionStorage.getItem("adminID");
    var level='PHASE';
    //alert('Request:admin id: '+admin_id+' status: '+status+' election id: '+eid+' level: '+level);
        $.ajax({
            type: "POST",
            url: "ChangeElectionStatus.php",
            dataType: "json",
            data: {admin_id:admin_id,status:status,eid:eid,level:level},
            success : function(data){
               if (data.code===11){
                     if(data.msg.success===true){
                       alert('Status changed successfully!');
                       var id=sessionStorage.getItem("currentStateId");
                       var type=sessionStorage.getItem("currentType");
                       showphaseform(id,type);
                     }
                     else if(data.msg.validAuth===false){
                        alert("Unauthorised access!");}
                     else if(data.msg.validAdmin===false){
                       alert("Incorrect Admin ID or logged out admin!");
                       calllogout();
                        }
                     else if(data.msg.validLevel===false){
                        alert("Invalid Election Type!");}
                     else if(data.msg.validElection===false){
                        alert("Invalid Election ID");}
                     else if(data.msg.validStatus===false){
                        alert("Election cannot be changed to new status!");}
                     else{
                        alert("Technical Error! Please Try Again.");}
                } else {
                   alert(data.msg);
                } 
            },
            error: function() {
                alert("Something went wrong! Please Try Again.");
                } 
        });
}


</script>
</body>
</html>