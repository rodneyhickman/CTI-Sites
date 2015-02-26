<?php

$username = "cticoaches";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

//select a database to work with 
$selected = mysql_select_db("CTIDATABASE",$dbh) 
  or die("Could not select examples");

// get results
$result = mysql_query("SELECT idx,html,location FROM calendar_cache WHERE id=9");

// get row
$row = mysql_fetch_array($result)
?>

