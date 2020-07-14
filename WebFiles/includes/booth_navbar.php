<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
        <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="./css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="./css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="./js/theme.js"></script>
   <ul class="timertext text-danger my-0 mx-2 navbar-text" style="display:none;"> 
        Warning! You are idle for <span class="secs"></span> minutes. 
   </ul> 
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <i class='fas fa-bars navbtn btn'></i>
  </button>
      
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto mr-md-5">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class='fas fa-home'></i> HOME</a>
      </li>
      <div id="addmoreitem"></div>
    <li class="nav-item dropdown mx-1">
    <button class="btn nav-link dropdown-toggle rounded-pill navbtn px-3" type="button" data-toggle="dropdown"><i class='fas fa-search'></i> FIND BOOTHS <span class="caret"></span></button>
    <div class="dropdown-menu" style="height:200px;overflow-y:auto;">
      <input class="form-control" id="myInput" type="text" placeholder="Search..">
      <span class="display-booth-error alert alert-danger" style="display:none"></span>
      <span id="boothlist"></span>
    </div>
  </li>
     
      <div id="logoutdetails" style="display:none;">
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <b><script>
        var booth=sessionStorage.getItem("boothID");
        document.writeln(booth);
        </script></b>
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item btn rounded-pill navbtn" type="button" id="logoutbtn"><i class='fas fa-sign-out-alt'></i> LOGOUT</a>
        <a class="dropdown-item btn rounded-pill navbtn" type="button" href="instruct.php"><i class='fas fa-info-circle'></i> Read Instructions</a>
      </div>
    </li>
    </div>
      <div id="logindetails" style="display:none;">
       <li class="nav-item">
      <a type="button" class="btn rounded-pill navbtn px-3 mx-1" href="login.php"><i class='fas fa-sign-in-alt'></i> LOGIN</a>
      </li>   
      </div>  
    </ul>
