<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


if($_GET['postkey'] == 'fjgh15t'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );

// echo $student->error . "\n";
// echo $student->email . "\n";

  if(isset($student->record)){  
    $student->new_commlog( $_GET['m'],$_GET['r'] );
    echo 'ok';
  }
  else {
    echo 'fail';
  }
}

?>
