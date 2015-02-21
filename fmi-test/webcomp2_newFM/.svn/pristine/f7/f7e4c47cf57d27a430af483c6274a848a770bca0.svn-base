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

  $count = count($records);
  echo "doc:\n";
  echo "  count: $count\n";
  echo "  events:\n";


// The list below must match the fields listed in the 'Web Events' layout
  foreach($records as $r){
?>
    -
      fmid: <?php echo $r->getField('zkp_event_t') ?>

      course_type_id: <?php echo $r->getField('zkc_type_event_n') ?>

      event: <?php echo $r->getField('ev_name_t') ?>

      date: <?php echo $r->getField('ev_date_d') ?>

      edate: <?php echo $r->getField('ev_dateEND_dc') ?>

      region: <?php echo $r->getField('zkc_region_t') ?>

      location: <?php echo $r->getField('zkc_location_code_t') ?>

      publish: <?php echo $r->getField('Publish') ?>

      call_time: <?php echo $r->getField('ev_calltime_t') ?>

      student_count: <?php echo $r->getField('zc_student_reg_nc') ?>

      record_id: 0
      pod_name: <?php echo $r->getField('Pod Name') ?>

      leader_name: <?php echo $r->getField('leader') ?>

      assistant_count: <?php echo $r->getField('zc_assistant_reg_nc') ?>

      assistant_wait_count: <?php echo $r->getField('zc_assistant_wait_nc') ?>

      booking_link: <?php echo $r->getField('Booking Link') ?>

      mod_id: <?php echo $r->getField('aa_MOD_m') ?>

      mod_date: <?php echo $r->getField('aa_MOD_d') ?>

      mod_time: <?php echo $r->getField('aa_MOD_t') ?>

<?php
      }
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


