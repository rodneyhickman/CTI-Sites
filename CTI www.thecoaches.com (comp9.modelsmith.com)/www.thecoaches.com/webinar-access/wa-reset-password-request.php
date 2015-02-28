<?php
	ini_set("include_path",".:../docs/res/inc/");
	$request_ok = 0;              // global var
	$email = '';                  // global var
	session_start();
	
	// If the form was submitted, validate and process it, else just show it.
	// When the form is entered, '_submit_check' returns true and the form was submitted.
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
	exit;

	function validate_form( ) {
		$val_error_msg = '';
		if ($_POST['email']  == '') {
			$val_error_msg = 'Nothing was entered - please try again.';
		} else {
			$b4email = strtolower($_POST['email']);
			$GLOBALS['email'] = preg_replace('/[^A-Za-z0-9&@_\.-]/s','',$b4email);   //untaint email address
			// Look for email in filemaker
			if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/abletogetrecord.php?postkey=fjgh15t&em=ping@me.com") == 'ok') {   // 2rd if
					// yes, filemaker is available
					$tempemail = $GLOBALS['email'];
					if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/lookup.php?postkey=fjgh15t&em=$tempemail") == 'ok') {   // 3th if
							// email in filemaker, flag 'OK' for procces routine
							$GLOBALS["request_ok"] = 1;
					} else {
							// email not in filemaker
							$val_error_msg =  'We were not able to find your email address: '.$GLOBALS['email'].' in our database. Please contact us at 1-800-691-6008. Thank you.';
					}   // end 3th if
			} else {
					// filemaker not available
					$val_error_msg = 'Our system is down for maintenance. Please try again later. Thank you.';
			}   // end 2rd if
		} 
		return $val_error_msg;    // return either NULL or error message
	}
	
	function process_form( ) {
		$dbusername = "cticoaches";
		$dbpassword = "";
		$hostname = "localhost"; 
		$resetkeytime = date("Y-m-d H:i:s");  // 'YYYY-MM-DD HH:MM:SS'
		if ($GLOBALS['request_ok'] == 1) {
			// we have valid email, so set up actual password change request
			// by creating a key, adding to database and sending email.
			// create key
			$text = 'bcdfghjkmnpqrstvwxyzABCDEFGHJKLMNPRSTUVWXYZ23456789';
			$length = rand(0,2) + 21;
			$x = 0;
			$key = "";
			while ($x<$length) {
				$ranNo = rand(1,strlen($text));
				$a = substr($text, $ranNo, 1);
				$key = $key . $a;
				$x = $x + 1;
			}
			// save in local database (WA_user_login table)
			//connection to the database
			$dbh = mysql_connect($hostname, $dbusername, $dbpassword);
			if (!$dbh) {
					die('Unable to connect to MySQL'.mysql_error());
			}	
			//select a database to work with 
			$db_selected = mysql_select_db("CTIDATABASE",$dbh);
			if (!$db_selected) {
					die ('Could not select database CTIDATABASE '.mysql_error());
			} else {
					// get results (since row returned)
					$query_result = mysql_query("SELECT username,resetkey,resetkeytime FROM WA_user_login WHERE username='{$GLOBALS['email']}' ");
					$num_rows = mysql_num_rows($query_result);
					if ($num_rows == 0) {
							// no row found, insert one
							$ins_result = mysql_query("INSERT INTO WA_user_login (username,resetkey,resetkeytime) VALUES ('{$GLOBALS['email']}','$key','$resetkeytime') ");
							if (!$ins_result) {
									die('Invalid insert: '.mysql_error());
							}
					} else {
							//  row found, update it
							$upd_result = mysql_query("UPDATE WA_user_login SET resetkey='$key', resetkeytime='$resetkeytime' WHERE username='{$GLOBALS['email']}' ");
							if (!$upd_result) {
									die('Invalid update: '.mysql_error());
							}
					}
			}
			// close connection when done
			mysql_close($dbh);
						
			//Prepare Password Reset Request email
//			$to = strip_tags('doraraj.b@madronesoft.com');
                        $to = strip_tags($GLOBALS['email']);
                        
			$subject  = "Subject: CTI Password Reset Request (Webinar Access)";
			$headers  = "From: no-reply@thecoaches.com\r\n";
			//$headers .= "MIME-Version: 1.0\r\n";
			//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			//$headers .= "Cc: " . "\r\n";
			//$headers .= "Bcc: " . "\r\n";
			$body  = "";
			$body .= "Hello,\n\n";
			$body .= "We have received your request for a password reset. Please click the following link to continue. If you did not make this request, please disregard and delete this email.\n\n";
			$body .= "http://www.thecoaches.com/webinar-access/wa-reset-password.php?k=$key\n\n";
			$body .= "The Coaches Training Institute\n1-800-691-6008\n\n";
			// send email
			$sent = mail($to, $subject, $body, $headers);
			if(!$sent){
				// message was not sent
				die("Should never get to: www.thecoaches.com/docs/webinar-access/wa-reset-password-request.php process_form p req email not sent.");
			}
			header("Location: http://www.thecoaches.com/webinar-access/wa-reset-password-request-sent.php");
		} else {
			die("Should never get to: www.thecoaches.com/docs/webinar-access/wa-reset-password-request.php process_form request_ok not one.");
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
		<meta name="copyright" content="Copyright &#169; 2009 The Coaches Training Institute. All rights reserved." />
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
						<h1 id="main-headline">Enter your email address to request a new password</h1>

						<div class="pri">
						 <form action="wa-reset-password-request.php" method="POST">
							<input type="hidden" name="_submit_check" value="1"/> 
							 <table>
								<tr>
							  <th><label for="signin_username">Email address</label></th>
							  <td><input type="text" name="email" id="signin_username" /></td>
								</tr>
								<tr>
								<td></td>
								<td><input type="submit" value="Request Password Reset" /></td>
								</tr>
							 </table>
						</form>
						<?php if ($sf_error_msg != '') {
								echo '<p style="background-color:#ddd;color:#d00;padding:3px;">';
								echo $sf_error_msg;
								echo '</p>';
							} ?>
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
