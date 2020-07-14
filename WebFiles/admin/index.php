<!DOCTYPE html>
<?php
include 'includes/header.php'; 
?>

<body class="p-md-5 p-3 bodycolor">
<?php include 'includes/scripts.php'; ?>
<div id="screen">
<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
        <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="../css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="../css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="../js/theme.js"></script>
   <p class="timertext text-danger m-0 mx-2 navbar-text" style="display:none;"> 
        Warning! You are idle for <span class="secs"></span> minutes. 
   </p> 
</nav>
<section class="mainframe p-md-5 p-3">
<div class="row">
 <div class="col-lg-2"></div>
      <div class="col-lg-8 p-3">
                    <h4 class="h4 heading text-center mt-5">WELCOME TO THE ADMIN PANEL</h4>
                    <h5 class="h5 heading">ADMIN PANEL / <span class="primarytext">DASHBOARD</span></h5>
                    <div class="card-deck pt-3 mb-3">
                    <div class="card">
                      <div class="card-body">
                       <i class='fas fa-bullhorn primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" href="declare_result.php" style="font-family:'Azo Sans Medium',sans-serif;"><h5>DECLARE RESULT</h5></a>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <i class='fas fa-user-cog primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" href="change_status.php" style="font-family:'Azo Sans Medium';"><h5>CHANGE ELECTION STATUS</h5></a>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <i class='fas fa-plus-square primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" href="govt_create.php" style="font-family:'Azo Sans Medium';"><h5>CREATE ELECTION</h5></a>
                      </div>
                    </div>
                    </div>
                    <div class="card-deck pb-3">
                    <div class="card">
                      <div class="card-body">
                        <i class='fas fa-edit primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" href="modify_election.php" style="font-family:'Azo Sans Medium';"><h5>MODIFY ELECTION</h5></a>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <i class='fas fa-democrat primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" href="party.php" style="font-family:'Azo Sans Medium';"><h5>ADD PARTY</h5></a>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <i class='fas fa-sign-out-alt primarytext mb-3' style='font-size:100px;'></i>
                        <a class="stretched-link card-title py-2" style="font-family:'Azo Sans Medium';" id="logoutbtn"><h5>LOGOUT FROM ADMIN</h5></a>
                      </div>
                    </div>
                    </div>
          </div>
          <div class="col-lg-2"></div>
              
      </div>
      
      
</div>


</section>
<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
