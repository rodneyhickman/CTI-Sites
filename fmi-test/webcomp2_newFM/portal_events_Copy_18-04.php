<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$start_date     = $_GET['start_date'];
$timestamp      = strtotime($start_date);
$course_type_id = $_GET['course_type_id'];
$not_published  = isset($_GET['np']) ? 1 : 0;

$fm = new FileMaker(); 

if($_GET['postkey'] == 'fjgh15t'){

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


// Find with criteria
  $findCommand =& $fm->newFindCommand('Web Event'); 
  $findCommand->addFindCriterion('ev_date_d','>='.date('m/d/Y',$timestamp)); 
  $findCommand->addFindCriterion('zkc_type_event_n','='.$course_type_id);

  if($not_published == 1){
    $findCommand->addFindCriterion('Publish',"==Don't Publish"); // == means exact match
  }
  else {
    $findCommand->addFindCriterion('Publish',"==Publish"); // == means exact match
  }

  $result = $findCommand->execute();

  if (FileMaker::isError($result)) {
    die('{"status":"'.$result->getMessage().' (error '.$result->code.')"}'."\n");
  }

// Get records from found set 
  $records = $result->getRecords(); 
  if(count($records) == 0){
    break;
  }

  $count = count($records);
  $json  = "{\n";
  $json .= '"count": "'.$count.'",'."\n";

  $json .= '"fields":['."\n";
  $layout = $result->getLayout();
  $fields = $layout->listFields();
  foreach($fields as $field){
    $json .= '"'.$field.'"'.",\n";
  }
  $json = rtrim($json,",\n");
  $json .= "],\n";


  $json .= '"events":['."\n";
// The list below must match the fields listed in the 'Web Events' layout
  foreach($records as $r){
    $json .= "{\n";
    $json .= '"fmid": "'.                 $r->getField('zkp_event_t')          ."\",\n";
    $json .= '"course_type_id": "'.       $r->getField('zkc_type_event_n')     ."\",\n";
    $json .= '"event": "'.                $r->getField('ev_name_t')            ."\",\n";
    $json .= '"date": "'.                 $r->getField('ev_date_d')            ."\",\n";
    $json .= '"edate": "'.                $r->getField('ev_dateEND_dc')        ."\",\n";
    $json .= '"region": "'.               $r->getField('zkc_region_t')         ."\",\n";
    $json .= '"location": "'.             $r->getField('zkc_location_code_t')       ."\",\n";
    $json .= '"publish": "'.              $r->getField('Publish')              ."\",\n";
    $json .= '"call_time": "'.            $r->getField('ev_calltime_t')            ."\",\n";
    $json .= '"bridge_phone": "'.            $r->getField('Bridge Phone')            ."\",\n";
    $json .= '"student_count": "'.        $r->getField('zc_student_reg_nc')    ."\",\n";
    $json .= '"max_count": "'.            $r->getField('zc_student_max_n')     ."\",\n";
    $json .= '"record_id": ""'                                                 .",\n";
    $json .= '"pod_name": "'.             $r->getField('Pod Name')             ."\",\n";
    $json .= '"leader_name": "'.          $r->getField('leader')               ."\",\n";
    $json .= '"assistant_count": "'.      $r->getField('zc_assistant_reg_nc')  ."\",\n";
    $json .= '"assistant_wait_count": "'. $r->getField('zc_assistant_wait_nc') ."\",\n";
    $json .= '"student_wait_count": "'.   $r->getField('zc_student_wait_nc')   ."\",\n";
    $json .= '"booking_link": "'.         $r->getField('Booking Link')         ."\",\n";
    $json .= '"mod_id": "'.               $r->getField('aa_MOD_m')             ."\",\n";
    $json .= '"mod_date": "'.             $r->getField('aa_MOD_d')             ."\",\n";
    $json .= '"mod_time": "'.             $r->getField('aa_MOD_t')             ."\"\n";
    $json .= "},\n";

  }

  $json = rtrim($json,",\n");
  $json .= "]}\n";
  echo $json;
}



$doc = <<<EOT
my %map = (
	   'Event_ID' => 'fmid',
	   'call_time' => 'call_time',
           'City_code' => 'region',
           'modificationdate' => 'mod_date',
           'Course_date' => 'date',
           'Publish' => 'publish',
           'CourseTypeID' => 'course_type_id',
	   'Count_Courses' => 'student_count',
           'MODID' => 'mod_id',
           'Course_location' => 'location',
           'RECORDID' => 'record_id',
           'modificationtime' => 'mod_time',
	   'Pod_Name' => 'pod_name',
           'Course_Name' => 'event',
	   'AssistantCount' => 'assistant_count',
	   'AssistantWaitCount' => 'assistant_wait_count',
           'Booking_Link' => 'booking_link',
	   );
EOT;


