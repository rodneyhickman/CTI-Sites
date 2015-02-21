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

      $r->setField('con_nameF',         @$_POST['first_name']);
      //$r->setField('con_nameM',       @$_POST['middle_initial']);
      $r->setField('con_nameL',         @$_POST['last_name']);
      $r->setField('add_hm_street',     @$_POST['address']);
      //$r->setField('add_hm_street2',  @$_POST['address2']);
      $r->setField('add_hm_city',       @$_POST['city']);
      $r->setField('add_hm_state',      @$_POST['state']);
      $r->setField('add_hm_zip',        @$_POST['zip']);
      $r->setField('add_hm_country',    @$_POST['country']);
      $r->setField('add_hm_phone',      @$_POST['home_phone']);
      $r->setField('add_hm_phone_cell', @$_POST['cell_phone']);

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
