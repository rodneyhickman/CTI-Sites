<?php
	session_start();
	$filename = "/tmp/cti-learning-hub-loginLH-diagnostics.log";
	$data = date('c').", IP:".$_SERVER['REMOTE_ADDR'].",  Request URI:".$_SERVER['REQUEST_URI'].", Session User name:".$_SESSION['username'].", session_id():".session_id().", User Agent:".$_SERVER['HTTP_USER_AGENT'];  // use commas for CSV format if needed
	/* save referring url */
	$_SESSION['org_referer'] = $_SERVER['PHP_SELF'];
        if (preg_match('/mycoactive/',$_SERVER['HTTP_REFERER'])){
          // automatically login if coming from mycoactive.com
          $_SESSION['logged_in'] = 'yes';
          // Log diagnostic info
          $data = $data." automatic login from ".$_SERVER['HTTP_REFERER']."\n";
          file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
          // end diagnostic
        }
        else if(preg_match('/learning-hub\/(fundamentals|intermediate)/',$_SERVER['REQUEST_URI'])){
	  // Bypass login for fundamentals and intermediate per Kevin Day 6/19/2014 Thomas Beutel
		/* already logged in */
		// Log diagnostic info for CTI learning-hub login problem on IE
		$data = $data." Not redirected-bypassed to fundamentals or intermediate"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
        }
	else if ($_SESSION['logged_in'] != 'yes') { 
		/* login and redirect to login page */
		// Log diagnostic info for CTI learning-hub login problem on IE
		$data = $data." Redirected to loginLH page"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
		header("Location: http://www.thecoaches.com/learning-hub/loginLH.html?redirect=".$_SESSION['org_referer']);
		exit;
	} else {
		/* already logged in */
		// Log diagnostic info for CTI learning-hub login problem on IE
		$data = $data." Not redirected-already logged in"."\n";
		file_put_contents ($filename, $data, FILE_APPEND | LOCK_EX);
		// end diagnostic
	}
?>
