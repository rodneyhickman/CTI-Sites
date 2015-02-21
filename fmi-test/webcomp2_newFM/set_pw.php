<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_GET['postkey'] == 'fjgh12fgt'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );
  
  if(isset($student->record)){
    $student->set_password( $_GET['pw'] );
    echo 'ok';
  }
  else {
    echo 'fail';
  }
}

?>
