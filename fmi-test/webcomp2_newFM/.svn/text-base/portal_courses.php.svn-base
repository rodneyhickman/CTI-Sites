<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_GET['postkey'] == 'fjgh15t'){
  
  $fmid =   $_GET['fmid'];

  $student = new Student();
  $student->get_record_by_id( $fm, $fmid );

  
  if(isset($student->record)){  
    
    $json = '{"status":"ok","courses":[';

    $student->get_courses( $fm, $fmid );
    if(isset($student->course_records)){
      //print_r( $student->course_records );
      foreach($student->course_records as $r){
        $json .= "{\n";
        $json .= '"course_id":"'           .$r->getField('zkp_course_n')."\",\n";
        $json .= '"customer code":"'       .$r->getField('zkc_contact_n')."\",\n";
        $json .= '"Event ID":"'            .$r->getField('zkc_event_t')."\",\n";
        $json .= '"Event_Name":"'          .$r->getField('ev_name_t')."\",\n";
        $json .= '"course_type_id":"'      .$r->getField('zkc_type_event_n')."\",\n";
        $json .= '"course_start_date":"'   .$r->getField('ev_start_d')."\",\n";
        $json .= '"z_Student_LastFirst":"' .$r->getField('con_nameFL_ct')."\",\n";
        $json .= '"advisors":"'            .$r->getField('zkc_advisor_t')."\",\n";
        $json .= '"creation_date":"'       .$r->getField('aa_CREAT_d')."\",\n";
        $json .= '"reg_action":"'          .$r->getField('zkc_reg_action_n')."\",\n";
        $json .= '"reg_status":"'          .$r->getField('zkc_reg_status_t')."\",\n";
        $json .= '"canceled_date":""'.",\n";
        $json .= '"canceled_by":""';
        $json .= "},\n";
      } 
    }
    else {

    }

    $json = rtrim($json, ",\n");
    $json .= "]}\n";
    echo $json;
  }
  else {
    echo '{"status":"'.$student->error . "\"}\n";
  }
}

?>
