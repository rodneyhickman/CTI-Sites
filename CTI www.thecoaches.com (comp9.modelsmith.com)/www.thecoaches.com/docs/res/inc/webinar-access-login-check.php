<?php
	session_start();
	$filename = "http://www.thecoaches.com/webinar-access/log/cti-webinar-access-loginWA-diagnostics.log";
	$data = date('c').", IP:".$_SERVER['REMOTE_ADDR'].",  Request URI:".$_SERVER['REQUEST_URI'].", Session User name:".$_SESSION['username'].", session_id():".session_id().", User Agent:".$_SERVER['HTTP_USER_AGENT'];  // use commas for CSV format if needed
	/* save referring url */
	$_SESSION['org_referer'] = $_SERVER['PHP_SELF'];
	If ($_SESSION['logged_in'] != 'yes') { 
		/* login and redirect to login page */
		// Log diagnostic info for CTI webinar-access login problem on IE
		$data = $data." Redirected to loginWA page"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
		header("Location: http://www.thecoaches.com/webinar-access/loginWA.php?redirect=".$_SESSION['org_referer']);
		exit;
	} elseif ($_GET['action'] == 'download') {
		if ($_GET['video'] != '') {
			if (file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/abletogetrecord.php?postkey=fjgh15t&em=ping@me.com") == 'ok') {   // 3rd if
				$message = urlencode("Student ".$_SESSION['username']." downloaded the webinar ".$_GET['video']." at ".date("H:i:s")." ET" );
				$result = file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/new_commlog.php?postkey=fjgh15t&em=".$_SESSION['username']."&m=$message");
				header("Location: http://www.thecoaches.com/webinar-access/index.php");
				exit;
			}   // end 4th if
		}
	} else {
		/* already logged in */
		// Log diagnostic info for CTI webinar-access login problem on IE
		$data = $data." Not redirected-already logged in"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
	}
?>
