<?php



require_once ('FileMaker.php');
require_once ('Student.php');

// Checked 3/7/12

$fm = new FileMaker(); 

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD); 

if($_GET['postkey'] == 'fjgh15t'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );

// echo $student->email . "\n";

  if(isset($student->record)){  
      echo 'ok';
    }
  else {
    echo $student->error . "\n";
  }
}

?>