</div>
<div class="modal" style="background-color:rgba(1, 135, 134,0.4);" id="boothModal">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">Booth Locations</h5>
          <button type="button" class="close bg-danger" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <div class="boothloc_error"></div>
        <div id="boothloc"></div>
        <div id="boothmap" style="display:none"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</nav>

 <script>
 $(document).ready(function() { 
 var localbid=sessionStorage.getItem("boothID");
 if (typeof localbid == 'undefined' || localbid == null){
     document.getElementById("logindetails").style.display="block";
     document.getElementById("logoutdetails").style.display="none";
 }
 else{
      document.getElementById("logoutdetails").style.display="block";
      document.getElementById("logindetails").style.display="none";
 }

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
 
        var dummytxt = 'dummy';
        $('#boothlist').html("<b>Loading booth list...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "GetBoothPlaces.php",
            dataType: "json",
            data: {dummy:dummytxt},
            success : function(data){
               $('#boothlist').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                        $('#boothlist').html("");
                        display_list(data.msg.listOfPlaces);
                     }
                     else if(data.msg.validAuth===false){
                        $(".display-booth-error").html("Unauthorised access!");
                        $(".display-booth-error").css("display","block");}
                     else{
                        $(".display-booth-error").html("Technical Issue!");
                        $(".display-booth-error").css("display","block");}
                } else {
                    $(".display-booth-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-booth-error").css("display","block");
                } 
            },
            error: function() {
                $(".display-booth-error").html("Something Went Wrong!");
                $(".display-booth-error").css("display","block");
                $('#boothlist').html("<b>Loading failed! Refresh and Try Again</b>"); 
                } 
        });

});
function display_list(arr){
    $(arr).each(function(i){
         $('#boothlist').append('<a class="dropdown-item" href="#" onclick="getloc(\''+arr[i].place+'\')"; data-toggle="modal" data-target="#boothModal">'+arr[i].place+', '+arr[i].state+'</a>'); 
    });
}
function getloc(txt){
        var place = txt;
        $('#boothloc').html("<b>Loading booth list in "+place+"...Please Wait!</b>");
        $.ajax({
            type: "POST",
            url: "GetBoothAddress.php",
            dataType: "json",
            data: {place:place},
            success : function(data){
               $('#boothloc').html("<b>Loaded Successfully!</b>"); 
               if (data.code ===11){
                     if(data.msg.success===true){
                        display_booths(data.msg.allBoothsInPlace,place);
                     }
                     else if(data.msg.validAuth===false){
                        $(".boothloc_error").html("Unauthorised access!");
                        $(".boothloc_error").css("display","block");}
                    else if(data.msg.validPlace===false){
                        $(".boothloc_error").html("Invalid Place!");
                        $(".boothloc_error").css("display","block");}
                     else{
                        $(".boothloc_error").html("Technical Issue!");
                        $(".boothloc_error").css("display","block");}
                } else {
                    $(".boothloc_error").html("<ul>"+data.msg+"</ul>");
                    $(".boothloc_error").css("display","block");
                } 
            },
            error: function() {
                $(".boothloc_error").html("Something Went Wrong!");
                $(".boothloc_error").css("display","block");
                $('#boothloc').html("<b>Loading failed! Refresh and Try Again</b>"); 
                } 
        });
}
function display_booths(arr,place){
    $('#boothloc').html("");
    $(arr).each(function(i){
      /*   $('#boothloc').append(arr[i].area+' '+arr[i].address+' '+arr[i].landmark+' '+arr[i].mapLink+' '+arr[i].coordinates+'<br>'); */
      /*   $('#boothloc').append('<iframe frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' +arr[i].address+'&z=14&output=embed"></iframe><br>'); */
         var res = arr[i].coordinates.split(",");
      /*   $('#boothloc').append('<iframe frameborder="0" width="100%" height="500" src="https://maps.google.com/maps?q='+res[0]+','+res[1]+'&hl=en&z=14&amp;output=embed"></iframe><br>');*/
         $('#boothloc').append('<a href="#" onclick="showmap(\''+arr[i].area+'\',\''+arr[i].address+'\',\''+arr[i].landmark+'\',\''+arr[i].mapLink+'\',\''+arr[i].coordinates+'\',\''+place+'\');"><div class="p-3 navshadow"><div class="row no-gutters"><div class="col-7 col-md-9"><h5>'+arr[i].area+'</h5><h6 class="mr-lg-1"><i class="fas fa-map-marker-alt pr-2 text-left primarytext"></i>'+arr[i].address+'</h6></div><div class="col-5 col-md-3" style="float:right;"><iframe frameborder="0" width="100%" height="150"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="mt-3 rounded" src="https://maps.google.com/maps?q='+res[0]+','+res[1]+'&hl=en;z=14&amp;output=embed&iwloc=near"></iframe></div></div></div></a><br>');
    });
}
function showmap(area,address,landmark,mapLink,coordinates,place){
$("#boothloc").css("display","none");
$("#boothmap").css("display","block");
var res = coordinates.split(",");
$('#boothmap').html('<div class="row"><div class="col-lg-8"><iframe frameborder="0" width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="mt-3 rounded" src="https://maps.google.com/maps?q='+res[0]+','+res[1]+'&hl=en;z=14&amp;output=embed&iwloc=near"></iframe></div><div class="col-lg-4" style="font-size:22px;line-height:200%;"><div class="row"><div class="col-2"><i class="fas fa-landmark pr-2 primarytext"></i></div><div class="col-10">'+landmark+'</div><div class="col-2"><i class="fas fa-location-arrow pr-2 primarytext"></i></div><div class="col-10">'+address+'</div><div class="col-2"><i class="fas fa-map pr-2 primarytext"></i></div><div class="col-10">'+area+'</div><div class="col-2"><i class="fas fa-map-marker-alt pr-2 primarytext"></i></div><div class="col-10">'+place+'</div><div class="col-2"><i class="fas fa-crosshairs pr-2 primarytext"></i></div><div class="col-10">'+coordinates+'</div></div><button type="button" class="btn" onclick="showmainlist();");">Go Back</button></div></div>');

}
function showmainlist(){
    $("#boothloc").css("display","block");
    $("#boothmap").css("display","none");
}
 </script>
 