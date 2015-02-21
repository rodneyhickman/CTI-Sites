<html>
<head>
<script>
function validateForm(id){
return true;
}
</script>
  <script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-21451781-3']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
   </script>
</head>
<body>

<h1>Contact Form</h1>

<form name="contact" method="post" onSubmit="return validateForm(contact);" action="contact.php">

<?php
if($_POST){
  $toggle = $_POST['toggle'];
}
			
echo "<input type=\"hidden\" name=\"toggle\" value=\"";
if(!isset($_POST['submit_button']) || $toggle == "") {echo "1"; }
echo "\" />";

//Get form field values.
if($_POST){
  $name = $_POST['name'];
  $email = $_POST['email'];
}
			
if (isset($_POST['submit_button']) && $toggle != ""){
  //Get form field values.
  $message = $_POST['message'];
				
  //Prepare email
  $to = "ping@mac.com";
  $subject  = "Support the new Sutter Medical Center of Santa Rosa";
  $headers  = "From: " . $email . "\r\n";
  $headers .= "Cc: thomas@techcoachtom.com" . "\r\n";
  $headers .= "Bcc: beutelevision@gmail.com" . "\r\n";

  // prepare email body text
  $body = "";
  $body .= "This message is from: ".$name."\n";
  $body .= "".$message."\n";
  
  $sent = mail($to, $subject, $body, $headers) ;
  
  if($sent){
?>

<p>Thank you! The email was sent.</p>

<?php
} else {
?>

<p>Oops, the email had a problem.</p>

<?php
 } //end if($sent)

} else { 
?>

<p>
    Name: <input type="text" name="name" /><br />
    Email: <input type="text" name="email" /><br />
<input type="submit" name="submit_button" value="Send">
</p>
</form>

<?php
} // end if(isset

?>

</body>
</html>

