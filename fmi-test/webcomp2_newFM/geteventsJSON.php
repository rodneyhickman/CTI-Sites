<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$start = $_GET['start'];
$range = $_GET['range'];

if($range > 0 && $range < 501){

  $fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


// FindAll
// Usage: $fm->newFindAllCommand('LAYOUT',$values);
// $findCommand =& $fm->newFindAllCommand('Form View'); 

// Find with criteria
  $findCommand =& $fm->newFindCommand('Web Event'); 
  $findCommand->addFindCriterion('ev_date_d','>='.date('m/d/Y')); 




  $findCommand->setRange($start, $range);
  $result = $findCommand->execute();

  if (FileMaker::isError($result)) {
    die('<p>'.$result->getMessage().' (error '.$result->code.')</p>');
  }

// Get records from found set 
  $records = $result->getRecords(); 
  if(count($records) == 0){
    break;
  }

  $events = array( );

// The list below must match the fields listed in the 'Web Events' layout
  foreach($records as $r){

    $event = array(
      'fmid'                 => $r->getField('zkp_event_t'),
      'course_type_id'       => $r->getField('zkc_type_event_n'),
      'event'                => $r->getField('ev_name_t'),
      'date'                 => $r->getField('ev_date_d'),
      'edate'                => $r->getField('ev_dateEND_dc'),
      'region'               => $r->getField('zkc_region_t'),
      'location'             => $r->getField('zkc_location_code_t'),
      'publish'              => $r->getField('Publish'),
      'call_time'            => $r->getField('ev_calltime_t'),
      'student_count'        => $r->getField('zc_student_reg_nc'),
      'pod_name'             => $r->getField('Pod Name'),
      'leader_name'          => $r->getField('leader'),
      'assistant_count'      => $r->getField('zc_assistant_reg_nc'),
      'assistant_wait_count' => $r->getField('zc_assistant_wait_nc'),
      'booking_link'         => $r->getField('Booking Link'),
      'mod_id'               => $r->getField('aa_MOD_m'),
      'mod_date'             => $r->getField('aa_MOD_d'),
      'mod_time'             => $r->getField('aa_MOD_t')
      );

    $events[] = $event;

  }

  echo json_encode($events);
}

// Example: curl 'http://crm.thecoaches.com/fmi-test/webcomp2_newFM/geteventsJSON.php?start=0&range=10'

