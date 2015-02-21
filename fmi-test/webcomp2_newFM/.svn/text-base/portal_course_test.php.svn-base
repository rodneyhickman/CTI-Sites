<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

$fm->setProperty('database', 'CTI_DB'); 
$fm->setProperty('username', 'Admin'); 
$fm->setProperty('password', 'alpha123'); 

if($_GET['postkey'] == 'fjgh15t'){
  
  $layout_name = "Web Course";
  $script_name = "[WEB]CourseFreeCreate";

  $script_param = $_GET['student_id'].";".$_GET['event_id'];  

  $script_object = $fm->newPerformScriptCommand($layout_name, $script_name, $script_param); 
  $script_result = @$script_object->execute();

  //print_r($script_result);

  if (FileMaker::isError($script_result)) {
    echo '{"status":"fail","error":"'.$script_result->getMessage().' (error '.$script_result->code.')"}'."\n";
  }
  else {
    $json = '{"status":"ok","courses":[';

    $course_records = $script_result->getRecords();
    if(isset($course_records)){
      //print_r( $course_records );
      foreach($course_records as $r){
        $json .= "{\n";
        $json .= '"course_id":"'           .$r->getField('__CRSE_ID')."\",\n";
        $json .= '"customer code":"'       .$r->getField('customer code')."\",\n";
        $json .= '"Event ID":"'            .$r->getField('Event ID')."\",\n";
        $json .= '"Event_Name":"'          .$r->getField('Event_Name')."\",\n";
        $json .= '"course_start_date":"'   .$r->getField('Course date start')."\",\n";
        $json .= '"z_Student_LastFirst":"' .$r->getField('z_Student_LastFirst')."\"\n";
        $json .= '"advisors":"'            .$r->getField('advisors')."\"\n";
        $json .= '"creation_date":"'       .$r->getField('Creation Date')."\"\n";
        $json .= '"reg_action":"'          .$r->getField('Reg_Action')."\"\n";
        $json .= '"reg_status":"'          .$r->getField('Reg Status')."\"\n";
        $json .= '"canceled_date":"'       .$r->getField('Canceled_Date')."\"\n";
        $json .= '"canceled_by":"'         .$r->getField('Canceled_By')."\"\n";
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
