<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 



$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


// FindAll
// Usage: $fm->newFindAllCommand('LAYOUT',$values);
// $findCommand =& $fm->newFindAllCommand('Form View'); 

// Find with criteria
$findCommand =& $fm->newFindCommand('Web Contact'); 
$findCommand->addFindCriterion('y_faculty_n','==1');


$result = $findCommand->execute();

if($_GET['postkey']=='fjgh15t'){
  // Get records from found set 
  if(!FileMaker::isError($result)){
    $records = $result->getRecords();
  } 
}


?>
leaders=[
<?php foreach($records as $r){ ?>
{"label":"<?php echo $r->getField('con_nameF')?> <?php echo $r->getField('con_nameL') ?>",
 "cti_faculty":"<?php echo $r->getField('y_faculty_n') ?>",
 "active":"<?php echo $r->getField('y_active_n') ?>"},
<?php } ?>
]
