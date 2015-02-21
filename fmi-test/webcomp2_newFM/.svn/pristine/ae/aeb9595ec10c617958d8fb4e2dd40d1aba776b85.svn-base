<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 
//$databases = $fm->listDatabases(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

//$student = new Student();

// FindAll
// Usage: $fm->newFindAllCommand('LAYOUT',$values);
// $findCommand =& $fm->newFindAllCommand('Form View'); 

// Find with criteria
$findCommand =& $fm->newFindCommand('Web Event'); 
$findCommand->addFindCriterion('ev_date_d','>='.date('m/d/Y')); 



$result = $findCommand->execute();

if (FileMaker::isError($result)) {
  die('<p>'.$result->getMessage().' (error '.$result->code.')</p>');
}

// Get records from found set 
$records = $result->getRecords(); 




?>
doc:
<?php if(FileMaker::isError($result)): ?>
  error: <?php echo $result->getMessage() ?>
<?php endif ?>
  count: <?php echo count($records) ?>

  events:
<?php foreach($records as $r): ?>
    -
      fmid: <?php echo $r->getField('zkp_event_t') ?>

      course_type_id: <?php echo $r->getField('zkc_type_event_n') ?>

      event: <?php echo $r->getField('ev_name_t') ?>

      date: <?php echo $r->getField('ev_date_d') ?>

      region: <?php echo $r->getField('zkc_region_t') ?>

      location: <?php echo $r->getField('zkc_location_t') ?>

      publish: <?php echo $r->getField('Publish') ?>

      call_time: <?php echo $r->getField('call time') ?>

      student_count: <?php echo $r->getField('zc_student_reg_nc') ?>

      pod_name: <?php echo $r->getField('Pod Name') ?>

      leader_name: <?php echo $r->getField('leader') ?>

      assistant_count: <?php echo $r->getField('zc_assistant_reg_nc') ?>

      assistant_wait_count: <?php echo $r->getField('zc_assistant_wait_nc') ?>

      booking_link: <?php echo $r->getField('Booking Link') ?>

      mod_id: <?php echo $r->getField('aa_MOD_m') ?>

      mod_date: <?php echo $r->getField('aa_MOD_d') ?>

      mod_time: <?php echo $r->getField('aa_MOD_t') ?>

<?php endforeach ?>


<?php

$doc = <<<EOT
my %map = (
	   'Event_ID'           => 'fmid',
	   'call_time'          => 'call_time',
           'City_code'          => 'region',
           'modificationdate'   => 'mod_date',
           'Course_date'        => 'date',
           'Publish'            => 'publish',
           'CourseTypeID'       => 'course_type_id',
	   'Count_Courses'      => 'student_count',
           'MODID'              => 'mod_id',
           'Course_location'    => 'location',
           'RECORDID'           => 'record_id',
           'modificationtime'   => 'mod_time',
	   'Pod_Name'           => 'pod_name',
           'Course_Name'        => 'event',
	   'AssistantCount'     => 'assistant_count',
	   'AssistantWaitCount' => 'assistant_wait_count',
           'Booking_Link'       => 'booking_link',
	   );
EOT;
?>

