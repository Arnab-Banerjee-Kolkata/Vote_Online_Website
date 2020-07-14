<?php
include 'includes/header.php'; 
?>
<body class="p-md-5 p-3 bodycolor">
<?php include 'includes/scripts.php'; ?>
<div id="screen">
<?php include 'includes/admin_navbar.php'; ?>
<section class="mainframe p-md-5 p-3">

<div class="text-center" style="min-height: 70vh;">
<h3 class="h3 heading mt-3 text-center">MODIFY ELECTION</h3>
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


<!--MODIFY LOK SABHA ELECTION-->
<div id="loksabhafrm" style="display:none;">
  <h4 class="heading primarytext">MODIFY LOK SABHA ELECTION</h4>

  <section id="parent_countryelections" style="display: none;">
  <h5 class="secondarytext">Select one of the Country Elections to Modify</h5>
  <div class="display-ls-country-error alert alert-danger" style="display:none;"></div>
  <div id="countryelections"></div>
  </section>

  <section id="parent_lok_stateelections" style="display: none;">
   <h5 class="secondarytext">Select one of the State Elections to Modify</h5>
   <div class="display-ls-state-error alert alert-danger" style="display:none;"></div>
   <div id="lok_stateelections"></div>
  </section>

  <section id="parent_lok_constituency" style="display: none;">
   <h5 class="secondarytext">Select one of the Constituencies to Modify</h5>
   <div class="display-ls-const-error alert alert-danger" style="display:none;"></div>
  <div id="lok_constituency"></div>
  </section>

  <section id="candidate_form" style="display: none;">
   <h5 class="secondarytext">Add Candidate</h5>
<form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group">
                  <label for="candidatename" class="my-2">Enter Candidate Name :</label>
                  <input type="text" maxlength="50" class="form-control rounded-pill navshadow" id="candidatename" name="candidatename" required>
 </div>
 <div id="display-ls-party-error alert alert-danger" style="display:none;"></div>
 <div id="partylist"></div>
 <button type="submit" id="addCandidate" class="btn box2 submitbtn rounded-pill px-5 m-3"> ADD </button>
 </form>
 <div class="display-ls-candy-error alert alert-danger" style="display:none;"></div>
   <div id="candidate_response"></div>
  </section>
</div>

<!--MODIFY VIDHAN SABHA ELECTION-->
<div id="vidhansabhafrm" style="display:none;">
  <h5 class="heading primarytext">MODIFY VIDHAN SABHA ELECTION</h5>

   <section id="parent_vidhan_stateelections" style="display: none;">
   <h5 class="secondarytext">Select one of the State Elections to Modify</h5>
   <div class="display-vs-state-error alert alert-danger" style="display:none;"></div>
  <div id="vidhan_stateelections"></div>
  </section>

  <section id="parent_vidhan_constituency" style="display: none;">
   <h5 class="secondarytext">Select one of the Constituencies to Modify</h5>
  <div class="display-vs-const-error alert alert-danger" style="display:none;"></div> 
  <div id="vidhan_constituency"></div>
  </section>

  <section id="VS_candidate_form" style="display: none;">
   <h5 class="secondarytext">Add Candidate</h5>
<form class="p-lg-5 p-3" action="#" method="post">
  <div class="form-group">
                  <label for="VS_candidatename" class="my-2">Enter Candidate Name :</label>
                  <input type="text" maxlength="50" class="form-control rounded-pill navshadow" id="VS_candidatename" name="VS_candidatename" required>
 </div>
 <div class="display-vs-party-error alert alert-danger" style="display:none;"></div>
 <div id="VS_partylist"></div>
 <button type="submit" id="VS_addCandidate" class="btn box2 submitbtn rounded-pill px-5 m-3"> ADD </button>
 </form>
 <div class="display-vs-candy-error alert alert-danger" style="display:none;"></div>
 <div id="VS_candidate_response"></div>
 </section> 
  
</div>

