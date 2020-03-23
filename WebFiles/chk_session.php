<?php 
session_start();
$name = $_SESSION["bid"];
if(isset($_POST["checkbid"]))
{
if(null==$_SESSION['bid'])
        {echo "<script>window.open('index.php', '_self')</script>";}
}
?>