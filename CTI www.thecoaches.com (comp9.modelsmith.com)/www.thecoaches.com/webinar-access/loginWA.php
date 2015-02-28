<?php

	ini_set("include_path",".:../docs/res/inc/");
	header("Cache-Control: no-cache");  // no page caching
	header("Pragma: no-cache");
	$msg =  ' ';
	$sysdownmsg = ' ';
	$specials = array(  'ctiuae'            => 'coactive',
						'ctiisrael'         => 'coactive',
						'ctinordic'         => 'coactive',
						'schoutenchina'     => 'coactive',
						'schouten&nelissen' => 'coactive',
						'elementalv'        => 'coactive',
						'schoutengermany'   => 'coactive'  );
	session_start();
	$redirecturl = $_GET["redirect"];      //param from url
	$redirectform = $_POST["redirect"];    //param from form
	if ($redirecturl  == '' & $redirectform == '') {
		$redirect = '/webinar-access/index.php';
	} elseif ($redirecturl  == '') {
		$redirect = $redirectform;
	} else {
		$redirect = $redirecturl;
	}

	/* To use the logout feature, use the following url:
	   http://www.thecoaches.com/webinar-access/loginWA.html?logout=1
	*/
	if ( $_GET["logout"] == '1' ) {
		/* log out of session, redirect back to login page */
		unset($_SESSION['logged_in']);
		unset($_SESSION['username']);
		header("Location: http://www.thecoaches.com/webinar-access/loginWA.php");
		exit;
	}
	
	/* Already logged in, redirect to learning hub landing page
	*/
	If ($_SESSION['logged_in'] == 'yes') { 
		header("Location: http://www.thecoaches.com/webinar-access/index.php");
		/* For good order dont risk the code below the redirect
		to be executed when we redirect. */
		exit;
	}
	
	/* If login form was submitted, validate email and password. 
	   If OK, then login and redirect */
	if ($_POST['email'] != '' & $_POST['password'] != '') {   // 1st if
			/* we have userid and password input from form, then convert to lower 
				 case and validate.		*/
			$b4email = strtolower($_POST['email']);
			$password = $_POST['password'];
			$password = substr($password, 0, 32);    //limit to 32 characters
			$email = preg_replace('/[^A-Za-z0-9&@_\.-]/s','',$b4email);  //untaint email address
			if ($specials[$email] == $password) {   // 2nd if
					// email and password in specials, login and redirect
					$_SESSION['logged_in'] = 'yes';
					$_SESSION['username'] = $email;  // save logged in username for bridging-content completion page
					header('Location: http://www.thecoaches.com'.$redirect);
			} else {
					// email and password not in specials, check in filemaker
					if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/abletogetrecord.php?postkey=fjgh15t&em=ping@me.com") == 'ok') {   // 3rd if
							// yes, filemaker is available
							$authenticate = file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/authenticate_webinar.php?postkey=fjgh15t&em=$email&pw=$password");
							if ($authenticate == '1') {   // 4th if
									// student paid for webinar
									$_SESSION['logged_in'] = 'yes';
									$_SESSION['username'] = $email;
									$message = urlencode("Student ".$email." logged in to webinar access at ".date("H:i:s")." ET" );
									$result = file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/new_commlog.php?postkey=fjgh15t&em=$email&m=$message");
									header('Location: http://www.thecoaches.com'.$redirect);
							} else {
								$msg = 'Either you have entered an incorrect username and password combination, or you are attempting to enter an area for which you are not authorized. For assistance, please contact customer service at (415) 451-6000';

								//if ($authenticate == '0') {
									//$msg = 'Either you have entered an incorrect username and password combination, or you are attempting to enter an area for which you are not authorized. For assistance, please contact customer service at (415) 451-6000';
								//} else {
									// email and password not in filemaker
									//$msg = 'Email address or password is not correct - try again.';
								//}
							}   // end 4th if
					} else {
							// filemaker not available
							$sysdownmsg = 'Our system is down for maintenance. Please try again later. Thank you.';
					}   // end 3rd if
			}   // end 2nd if
	}   // end 1st if

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>CTI: Webinar Access Login </title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="en" />
<meta name="language" content="en" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="The Coaches Training Institute (CTI)" />
<meta name="copyright" content="Copyright &#169; 2013 The Coaches Training Institute. All rights reserved." />
<link rel="icon" href="/favicon.ico" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/res/css/coaches-training-institute.css" />
<link rel="stylesheet" type="text/css" href="/res/css/section_coach-training.css" />

<link rel="stylesheet" type="text/css" href="/res/css/content_internal_11c.css" /> 
<link rel="stylesheet" type="text/css" href="/res/css/mentor.css" />
<link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/assets/css/footer.css" /> 

<script src="http://www.google.com/jsapi"></script>
<script>
google.load("jquery", "1.4.2");
google.setOnLoadCallback(function() {
});
</script>
<style>
.pri table { width:400px; }
.pri table input#signin_username,
.pri table input#signin_password { width:270px }
</style>
</head>
<body>
<div id="page">
 
<div id="tools">
  <!-- generalID --><!-- -->
  <!-- eCommerceID --><!-- -->
  <!-- courseMaterialsID --><!-- -->
</div>
<div id="primary">
  <!-- contactNavID --><!-- -->
  <ul id="main-nav">
  </ul>
  
<div id="broadcast">
  <img src="/res/img/page-banners/content_webinar_access_login.png" width="920" height="124" alt="Coach Training" usemap="#logobutton" />
  <map id="logobutton" name="logobutton">
  <area shape="rect" coords="822,0,899,103" href="/" title="CTI Home" alt="CTI Home" />
  </map>
</div>

<div id="content">

<div id="main">
  <div id="breadcrumbs">
  </div>
  <div class="sec">
</div>
  <div class="pri">

<h1 id="main-headline">Please Sign-in</h1>

<?php 

if ($msg != ' ') {
	echo '<p style="background-color:#ddd;color:#d00;padding:3px;">';
	echo $msg;
	echo '</p>';
}
?>

 <form action="loginWA.php" method="POST">
  <input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
     <table>
    <tr>
  <th><label for="signin_username">Email address</label></th>
  <td><input type="text" name="email" id="signin_username" /></td>
</tr>
<tr>
  <th><label for="signin_password">Password</label></th>
  <td><input type="password" name="password" id="signin_password" /></td>
</tr>
  <tr><td></td><td>
  <input type="submit" value="Sign In" />
  </td></tr>
  <tr><td></td><td>
   <a href="wa-reset-password-request.php">I'm not able to sign into my account</a> 
  </td></tr>
  </table>

</form>
 
<?php 
if ($sysdownmsg != ' ') {
	echo '<p style="background-color:#ddd;color:#d00;padding:3px;">';
	echo $sysdownmsg;
	echo '</p>';
}
?>

  </div>

</div>

  </p>


<!-- ctaAreaId -->

<div id="cta-area">
</div>
<!-- -->

</div>

<!-- used for cross-browser stabilizion of layout -->
<div class="pageclear"></div>
</div>
<div id="footer">
		<?php include 'id_footer-nav-webinar-access.php'; ?>
</div>  <!-- end footer -->
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5715102-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>

