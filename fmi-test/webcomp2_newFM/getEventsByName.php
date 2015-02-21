<?php
require_once('FileMaker.php');
require_once('Student.php');

$event_date_not_found_message = "Dates will be announced soon.";

$event_name = $_GET['event_name'];
// event types
// CoActSales => Coactive Sales 
// CoActMkt => Coactive Marketing
// CoachTrx => Coactive Executive Coaching

// query description: select the records from events where "event type is anyone of the above" and "event is publishable" and "event is not cancelled" and "event is not on hold", then sort them in ascending order by event date.
echo date("m/d/Y", strtotime(date("")."+1 month"));
$fm = new FileMaker();

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

$findCommand =& $fm->newFindCommand('Web Event');

$findCommand->addFindCriterion('ev_name_t','=='.$event_name);

$result = $findCommand->execute();

if (FileMaker::isError($result)) {
	die('<p>'.$result->getMessage().' (error '.$result->code.')</p>');
}

// Get records from found set 
$records = $result->getRecords(); 
echo "Total number of records: ".count($records);
echo "<br><br><hr>";
foreach($records as $record){
	print_r($record);
	echo "<br><br><hr>";
  }
?>