<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_POST['postkey'] == 'fjgh15t'){

  $student = new Student();
  
  $fmid =   @$_POST['fmid'];
  if($fmid){
    $student->get_record_by_id( $fm, $fmid );
  
    if(isset($student->record)){  
      $r = $student->record;


      $r->setField('con_email', @$_POST['email']);
      $result = $r->commit();

      $json = '{"status":"ok"}'."\n";
      echo $json;
    }
    else {
      echo '{"status":"'.$student->error . "\"}\n";
    }
  }
  else {
    echo '{"status":"fail, no such student id"}'."\n";
  }
}

// Example of setting a field
 // public function set_password( $new_password )
 //  {
 //    $this->record->setField('Password',$new_password);
 //    $result = $this->record->commit();
 //  }

?>
