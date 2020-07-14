<?php
include './includes/header.php'; 
?>
<body class="container-fluid bodycolor">
<?php include './includes/scripts.php'; ?>
<div id="screen">

<?php include './includes/booth_navbar.php';?>
 
<section class="mainframe">
<div class="container-fluid pt-3">
<div class="row">
	<div class="col-md-8 p-3">
		<h4 class="text">Please read the following instructions carefully before proceeding:</h4>
		<ul class="text1">
			<li>On clicking the 'Proceed' button you will be required to enter the Voter's Adhaar no and Voter's OTP that has been sent to the voter's application.</li>
            <li>After successful OTP verification, verify voter's photograph with the one generated on screen.</li>
			<li>Then get the unique Booth otp for the particular voter and click on 'Finish' after sharing it.</li>
			<li>Before doing so, please make sure that voter's OTP remains secret between you and the voter in order to avoid any illegal interference with the process of the election.</li>
			<li>Also keep the booth otp secret between you two. For these, having a separate room with only one voter and the agent at a time is preferred.</li>
			<li>If you find that the otp secrecy is hampered, you can regenerate it if the voter has not yet used it.</li>
			<li>If any problem arises, report to <a href='mailto:<nowiki>remotevoting@gmail.com?subject="Report for election"'>remotevoting@gmail.com</a> or call us at<a href="tel:5554280940"> 555-428-0940</a> in emergency.</li>
		</ul>
		<form class="text2" method="post" action="home.php">
		<div class="form-group form-check">
      	<label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember" required> I have read and agree to the <a href="#">Terms and conditions </a>.
        </label>
    	</div>

        <input type="submit" class="btn submitbtn rounded-pill px-5 m-3" value="Proceed"/>
		</form>

	</div>
	<div class="col-md-4 col-12">
		<img src="images/vote.jpg" width="100%" class="border p-3 my-2 pic">
	</div>
</div>
</div>
</section>
<?php include './includes/footer.php'; ?>
</div>
</body>
</html>
