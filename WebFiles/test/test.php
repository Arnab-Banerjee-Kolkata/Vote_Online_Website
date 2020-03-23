<html>
<head>
 <title>Send HTTP POST Request using PHP</title>
 <script src="https://code.jquery.com/jquery-latest.js"></script>
	<script>
	  function submit_soap(){
		var booth_id=$("#booth_id").val();
		var otp=$("#otp").val();
		$.post("form_post.php",{booth_id:booth_id,otp:otp},
		function(data){
		  $("#json_response").html(data);
		});
	}
	</script>
</head>
<body>
  <center>
    <h3>Send HTTP POST Request using PHP</h3>
     <form>
     aadharNo : <input name="booth_id" id="booth_id" type="text" /><br />
     otp  : <input name="otp" id="otp" type="text" /><br />
      <input type="button" value="Submit" onclick="submit_soap()"/>
    </form>
       <br>-----------
	  <div id="json_response"></div>
   </center>
</body>
</html>