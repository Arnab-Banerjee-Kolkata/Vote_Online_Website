<?php 
session_start();
$name = $_SESSION["bid"];
if(isset($_POST["checkbid"]))
{
if($_SESSION['bid']==null){
    echo "<script>window.open('login.php', '_self')</script>";}
else{
    echo "<script>window.open('home.php', '_self')</script>";
}
}
?>