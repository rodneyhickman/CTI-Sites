<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_GET['postkey'] == 'fjgh15t'){  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );
  if(isset($student->record)){
	$leader = $student->isLeader($fm, $_GET['em']);
	if ($leader == '1') {
		echo '1';  // student is a leader
	} else {
		echo '0';  // student is not a leader
	}
  } else {
	echo '-1'; // student does not exists.
  }
}
?>