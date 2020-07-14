<nav class="navbar navbar-expand-md navshadow">
 <div class="switch-buttons">
        <button class="switch-buttons__light switchbtn btn rounded-pill px-3" data-stylesheet="../css/light_theme.css"><i class='fas fa-sun'></i></button>
        <button class="switch-buttons__dark switchbtn btn rounded-pill px-3" data-stylesheet="../css/dark_theme.css"><i class='fas fa-moon'></i></button>
    </div>
   <script src="../js/theme.js"></script>
   <ul class="timertext text-danger my-0 mx-2 navbar-text" style="display:none;"> 
        Warning! You are idle for <span class="secs"></span> minutes. 
   </ul> 
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <i class='fas fa-bars navbtn btn'></i>
   </button>

  
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto mr-md-5">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i> DASHBOARD</a>
      </li>
      <div id="logoutdetails" style="display:none;">
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <b><script>
        var admin=sessionStorage.getItem("adminID");
        document.writeln(admin);
        </script></b>
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item btn rounded-pill navbtn" type="button" id="logoutbtn"><i class='fas fa-sign-out-alt'></i> LOGOUT</a>
        <a class="dropdown-item btn rounded-pill navbtn" type="button" href="admin_instruct.php"><i class='fas fa-info-circle'></i> Read Instructions</a>
      </div>
    </li>
    </div>
      <div id="logindetails" style="display:none;">
       <li class="nav-item">
      <a type="button" class="btn rounded-pill navbtn px-3" href="adminlogin.php"><i class='fas fa-sign-in-alt'></i> LOGIN</a>
      </li>   
      </div>  
    </ul>
</div>
</nav>
 <script>
 var localaid=sessionStorage.getItem("adminID");
 if (typeof localaid == 'undefined' || localaid == null){
     document.getElementById("logindetails").style.display="block";
     document.getElementById("logoutdetails").style.display="none";
 }
 else{
      document.getElementById("logoutdetails").style.display="block";
      document.getElementById("logindetails").style.display="none";
 }
 </script>