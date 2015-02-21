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
  $student->get_record_by_id( $fm, $_GET['fmid'] );

// echo $student->email . "\n";

  if(isset($student->record)){
    $level = $student->record->getField( 'zc_level_max_compl' ); // Max_Level_Completed in old database
    if($level ==''){
      $level = $student->record->getField( 'Level' ); // probably incorrect
    }
    echo $level;
  }
  else {
    echo "0";
  }
}

?>
