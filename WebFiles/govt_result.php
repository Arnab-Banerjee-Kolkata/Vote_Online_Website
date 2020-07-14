<?php
include './includes/header.php';
include './includes/scripts.php';
?>
<script>
  function submit_soap(id,type,year){
        var id=id;
        var type=type;
        var year=year;
        var url = "showoverallresult.php?id=" + encodeURIComponent(id) + "&type=" + encodeURIComponent(type) + "&year=" + encodeURIComponent(year);
        window.location.href = url;
    };
</script>
<body class="p-md-5 p-3 bodycolor">
<div id="screen">
<?php include './includes/booth_navbar.php';?> 
<section class="mainframe p-md-5 p-3">
<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-6">
<h3 class="text-center heading my-5">Published public election results:</h3>
<div id="json_response"></div>
<div class="display-error alert alert-danger" style="display:none;"></div>
</div>
<div class="col-sm-3"></div>
</div>
</section>
<?php include './includes/footer.php'; ?>
</div>
</body>
<script type="text/javascript">

  $(document).ready(function() {
   $('#addmoreitem').append('<li class="nav-item"><a class="nav-link active" href="govt_result.php"><i class="fas fa-chart-line"></i> ELECTION RESULTS</a></li>');     
        var dummy='dummy';
        $('#json_response').html("<b>Loading completed election list...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "ShowCompletedElectionList.php",
            dataType: "json",
            data: {dummy:dummy},
            success : function(data){
               $('#json_response').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                        display_elections(data.msg.elections);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-error").html("Unauthorised access!");
                        $(".display-error").css("display","block");}
                     else{
                        $(".display-error").html("Technical Issue!");
                        $(".display-error").css("display","block");}
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-error").html("Something Went Wrong!");
                $(".display-error").css("display","block");
                $('#json_response').html("<b>Loading failed! Refresh and Try Again</b>"); 
                } 
        });

      });
     function display_elections(arr){
          $('#json_response').html('<div class="table-responsive"><table class="table table-borderless table-hover" id="elections"><tbody>');
         $(arr).each(function(i){
         if (arr[i].status==2){var str='PARTIAL RESULT';var cls="text-warning";}
         else {var str='PUBLISHED';var cls="text-success"}
         if(arr[i].type=='LOK SABHA'){
         $('#elections').append('<tr onclick="submit_soap(\''+arr[i].electionId+'\',\''+arr[i].type+'\',\''+arr[i].year+'\');"><td><h5>'+arr[i].name+'</h5><span class="secondarytext">'+arr[i].type+'</span></td><td>'+arr[i].year+'</td><td><i class="fas fa-circle '+cls+'"></i>&nbsp;'+str+'</td></tr>');}
         else{
              $('#elections').append('<tr onclick="submit_soap(\''+arr[i].electionId+'\',\''+arr[i].type+'\',\''+arr[i].year+'\');"><td><h5>'+arr[i].name+'<span class="primarytext"> ('+arr[i].stateName+')</span></h5><span class="secondarytext">'+arr[i].type+'</span></td><td>'+arr[i].year+'</td><td><i class="fas fa-circle '+cls+'"></i>&nbsp;'+str+'</td></tr>');
         }
    });
    $('#json_response').append('</tbody></table></div>');
     }
</script>      
</html>