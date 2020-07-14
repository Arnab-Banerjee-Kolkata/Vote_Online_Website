<?php 
session_start();

if(null==$_SESSION['bid'])
        {
         echo'<script>document.getElementById("myFrame").addEventListener("load", checklogout);</script>';
         echo "<script>window.open('login.php', '_self')</script>";
        }
?>