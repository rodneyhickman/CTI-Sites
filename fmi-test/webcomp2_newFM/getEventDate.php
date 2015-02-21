<?php
require_once('FileMaker.php');
require_once('Student.php');

$event_date_not_found_message = "Dates will be announced soon.";

$event_type = $_GET['event_type'];
//$return_type = $_GET['return_type'];
// event types
// CoActSales => Coactive Sales 
// CoActMkt => Coactive Marketing
// CoachTrx => Coactive Executive Coaching

// query description: select the records from events where "event type is anyone of the above" and "event is publishable" and "event is not cancelled" and "event is not on hold", then sort them in ascending order by event date.
//echo date("m/d/Y", strtotime(date("")."+1 month"));
$fm = new FileMaker();

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

$findCommand =& $fm->newFindCommand('Web Event');

//$findCommand->addFindCriterion('zkp_event_t','=20872');
$findCommand->addFindCriterion('ev_date_d','>='.date("m/d/Y", strtotime(date("")."+1 month")));
$findCommand->addFindCriterion('zkc_type_event_t','=='.$event_type);
$findCommand->addFindCriterion('Publish','==Publish');
//$findCommand->addFindCriterion('y_holding_n','==0');

$result = $findCommand->execute();

if (FileMaker::isError($result)) {
	die('<p>'.$result->getMessage().' (error '.$result->code.')</p>');
}

// Get records from found set 
$records = $result->getRecords(); 
if(count($records) == 0){
	$json_fmt_msg = $event_date_not_found_message;
} else {
	$first_record = $records[0];
	//echo "event date = ".$first_record->getField('ev_date_d')."<br>";
	$day_of_event_date = date('l', strtotime($first_record->getField('ev_date_d')));
	$event_date = $day_of_event_date.', '.date("F d, Y", strtotime($first_record->getField('ev_date_d')));
	$enroll_start_date = date("m/d/Y", strtotime($first_record->getField('ev_date_d')." -3 month"));
	$day_of_enroll_start_date = date('l', strtotime($enroll_start_date));
	$enroll_date = $day_of_enroll_start_date.', '.date("F d, Y", strtotime($enroll_start_date));
	$json_fmt_msg = '{"event_date":"'.$event_date.'","enroll_date":"'.$enroll_date.'"}';
	
//	echo "day of event date = ".$day_of_event_date."<br><br>";
//	echo "<br><br>First record = <br><br>";
//	print_r($first_record);
//	echo "<br><br>All records = <br><br>";
//	print_r($records);
}
echo $json_fmt_msg;
?>