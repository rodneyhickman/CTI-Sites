<?php
require_once ('FileMaker.php');
require_once ('Student.php');

// Changed 3/7/12

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


if($_GET['postkey'] == 'fjgh15t'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );

  if(isset($student->record)){  
    echo 'country: '.$student->record->getField('add_hm_country')."\n";
  }
  else {
    echo 'country: unknown'."\n";
  }
}

?>
