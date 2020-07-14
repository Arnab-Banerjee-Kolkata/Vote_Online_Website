<?php
include './includes/header.php'; 
?>

<body class="p-md-5 p-3 bodycolor">
<?php include './includes/scripts.php'; ?>
<script>
function submit_soap(id,type,year){
        var id=id;
        var type=type;
        var year=year;
         var url = "showstatewiseresult.php?id=" + encodeURIComponent(id) + "&type=" + encodeURIComponent(type) + "&year=" + encodeURIComponent(year);
        window.location.href = url;
	}
</script>
<div id="screen">
<?php include './includes/booth_navbar.php';?> 
<section class="mainframe p-md-5 p-3">

<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-10">
<span id="lblData"></span>
<ul class="nav nav-pills justify-content-center">
  <li class="nav-item mx-2" id="overallcard">
    <a class="nav-link active" onclick="showoverallresult();">OVERALL RESULT CHART</a>
  </li><br>
  <li class="nav-item mx-2" id="statecard" style="display:none;">
    <a class="nav-link" onclick="showstateresult();">STATE LEVEL CHART</a>
  </li><br>
  <li class="nav-item mx-2" id="constcard" style="display:none;">
    <a class="nav-link" onclick="showconstresult();">CONSTITUENCY TREND</a>
  </li><br>
</ul>
<div class="display-error alert alert-danger my-3" style="display:none;"></div>
<div id="overallresultsection">
<div class="row">
<div class="col-sm-6">
<div id="piechart" style="width:100%; height: 500px;"></div> 
</div>
<div class="col-sm-6">
<div id="tablehead"></div>
<div id="table" style="text-align:center"></div>
</div>
</div>
</div>
<div id="conresultsection"></div>
    <div class="modal" id="constModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">Constituency Details</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body consadd"></div>
    <div class="modal-footer"><button type="button" class="btn" data-dismiss="modal">Close</button></div>
    </div></div></div>

</div>
<div class="col-sm-1"></div>
</div>

</section>
<?php include './includes/footer.php'; ?>
</div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
function submit_soap(id,type,year){
        var id=id;
        var type=type;
        var year=year;
        var url = "showstatewiseresult.php?id=" + encodeURIComponent(id) + "&type=" + encodeURIComponent(type) + "&year=" + encodeURIComponent(year);
        window.location.href = url;
  }