</div>
<div class="col-md-2"></div>
</div>
</div>
</section>
<?php include '../includes/footer.php'; ?>
</div>
<script>
$(document).ready(function() {

$("#type").change(function() {
var select = $("#type option:selected").val();
if(select=="loksabha"){
          $("#loksabhafrm").css("display","block");
          $("#vidhansabhafrm").css("display","none");
          var admin_id=sessionStorage.getItem("adminID");
           $("#parent_countryelections").css("display","block");
           $("#parent_lok_constituency").css("display","none");
           $("#parent_lok_stateelections").css("display","none");
           $("#candidate_form").css("display","none");
          $('#countryelections').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "country_elections.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){
               $('#countryelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){                        
                       $('#countryelections').html('<div class="row"><div class="col-md-2"></div><div class="col-md-8">');
                       display_country_elections(data.msg.elections);
                       $('#countryelections').append('</div><div class="col-md-2"></div></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-ls-country-error").html("Unauthorised access!");
                        $(".display-ls-country-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-ls-country-error").html("Invalid Admin or logged out Admin!");
                        $(".display-ls-country-error").css("display","block");
                        return calllogout(); }
                     else{
                        $(".display-ls-country-error").html("Technical error!");
                        $(".display-ls-country-error").css("display","block");}
                } else {
                    $(".display-ls-country-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-ls-country-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-ls-country-error").html("Something went wrong!");
                $(".display-ls-country-error").css("display","block");
                $('#countryelections').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
}
else if(select=="vidhansabha"){
          $("#loksabhafrm").css("display","none");
          $("#vidhansabhafrm").css("display","block");
         var admin_id=sessionStorage.getItem("adminID");
          $("#parent_vidhan_stateelections").css("display","block");
          $("#parent_vidhan_constituency").css("display","none");
          $("#VS_candidate_form").css("display","none");

          $('#vidhan_stateelections').html("<b>Loading response...Please Wait!</b>");
         $.ajax({
            type: "POST",
            url: "vidhan_state_elections.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){
               $('#vidhan_stateelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){                       
                       $('#vidhan_stateelections').html('<div class="row"><div class="col-md-2 col-lg-3"></div><div class="col-md-8 col-lg-6">');
                       display_vidhanstate_elections(data.msg.elections);
                       $('#vidhan_stateelections').append('</div><div class="col-md-2 col-lg-3"></div></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-vs-state-error").html("Unauthorised access!");
                        $(".display-vs-state-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-vs-state-error").html("Invalid Admin or logged out admin!");
                        $(".display-vs-state-error").css("display","block");
                        return calllogout(); }
                    else if(data.msg.validType===false){
                        $(".display-vs-state-error").html("Invalid Election Type!");
                        $(".display-vs-state-error").css("display","block");}
                    else if(data.msg.validElection===false){
                        $(".display-vs-state-error").html("Invalid Country Election ID!");
                        $(".display-vs-state-error").css("display","block");}
                    else{
                        $(".display-vs-state-error").html("Technical error!");
                        $(".display-vs-state-error").css("display","block");}
                } else {
                    $(".display-vs-state-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-vs-state-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-vs-state-error").html("Something went wrong");
                $(".display-vs-state-error").css("display","block");
                $('#vidhan_stateelections').html("<b>Loading failed! Try Again</b>"); 
                } 
        });

}

});

$('#addCandidate').click(function(e){
        e.preventDefault();       
        var name=$("#candidatename").val();
        var party=$("#partyselected").val();
        var admin_id=sessionStorage.getItem("adminID");
        var stateElectionId=sessionStorage.getItem("stateID_modify");
        var constituencyname=sessionStorage.getItem("constituency_modify");
        $('#candidate_response').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "addCandidate.php",
            dataType: "json",
            data: {name:name, stateElectionId:stateElectionId, constituencyname:constituencyname, party:party, admin_id:admin_id},
            success : function(data){
               $('#candidate_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       $('#candidate_response').html('<b><div class="alert alert-success">Candidate with ID: '+data.msg.candidateId+' has been successfully added.</div></b>'); 
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-ls-candy-error").html("Unauthorised access!");
                        $(".display-ls-candy-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-ls-candy-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".display-ls-candy-error").css("display","block");
                        return calllogout();}
                     else if(data.msg.validParty===false){
                        $(".display-ls-candy-error").html("Invalid Party!");
                        $(".display-ls-candy-error").css("display","block");}
                     else if(data.msg.validElection===true){
                        $(".display-ls-candy-error").html("Invalid Election!");
                        $(".display-ls-candy-error").css("display","block");}
                    else if(data.msg.validConstituency===true){
                        $(".display-ls-candy-error").html("Invalid Constituency!");
                        $(".display-ls-candy-error").css("display","block");}
                    else if(data.msg.validCandidate===true){
                        $(".display-ls-candy-error").html("Candidate has already been added!");
                        $(".display-ls-candy-error").css("display","block");}
                     else{
                        $(".display-ls-candy-error").html("Technical Error!");
                        $(".display-ls-candy-error").css("display","block");}
                } else {
                    $(".display-ls-candy-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-ls-candy-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-ls-candy-error").html("Something Went Wrong!");
                $(".display-ls-candy-error").css("display","block");
                $('#candidate_response').html("<b>Loading failed! Click on 'ADD' and Try Again</b>"); 
                } 
        });
});

$('#VS_addCandidate').click(function(e){
        e.preventDefault();
        var name=$("#VS_candidatename").val();
        var party=$("#vspartyselected").val();
        var admin_id=sessionStorage.getItem("adminID");
        var stateElectionId=sessionStorage.getItem("VS_stateID_modify");
        var constituencyname=sessionStorage.getItem("VS_constituency_modify");
        $('#VS_candidate_response').html("<b>Loading response...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "addCandidate.php",
            dataType: "json",
            data: {name:name, stateElectionId:stateElectionId, constituencyname:constituencyname, party:party, admin_id:admin_id},
            success : function(data){
               $('#VS_candidate_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                       $('#VS_candidate_response').html('<b><div class="alert alert-success">Candidate with ID: '+data.msg.candidateId+' has been successfully added.</div></b>'); 
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-vs-candy-error").html("Unauthorised access!");
                        $(".display-vs-candy-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-vs-candy-error").html("Incorrect Admin ID or Admin already logged in!");
                        $(".display-vs-candy-error").css("display","block");
                        return calllogout();}
                     else if(data.msg.validParty===false){
                        $(".display-vs-candy-error").html("Invalid Party!");
                        $(".display-vs-candy-error").css("display","block");}
                     else if(data.msg.validElection===true){
                        $(".display-vs-candy-error").html("Invalid Election!");
                        $(".display-vs-candy-error").css("display","block");}
                    else if(data.msg.validConstituency===true){
                        $(".display-vs-candy-error").html("Invalid Constituency!");
                        $(".display-vs-candy-error").css("display","block");}
                    else if(data.msg.validCandidate===true){
                        $(".display-vs-candy-error").html("Candidate has already been added!");
                        $(".display-vs-candy-error").css("display","block");}
                     else{
                        $(".display-vs-candy-error").html("Technical Error!");
                        $(".display-vs-candy-error").css("display","block");}
                } else {
                    $(".display-vs-candy-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-vs-candy-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-vs-candy-error").html("Something Went Wrong!");
                $(".display-vs-candy-error").css("display","block");
                $('#VS_candidate_response').html("<b>Loading failed! Click on 'ADD' and Try Again</b>"); 
                } 
        });
});
});
function display_country_elections(arr) {
$(arr).each(function(i) { 
$("#countryelections").append('<div width="100%" class="my-3" style="cursor:pointer;"><a onclick="showstateid('+arr[i].electionId+')"><h5 class="text-left h5 my-2 py-2"><i class="far fa-hand-point-right"></i> &nbsp;' +arr[i].name+' ['+arr[i].year+']</h5></a></div>');
});
}

