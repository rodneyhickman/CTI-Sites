<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_GET['postkey'] == 'fjgh15t'){
  
  $layout_name = "Web Course";

  $script_param = $_GET['course_id'];  

  if($_GET['assist'] == 1){
    $script_name = "[WEB]CourseAssistingCancel";
  } 
  else {
    $script_name = "[WEB]CourseFreeCancel";
  }

  $script_object = $fm->newPerformScriptCommand($layout_name, $script_name, $script_param); 
  $script_result = @$script_object->execute();

  //print_r($script_result);

  if (FileMaker::isError($script_result)) {
    echo '{"result":"fail","error":"'.$script_result->getMessage().' (error '.$script_result->code.')"}'."\n";
  }
  else {
    $json = '{"result":"ok","courses":[';

    $course_records = $script_result->getRecords();
    if(isset($course_records)){
      //print_r( $course_records );
      foreach($course_records as $r){
        $json .= "{\n";
        $json .= '"course_id":"'           .$r->getField('zkp_course_n')."\",\n";
        $json .= '"customer code":"'       .$r->getField('zkc_contact_n')."\",\n";
        $json .= '"Event ID":"'            .$r->getField('zkc_event_t')."\",\n";
        $json .= '"Event_Name":"'          .$r->getField('ev_name_t')."\",\n";
        $json .= '"course_start_date":"'   .$r->getField('ev_start_d')."\",\n";
        $json .= '"z_Student_LastFirst":"' .$r->getField('con_nameFL_ct')."\",\n";
        $json .= '"advisors":"'            .$r->getField('zkc_advisor_t')."\",\n";
        $json .= '"creation_date":"'       .$r->getField('aa_CREAT_d')."\",\n";
        $json .= '"reg_action":"'          .$r->getField('zkc_reg_action_t')."\",\n";
        $json .= '"reg_status":"'          .$r->getField('zkc_reg_status_t')."\",\n";
        $json .= '"canceled_date":""'.",\n";
        $json .= '"canceled_by":""';
        $json .= "},\n";
      } 
      $json = rtrim($json, ",\n");
    }
    else {

    }

    $json .= "]}\n";
    echo $json;

  }
  
}

?>