$(document).ready(function() {
   $('#addmoreitem').append('<li class="nav-item"><a class="nav-link active" href="govt_result.php"><i class="fas fa-chart-line"></i> ELECTION RESULTS</a></li>');
   var queryString = new Array(); 
    if (queryString.length == 0) {
            if (window.location.search.split('?').length > 1) {
                var params = window.location.search.split('?')[1].split('&');
                for (var i = 0; i < params.length; i++) {
                    var key = params[i].split('=')[0];
                    var value = decodeURIComponent(params[i].split('=')[1]);
                    queryString[key] = value;
                }
            }
        }
        if (queryString["id"] != null && queryString["type"] != null && queryString["year"] != null) {
            var data = '<h3 class="text-center heading my-3">'+ queryString["type"] +' ELECTION '+ queryString["year"]+' RESULT</h3><br>';4
             $("#lblData").html(data); 
            if(queryString["type"]=="LOK SABHA"){
                    var dummy='dummy';
                    $.ajax({
                    type: "POST",
                    url: "ShowStateList.php",
                    dataType: "json",
                    data: {dummy:dummy},
                    success : function(jdata){ 
                    if (jdata.code ===11){
                            if(jdata.msg.success===true){
                                display_states(jdata.msg.stateList);
                            }
                            else if(jdata.msg.validAuth===false){
                                $(".display-error").html("Unauthorised access!");
                                $(".display-error").css("display","block");}
                            else{
                                $(".display-error").html("Technical Error!");
                                $(".display-error").css("display","block");}
                            
                        } else {
                            $(".display-error").html("<ul>"+jdata.msg+"</ul>");
                            $(".display-error").css("display","block");
                        } 
                    },
                    error: function() {
                        $(".display-error").html("Something Went Wrong!");
                        $(".display-error").css("display","block"); 
                        } 
                });   
            }
            else if(queryString["type"]=="VIDHAN SABHA"){
                    $("#constcard").css("display","block");
            }
             
        }
        function display_states(arr){
            $("#lblData").append('<div class="text-center" id="statelist"><select class="form-control mb-2 box1" id="state" name="state"><option value="-1" selected>SELECT STATE</option>');
            $(arr).each(function(i) {
           $("#state").append('<option value="'+arr[i].code+'">'+arr[i].name+'&nbsp;-- ( <b>'+arr[i].code+'</b> )'+'</option>');
            });
            $("#lblData").append('</select></div>');
            toggle_t();
        }
     var id=queryString["id"];
     var type=queryString["type"];
     sessionStorage.setItem("showresultbyid", id);
     sessionStorage.setItem("showresultbytype", type);
     sessionStorage.setItem("showresultbystate", '');
     callchartdata();
  
});
function display_results(arr,data) {
$(arr).each(function(i) {
        data.addRow([arr[i].partyName, arr[i].seatsWon,arr[i].alliance,"<img src=\'"+arr[i].partySymbol+"\' width=\'100px\'/>"]);
        totalWon = totalWon+arr[i].seatsWon;
        });
}
function display_pieresults(arr,piedata) {
for(var index in arr) {
        piedata.addRow([index,arr[index]]);
        };
}
function callchartdata(){
     $(".display-error").css("display","none");
    sessionStorage.setItem("showresultbystateId",'');
    var id=sessionStorage.getItem("showresultbyid");
    var type=sessionStorage.getItem("showresultbytype");
    var stateCode=sessionStorage.getItem("showresultbystate");
   // alert(id+' '+type+' '+stateCode);
      google.charts.load('current', {'packages':['corechart','table']});  
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
      var piedata = new google.visualization.DataTable();
        data.addColumn('string', 'Party Name');
        data.addColumn('number', 'Seats Won');
        data.addColumn('string', 'Alliance');
        data.addColumn('string', 'Party Symbol');
        piedata.addColumn('string', 'Alliance Name');
        piedata.addColumn('number', 'Seats Won');
      //  data.addColumn('string', 'Alliance');
          $.ajax({
            type: "POST",
            url: "GetOverallResult.php",
            dataType: "json",
            data: {id:id, type:type, stateCode:stateCode},
            success : function(jdata){ 
               if (jdata.code ===11){
                     if(jdata.msg.success===true){
                                $("#overallresultsection").css("display","block");
                                var totalSeats=jdata.msg.totalSeats;
                                var status=jdata.msg.status;
                                totalWon= 0;
                                display_results(jdata.msg.results,data);
                                display_pieresults(jdata.msg.allianceList,piedata);
                                if(jdata.msg.tieCount>0)
                                data.addRow(['Ties', jdata.msg.tieCount,'',"<i class='fas fa-exclamation-triangle' style='font-size:48px;color:red'></i>"]);
                                var stateElectionId=jdata.msg.stateElectionId;
                                sessionStorage.setItem("showresultbystateId",stateElectionId);
                                var piechart_options = {  
                                title:totalWon+'/'+totalSeats,titleTextStyle: {color: '#6b51e1', fontSize: 20},
                                colors: ['#99ff33', '#ffff66', '#00cc99', '#ff9900', '#f6c7b6'], 
                                backgroundColor:'transparent',
                                legend:{position: 'bottom', textStyle: {color: '#6b51e1', fontSize: 20}},
                                pieSliceBorderColor:'#8C78E8',
                                pieSliceTextStyle:{color:'black'},
                                allowHtml:true,
                                //is3D:true,  
                                pieHole: 0.4  
                                };  
                            var piechart = new google.visualization.PieChart(document.getElementById('piechart'));  
                            piechart.draw(piedata, piechart_options);  
                            $("text:contains(" + piechart_options.title + ")").attr({'x':'47.5%', 'y':'51%'})
                            table = new google.visualization.ChartWrapper({
                                'chartType': 'Table',
                                'dataTable': data,
                                'containerId': 'table',
                                'options': {
                                    'width': '100%',
                                    'showRowNumber' : false,
                                    'allowHtml':true
                                },
                            });
                            
                            google.visualization.events.addListener(table, 'ready', function(){
                                $(".google-visualization-table-table").attr('class', 'table');
                                $("table").addClass('thead-dark text-dark');
                                for (var i = 0; i < data.getNumberOfRows(); i++) {       
                                document.getElementById('table').getElementsByTagName('TR')[i+1].style.backgroundColor = '#9999ff';      
                            }
                            });
                            $("#tablehead").html("<h5 class='text-center mt-md-4'>Party-wise Seat Distribution</h5>");
                            table.draw();
                     } 
                    else if(jdata.msg.validAuth===false){
                        $("#overallresultsection").css("display","none");
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(jdata.msg.validType===false){
                         $("#overallresultsection").css("display","none");
                        $(".display-error").html("Invalid Election Type!");
                        $(".display-error").css("display","block");}
                    else if(jdata.msg.validState===false){
                        $("#overallresultsection").css("display","none");
                        $(".display-error").html("Invalid State Code!");
                        $(".display-error").css("display","block");}
                     else if(jdata.msg.validElection===false){
                         $("#overallresultsection").css("display","none");
                        $(".display-error").html("Invalid election Id or result calculation has not started!");
                        $(".display-error").css("display","block");}
                     else{
                         $("#overallresultsection").css("display","none");
                        $(".display-error").html("Technical Error!");
                        $(".display-error").css("display","block");}
                    
                } else {
                    $("#overallresultsection").css("display","none");
                    $(".display-error").html("<ul>"+jdata.msg+"</ul>");
                    $(".display-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-error").html("Something Went Wrong!");
                $(".display-error").css("display","block");
                $('#piechart').html("<b>Loading failed!</b>"); 
                } 
        });
        }   
      }   
function toggle_t()
  {
    var d = document;
    var cntn = d.getElementById("statelist");
    var val = d.getElementsByName("state")[0];
    cntn.addEventListener("change",fillup);
    function fillup()
    {
      if(val.value != "-1")
      {
        stateCode=val.value;
        sessionStorage.setItem("showresultbystate",stateCode);
        showstateresult();
       //alert(stateCode);
      }
      else
      {
        stateCode='';
        sessionStorage.setItem("showresultbystate",stateCode);
        showoverallresult();
      }
    }
  } 
function display_statewise_results(arr,data) {
$(arr).each(function(i) {
        data.addRow([arr[i].partyName, arr[i].seatsWon,"<img src=\'"+arr[i].partySymbol+"\' width=\'100px\'/>"]);
        totalWon = totalWon+arr[i].seatsWon;
        });
}
function showoverallresult(){
  $("#state").val('-1'); 
  $(".display-error").html('');
  $("#overallcard a").addClass("active");
  $("#statecard a").removeClass("active");
  var type=sessionStorage.getItem("showresultbytype");
  $("#constcard a").removeClass("active");
  if(type=="LOK SABHA"){$("#constcard").css("display","none");}
  $("#statecard").css("display","none");
  $('#conresultsection').html('');
  sessionStorage.setItem("showresultbystate",'');
  $('#conresultsection').css("display","none");
  $('#overallresultsection').css("display","block");
  callchartdata();
  }  
function showstateresult(){
  $(".display-error").html('');
  $('#conresultsection').css("display","none");
  $('#overallresultsection').css("display","block");
  $("#statecard a").addClass("active");
  $("#overallcard a").removeClass("active");
  $("#constcard a").removeClass("active");
  $("#statecard").css("display","block");
  $("#constcard").css("display","block");
  callchartdata();
  }
function showconstresult(){
  $(".display-error").html('');
  $('#overallresultsection').css("display","none");
  $('#conresultsection').css("display","block");
  var type=sessionStorage.getItem("showresultbytype");
  $("#constcard a").addClass("active");
  $("#overallcard a").removeClass("active");
  $("#constcard").css("display","block");
  if(type=="LOK SABHA"){
  $("#statecard a").removeClass("active");
  $("#statecard").css("display","block");
  var stateCode=sessionStorage.getItem("showresultbystate");
  }
  else 
  var stateCode='vidhan';
  var id=sessionStorage.getItem("showresultbyid");
  $.ajax({
            type: "POST",
            url: "ShowConstituencyWiseResult.php",
            dataType: "json",
            data: {id:id, type:type, stateCode:stateCode},
            success : function(data){
               if (data.code ===11){
                     if(data.msg.success===true){
                       display_cons(data.msg.results);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validType===false){
                        $(".display-error").html("Invalid Election Type!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validState===false){
                        $(".display-error").html("Invalid State Code!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validElection===false){
                        $(".display-error").html("Invalid election Id or Result calculation has not started!");
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
                $('#conresultsection').html("<b>Loading failed! Refresh and Try Again</b>"); 
                } 
        });
  }
function display_cons(arr) {
    var constarr=[];
    $(arr).each(function(i) {
        constarr.push(arr[i].constituencyName);
    });
var result = count_tie(constarr);
$('#conresultsection').append('<div class="table-responsive text-center mt-2"><table class="table table-borderless table-hover text-info" id="constitable"><thead style="font-weight:bold;" class="primarytext"><tr><th class="heading">Constituency</th><th class="heading">Winner</th><th class="heading">Party</th><th class="heading">Votes Count</th></tr></thead><tbody'); 
var stateid=sessionStorage.getItem("showresultbystateId");
$(arr).each(function(i) {
    var constindex = result[0].indexOf(arr[i].constituencyName);
        if(result[1][constindex]>1){
        $('#constitable').append('<tr onclick="viewconstdetails(\''+arr[i].constituencyName+'\',\''+stateid+'\');" data-toggle="modal" data-target="#constModal" class="border border-warning"><td>'+arr[i].constituencyName+'</td><td><img src=\''+arr[i].candidateImage+'\' style="width:150px"><br><br>'+arr[i].candidateName+'</td><td><img src=\''+arr[i].partySymbol+'\' style="width:150px"><br><br>'+arr[i].partyName+'</td><td>'+arr[i].voteCount+'</td></tr>');
        }
        else{
        $('#constitable').append('<tr onclick="viewconstdetails(\''+arr[i].constituencyName+'\',\''+stateid+'\');" data-toggle="modal" data-target="#constModal"><td>'+arr[i].constituencyName+'</td><td><img src=\''+arr[i].candidateImage+'\' style="width:150px"><br><br>'+arr[i].candidateName+'</td><td><img src=\''+arr[i].partySymbol+'\' style="width:150px"><br><br>'+arr[i].partyName+'</td><td>'+arr[i].voteCount+'</td></tr>');
        }
        });
     $('#conresultsection').append('</tbody></table></div>');
} 
function count_tie(arr) {
    var a = [], b = [], prev;
    
    arr.sort();
    for ( var i = 0; i < arr.length; i++ ) {
        if ( arr[i] !== prev ) {
            a.push(arr[i]);
            b.push(1);
        } else {
            b[b.length-1]++;
        }
        prev = arr[i];
    }
    
    return [a, b];
}
function viewconstdetails(constituencyName,stateid){
   // alert('viewconstdetails');
    $('.consadd').html('');
    $.ajax({
            type: "POST",
            url: "ShowConstituencyResultDetails.php",
            dataType: "json",
            data: {stateid:stateid, constituencyName:constituencyName},
            success : function(data){
               if (data.code ===11){
                     if(data.msg.success===true){
                       //alert('calling');
                       display_consdetails(data.msg.detailResult);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validElection===false){
                        $(".display-error").html("Invalid or incomplete election id!");
                        $(".display-error").css("display","block");}
                     else if(data.msg.validConstituency===false){
                        $(".display-error").html("Invalid constituency name or constituency is of a different state!");
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
                } 
        });
  }
function display_consdetails(arr) {
    $(arr).each(function(i) {
    $('.consadd').append('<div class="media p-3"><img src=\''+arr[i].image+'\' class="mr-3 mt-3" style="width:150px;"><div class="media-body mt-3"><h4>'+arr[i].name+'</h4><h5>Votes: '+arr[i].noOfVotes+'<br><br>'+arr[i].partyName+'</h5><img src=\''+arr[i].partySymbol+'\' class="ml-3 mt-3 rounded-circle" style="width:60px;float:right;"></div></div>'); 
    });
}
</script>  
</html>