function showstateid(id){
  var cid=id;
  $("#parent_lok_stateelections").css("display","block");
  $("#parent_countryelections").css("display","none");
  $("#parent_lok_constituency").css("display","none");
  var admin_id=sessionStorage.getItem("adminID");
          $('#lok_stateelections').html("Loading response...Please Wait!</b>");
            $.ajax({
            type: "POST",
            url: "lok_state_elections.php",
            dataType: "json",
            data: {cid:cid,admin_id:admin_id},
            success : function(data){
               $('#lok_stateelections').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                         
                       $('#lok_stateelections').html('<div class="row"><div class="col-md-2 col-lg-3"></div><div class="col-md-8 col-lg-6">');
                       display_lokstate_elections(data.msg.elections);
                       $('#lok_stateelections').append('</div><div class="col-md-2 col-lg-3"></div></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-ls-state-error").html("Unauthorised access!");
                        $(".display-ls-state-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-ls-state-error").html("Invalid Admin or logged out admin!");
                        $(".display-ls-state-error").css("display","block");
                        return calllogout(); }
                    else if(data.msg.validType===false){
                        $(".display-ls-state-error").html("Invalid Election Type!");
                        $(".display-ls-state-error").css("display","block");}
                    else if(data.msg.validElection===false){
                        $(".display-ls-state-error").html("Invalid Country Election ID!");
                        $(".display-ls-state-error").css("display","block");}
                    else{
                        $(".display-ls-state-error").html("Technical error!");
                        $(".display-ls-state-error").css("display","block");}
                } else {
                    $(".display-ls-state-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-ls-state-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-ls-state-error").html("Something went wrong");
                $(".display-ls-state-error").css("display","block");
                $('#lok_stateelections').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
 }
function display_lokstate_elections(arr) {
$(arr).each(function(i) { 
$("#lok_stateelections").append('<div width="100%" class="my-3" style="cursor:pointer;"><a onclick="showconstituencies('+arr[i].electionId+')"><h5 class="text-left h5 my-2 py-2"><i class="far fa-hand-point-right"></i> &nbsp;'+ arr[i].stateName+' ('+arr[i].stateCode+' ) - '+arr[i].year+'</h5></a></div>');
});
}

function showconstituencies(id){
  var sid=id;
  sessionStorage.setItem("stateID_modify", sid);
  $("#parent_lok_constituency").css("display","block");
  $("#parent_lok_stateelections").css("display","none");
  $("#parent_countryelections").css("display","none");
  var admin_id=sessionStorage.getItem("adminID");
          $('#lok_constituency').html("<b>Loading response...Please Wait!</b>");
          $.ajax({
            type: "POST",
            url: "lok_constituency.php",
            dataType: "json",
            data: {sid:sid,admin_id:admin_id},
            success : function(data){
               $('#lok_constituency').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       $('#lok_constituency').html('<div class="row"><div class="col-md-2 col-lg-3"></div><div class="col-md-8 col-lg-6">');
                       display_lokconstituencies(data.msg.constituencyList);
                       $('#lok_constituency').append('</div><div class="col-md-2 col-lg-3"></div></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-ls-const-error").html("Unauthorised access!");
                        $(".display-ls-const-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-ls-const-error").html("Invalid Admin or logged out admin!");
                        $(".display-ls-const-error").css("display","block");
                        return calllogout(); }                   
                    else if(data.msg.validElection===false){
                        $(".display-ls-const-error").html("Invalid State Election ID!");
                        $(".display-ls-const-error").css("display","block");}
                    else{
                        $(".display-ls-const-error").html("Technical error!");
                        $(".display-ls-const-error").css("display","block");}
                } else {
                    $(".display-ls-const-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-ls-const-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-ls-const-error").html("Something went wrong!");
                $(".display-ls-const-error").css("display","block");
                $('#lok_constituency').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
 }
function display_lokconstituencies(arr) {
$(arr).each(function(i) { 
$("#lok_constituency").append('<div width="100%" class="my-3" style="cursor:pointer;"><a onclick="candidatefrm(\''+arr[i]+'\')"><h5 class="text-left h5 my-2 py-2"><i class="far fa-hand-point-right"></i> &nbsp;'+arr[i]+'</h5></a></div>');
});
}

function candidatefrm(value){
  var consti=value;
  $(".display-ls-candy-error").css("display","none");
  $("#candidate_response").html(" ");
  sessionStorage.setItem("constituency_modify", consti);
  $("#candidate_form").css("display","block");
  $("#parent_lok_constituency").css("display","none");
  var admin_id=sessionStorage.getItem("adminID");
  $('#partylist').html("<b>Loading response......Please Wait!</b>");
             $.ajax({
            type: "POST",
            url: "display_party.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){
            $('#partylist').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       $('#partylist').html('<div class="form-group"><label for="partyselected" class="my-2">Select Party:</label><select class="form-control rounded-pill navshadow border-0" id="partyselected" name="partyselected" required><option value="-1">SELECT PARTY</option>');
                       display_partylist(data.msg.partyList);
                       $('#partylist').append('</select></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-ls-party-error").html("Unauthorised access!");
                        $(".display-ls-party-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-ls-party-error").html("Invalid Admin or logged out Admin!");
                        $(".display-ls-party-error").css("display","block");
                        return calllogout(); }                   
                    else{
                        $(".display-ls-party-error").html("Technical error!");
                        $(".display-ls-party-error").css("display","block");}
                } else {
                    $(".display-ls-party-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-ls-party-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-ls-party-error").html("Something went wrong");
                $(".display-ls-party-error").css("display","block");
                $('#partylist').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
 }
function display_partylist(arr){
    $(arr).each(function(i) { 
            optionText = arr[i].name; 
            optionValue =arr[i].name;  
            $('#partyselected').append(new Option(optionText, optionValue)); 
    });   
}

function display_vidhanstate_elections(arr) {
$(arr).each(function(i) { 
$("#vidhan_stateelections").append('<div width="100%" class="my-3" style="cursor:pointer;"><a onclick="VS_showconstituencies('+arr[i].electionId+')"><h5 class="text-left h5 my-2 py-2"><i class="far fa-hand-point-right"></i> &nbsp;'+ arr[i].name+' - '+arr[i].year+' [<small>'+arr[i].stateName+' ('+arr[i].stateCode+' )</small> ]</h5></a></div>');
});
}

function VS_showconstituencies(id){
  var sid=id;
  sessionStorage.setItem("VS_stateID_modify", sid);
  $("#parent_vidhan_constituency").css("display","block");
  $("#parent_vidhan_stateelections").css("display","none");
  var admin_id=sessionStorage.getItem("adminID");
  $('#vidhan_constituency').html("<b>Loading response...</b>");
          $.ajax({
            type: "POST",
            url: "vidhan_constituency.php",
            dataType: "json",
            data: {sid:sid,admin_id:admin_id},
            success : function(data){
               $('#vidhan_constituency').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       $('#vidhan_constituency').html('<div class="row"><div class="col-md-2 col-lg-3"></div><div class="col-md-8 col-lg-6">');
                       display_vidhanconstituencies(data.msg.constituencyList);
                       $('#vidhan_constituency').append('</div><div class="col-md-2 col-lg-3"></div></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-vs-const-error").html("Unauthorised access!");
                        $(".display-vs-const-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-vs-const-error").html("Invalid Admin or logged out admin!");
                        $(".display-vs-const-error").css("display","block");
                        return calllogout(); }                   
                    else if(data.msg.validElection===false){
                        $(".display-vs-const-error").html("Invalid State Election ID!");
                        $(".display-vs-const-error").css("display","block");}
                    else{
                        $(".display-vs-const-error").html("Technical error!");
                        $(".display-vs-const-error").css("display","block");}
                } else {
                    $(".display-vs-const-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-vs-const-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-vs-const-error").html("Something went wrong!");
                $(".display-vs-const-error").css("display","block");
                $('#vidhan_constituency').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
 }

 function display_vidhanconstituencies(arr) {
$(arr).each(function(i) { 
$("#vidhan_constituency").append('<div width="100%" class="my-3" style="cursor:pointer;"><a onclick="VS_candidatefrm(\''+arr[i]+'\')"><h5 class="text-left h5 my-2 py-2"><i class="far fa-hand-point-right"></i> &nbsp;'+arr[i]+'</h5></a></div>');
});
}

 function VS_candidatefrm(value){
  var consti=value;
  $(".display-vs-candy-error").css("display","none");
  $("#VS_candidate_response").html(" ");
  sessionStorage.setItem("VS_constituency_modify", consti);
  $("#VS_candidate_form").css("display","block");
  $("#parent_vidhan_constituency").css("display","none");
  var admin_id=sessionStorage.getItem("adminID");
  $('#VS_partylist').html("<b>Loading response......Please Wait!</b>");
            $.ajax({
            type: "POST",
            url: "display_party.php",
            dataType: "json",
            data: {admin_id:admin_id},
            success : function(data){
            $('#VS_partylist').html("<b>Loaded Successfully!</b>"); 
               if (data.code === 11){
                     if(data.msg.success===true){
                       $('#VS_partylist').html('<div class="form-group"><label for="partyselected" class="my-2">Select Party:</label><select class="form-control rounded-pill navshadow border-0" id="vspartyselected" name="vspartyselected" required><option value="-1">SELECT PARTY</option>');
                       vsdisplay_partylist(data.msg.partyList);
                       $('#VS_partylist').append('</select></div>');
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-vs-party-error").html("Unauthorised access!");
                        $(".display-vs-party-error").css("display","block");}
                     else if(data.msg.validAdmin===false){
                        $(".display-vs-party-error").html("Invalid Admin or logged out Admin!");
                        $(".display-vs-party-error").css("display","block");
                        return calllogout(); }                   
                    else{
                        $(".display-vs-party-error").html("Technical error!");
                        $(".display-vs-party-error").css("display","block");}
                } else {
                    $(".display-vs-party-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-vs-party-error").css("display","block");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".display-vs-party-error").html("Something went wrong!");
                $(".display-vs-party-error").css("display","block");
                $('#VS_partylist').html("<b>Loading failed! Try Again</b>"); 
                } 
        });
 }
function vsdisplay_partylist(arr){
    $(arr).each(function(i) { 
            optionText = arr[i].name; 
            optionValue =arr[i].name;  
            $('#vspartyselected').append(new Option(optionText, optionValue)); 
    });   
}
</script>
</body>
</html>