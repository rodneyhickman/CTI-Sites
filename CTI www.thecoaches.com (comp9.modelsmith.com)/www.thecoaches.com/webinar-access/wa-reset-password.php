<?php

	ini_set("include_path",".:../docs/res/inc/");
	$password = '';               // global var
	$verify = '';                 // global var
	$key_ok = 0;                  // global var
	$email = '';                  // global var
	$currentdatetime = date("Y-m-d H:i:s");  // 'YYYY-MM-DD HH:MM:SS'
	$dbusername = "cticoaches";
	$dbpassword = "";
	$dbhostname = "localhost"; 
	session_start();  
	
	$urlkey = $_GET["k"];              //param from url
	$formkey = $_POST["pkey"];         //param from form
	if ($urlkey  == '' & $formkey == '') {
		die('Should never get here - no keys input');
	} elseif ($urlkey  == '') {
		//$key = $formkey;             
		$key = preg_replace('/[^A-Za-z0-9]/s','',$formkey);   //untaint formkey and assign - global var
	} else {
		//$key = $urlkey;
		$key = preg_replace('/[^A-Za-z0-9]/s','',$urlkey);   //untaint urlkey and assign - global var
	}
	
	// get key from database (if it exists)
	//connection to the database
	$dbh = mysql_connect($dbhostname, $dbusername, $dbpassword);
	if (!$dbh) {
			die('Unable to connect to MySQL'.mysql_error());
	}	
	//select a database to work with 
	$db_selected = mysql_select_db("CTIDATABASE",$dbh);
	if (!$db_selected) {
			die ('Could not select database CTIDATABASE '.mysql_error());
	}
	// get results (single row returned)
	$query_result = mysql_query("SELECT username,resetkey,resetkeytime FROM WA_user_login WHERE resetkey='$key' ");
	$num_rows = mysql_num_rows($query_result);
	if ($num_rows > 0) {
			// key found in DB
			$row = mysql_fetch_array($query_result);
			$database_key = $row['resetkey'];
			$database_keytime = $row['resetkeytime'];
			$email = $row['username'];
	} else {
			// no key found in DB
			$database_key = 'not found';
			header("Location: http://www.thecoaches.com/webinar-access/wa-reset-password-request-fail.php");
	}
	
	// if key is not valid, or time is not within one day, bail out
	$currenttimestamp = strtotime($currentdatetime);
	$dbtimestamp = strtotime($database_keytime);
	if (!($key == $database_key & $currenttimestamp-$dbtimestamp < 86400)) {
		header("Location: http://www.thecoaches.com/webinar-access/wa-reset-password-request-fail.php");   // key not valid
	} 
		
	// If the form was submitted, validate and process it, else just show it.
	// When the form is entered, '_submit_check' returns true and the form is valid.
	if (array_key_exists('_submit_check',$_POST)) {
		// If validate_form() returns errors, pass them to show_form()
		$form_errors = validate_form();
		if (!empty($form_errors)) {
			 // The submitted data is not valid, display with errors
			 show_form($form_errors);
		} else {
			 // The submitted data is valid, so process it
			 process_form();
		}
	} else {
		// The form wasn't submitted, so display
		show_form();
	}
	// close connection when done
	mysql_close($dbh);
	exit;

	function validate_form( ) {
		$val_error_msg = '';
		if ( $_POST['password']  == '') {
			$val_error_msg = 'Password was not entered - please try again.';
		} else {
			$GLOBALS['password'] = strtolower(substr($_POST['password'], 0, 32));    //limit to 32 and lowercase
			$GLOBALS['verify'] = strtolower(substr($_POST['verify'], 0, 32));    //limit to 32 characters and lowercase
			if ($GLOBALS['password'] != $GLOBALS['verify']) {
				$val_error_msg = 'Password did not equal Verify password - please try again.';
			} else {
				if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/abletogetrecord.php?postkey=fjgh15t&em=ping@me.com") != 'ok') {
						// filemaker not available
						$val_error_msg = 'Our system is down for maintenance. Please try again later. Thank you.';
				} else {
					// filemaker available, set flag for process routine
					$GLOBALS["key_ok"] = 1;
				}
			}
		} 
		return $val_error_msg;    // return either NULL or error message
	}

	function process_form( ) {
		if ($GLOBALS["key_ok"] == 1) {
			// we have valid key and password, so change password  
			// save in filemaker
			if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/set_pw.php?postkey=fjgh12fgt&em={$GLOBALS['email']}&pw={$GLOBALS['password']}") != 'ok') {
					die("Should never get to: www.thecoaches.com/webinar-access/wa-reset-password.php process_form filemaker setpw fail.");
			} 
			$message = urlencode("Student ".$GLOBALS['email']." reset password via webinar access at ".date("H:i:s")." ET" );
			$result = file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/new_commlog.php?postkey=fjgh15t&em={$GLOBALS['email']}&m=$message");
			// delete key in database
			$del_result = mysql_query("DELETE FROM WA_user_login WHERE username='{$GLOBALS['email']}' AND resetkey='{$GLOBALS['key']}' ");
			if (!$del_result) {
					die('Invalid delete: '.mysql_error());
			}
			// tell the user
			header("Location: http://www.thecoaches.com/webinar-access/wa-reset-password-request-saved.php");
		} else {
			die("Should never get to: www.thecoaches.com/webinar-access/wa-reset-password.php process_form key_ok not one.");
		}
		return;
	}
?>

<?php function show_form($sf_error_msg='') { ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>CTI: Webinar Access: Login</title>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en" />
		<meta name="language" content="en" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="The Coaches Training Institute (CTI)" />
		<meta name="copyright" content="Copyright &#169; 20013 The Coaches Training Institute. All rights reserved." />
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
	</head>
	<body>
	<div id="page">
		
		<div id="tools">
			<!-- generalID --><!-- -->
			<!-- eCommerceID --><!-- -->
			<!-- courseMaterialsID -->
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
						<!--<p><span id="youarehere" class="accessibility-hide">You are here:&#160;</span> <a href="/">Home</a><span class="divider">&#160;||&#160;</span><a href="/contact/" class="here">Policies</a></p>-->
					</div>

					<h1 id="main-headline">Please enter your new password</h1>
					<form action="wa-reset-password.php" method="POST">
						<input type="hidden" name="_submit_check" value="1"/> 
						 <input type="hidden" name="pkey" value="<?php echo $GLOBALS['key'] ?>">
						 <table>
							<tr>
						<th><label for="signin_username">Email address</label></th>
						<td><?php echo $GLOBALS['email'] ?></td>
							</tr>
							<tr>
						<th><label for="signin_password">Password</label></th>
						<td><input type="password" name="password" id="signin_password" /></td>
							</tr>
							<tr>
						<th><label for="signin_password">Verify</label></th>
						<td><input type="password" name="verify" id="signin_verify" /></td>
							</tr>
						<tr><td></td>
						<td><input type="submit" value="Save New Password" /></td>
							</tr>
						</table>
					</form>

					<div class="pri">
					<?php if ($sf_error_msg != '') {
						echo '<p style="background-color:#ddd;color:#d00;padding:3px;">';
						echo $sf_error_msg;
						echo '</p>';
					}?>			
					
					</div>
				</div>

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

<?php return; } ?>


