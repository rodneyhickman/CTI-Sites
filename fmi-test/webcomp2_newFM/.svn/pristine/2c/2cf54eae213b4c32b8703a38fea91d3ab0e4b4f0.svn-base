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
    if($_GET['em'] == 'ping@me.com'){ // for testing purposes
      echo 'ok';
    }
    else {
      $is_authenticated = $student->authenticate_cpcc( $_GET['pw'] );

      if($is_authenticated == true){
        echo 'ok';
      }
      else {
        echo 'fail';
      }
    }
  }
  else {
    echo 'fail';
  }
}

?>
