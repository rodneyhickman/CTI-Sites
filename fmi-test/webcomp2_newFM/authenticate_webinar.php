<?php
require_once ('FileMaker.php');
require_once ('Student.php');

// changed 3/10/12

$fm = new FileMaker(); 

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


if($_GET['postkey'] == 'fjgh15t'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );
  echo $student->authenticate_webinar( $_GET['pw'] );
//  echo 'web_login = '.$student->record->getField('web_login');

//  if(isset($student->record)){  
//    $is_authenticated = (int)$student->authenticate_webinar( $_GET['pw'] );
////	echo 'Result from student->authenticate_webinar( ) = '.(int)$student->authenticate_webinar($_GET['pw']);
////	echo 'is_authenticated = '.(int)$is_authenticated;
	
//    if($is_authenticated == 1){
//      echo '1';  // student is authenticated
//    }
//    else {
//      echo '0';  // student is not authenticated
//    }
//  }
//  else {
//    echo 'fail';
//  }
}

?>
