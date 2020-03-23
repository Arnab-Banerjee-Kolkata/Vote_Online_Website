<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
    <title>PUBLIC GOVERNMENT ELECTIONS</title>
    <link rel="icon" href="logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>    
    <script src="https://code.jquery.com/jquery-latest.js"></script>

<script>
$(document).ready(function(){
  $("#checkbid").click(function(){
    var checkbid=$(this).val();
$.ajax({
url: "chk_session.php",
method: "POST",
data:{checkbid:checkbid},
dataType:"text",
success: function(html){
$('#availability').html(html);
}
});
});
});
</script>
<style>
  .parallax {
   background: url(2.png), rgba(0,0,0,0.8);
  min-height: 190px; 
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-blend-mode: multiply;
}
.parallax2 {
  background: url(1.jpg), rgba(0,0,0,0.85);
  min-height: 400px; 
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-blend-mode: multiply;
}

.highcharts-figure, .highcharts-data-table table {
    min-width: 320px; 
    max-width: 500px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
</head>
<body class="text-light bodies text-center">
<div class="parallax">
 <marquee><h4 class="pt-5">It is easy to create Public Goverment Election Now!</h4></marquee>
</div>
<nav class="navbar navbar-expand-md border-bottom navbar-dark">
  <a class="navbar-brand" href="#"><img src="logo.png" width="100" height="100" class="mr-3"></a><span><div style="letter-spacing:3.5px">REMOTE POLLING INTERFACE</div> </span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" active>ELECTION RESULTS</a>
    </li>
      <?php if(isset($_SESSION['bid'])){ ?>
      <li class="nav-item">
        <a class="nav-link" href="govt_create.php">CREATE ELECTION</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">MODIFY ELECTION</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="form_logout.php">LOGOUT</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#"><?php echo $_SESSION['bid']; ?></a>
      </li>
        <?php }else{ ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">LOGIN</a>
      </li>
        <?php } ?>    
    </ul>
  </div> 
</nav><br>
<section class="container">
<div class="row">
<div class="col-sm-6">
<!--
<video width="100%" height="100%" autoplay loop>
  <source src="piemation.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
-->
<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="pie4.jpg" class="img-fluid">
    </div>
    <div class="carousel-item">
      <img src="pie5.jpg" class="img-fluid">
    </div>
    <div class="carousel-item">
      <img src="pie6.jpg" class="img-fluid">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>

</div>
<div class="col-sm-6">
<p class="my-3">Published public election results:</p>
<table class="table table-dark table-hover table-bordered" width="100%">
    <thead>
      <tr>
        <th>Types</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Lok Sabha</td>
        <td>Ongoing</td>
      </tr>
      <tr>
        <td>Vidhan Sabha</td>
        <td>Completed</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<!--
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Party-wise Seat Distribution
    </p>
</figure>
<script>
Highcharts.chart('container', {
    colors: ['red','green','blue','yellow','orange','brown'],
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false,
        backgroundColor:"transparent",
        borderColor:"white",
        borderWidth:1
    },
     title: {
        text: 'West Bengal',
        align: 'center',
        y: 50,
        style:{"color":"white"}
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Seat Distribution',
        innerSize: '50%',
        data: [
            ['TMC', 58.9],
            ['BJP', 13.29],
            ['ABC', 13],
            ['XYZ', 3.78],
            ['MNC', 3.42],
            {
                name: 'Other',
                y: 7.61,
                dataLabels: {
                    enabled: true
                }
            }
        ]
    }]
});

</script>
-->

<!--<input type="submit" class="btn btn-dark" id="checkbid" onclick="window.location.href = 'home.php';" value="Proceed"/><span id="availability"></span>-->
</section><br><br>
<div class="py-2 text-center footer fixed-bottom">Copyright 2019</div>
</body>
</html>