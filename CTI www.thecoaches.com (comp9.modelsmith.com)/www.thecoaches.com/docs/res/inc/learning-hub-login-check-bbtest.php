<?php
	session_start();
	$filename = "/tmp/cti-learning-hub-loginLH-diagnostics.log";
	$data = date('c').", IP:".$_SERVER['REMOTE_ADDR'].",  Request URI:".$_SERVER['REQUEST_URI'].", Session User name:".$_SESSION['username'].", session_id():".session_id().", User Agent:".$_SERVER['HTTP_USER_AGENT'];  // use commas for CSV format if needed
	/* save referring url */
	$_SESSION['org_referer'] = $_SERVER['PHP_SELF'];
	If ($_SESSION['logged_in'] != 'yes') { 
		/* login and redirect to login page */
		// Log diagnostic info for CTI learning-hub login problem on IE
		$data = $data." Redirected to loginLH page"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
		header("Location: http://www.thecoaches.com/learning-hub/bbtest-loginLH.html?redirect=".$_SESSION['org_referer']);
		exit;
	} else {
		/* already logged in */
		// Log diagnostic info for CTI learning-hub login problem on IE
		$data = $data." Not redirected-already logged in"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
	}
?>
