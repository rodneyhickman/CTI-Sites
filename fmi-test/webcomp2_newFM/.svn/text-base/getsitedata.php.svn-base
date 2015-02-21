<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

// Find with criteria
$findCommand =& $fm->newFindCommand('Web Location'); 
//$findCommand->addFindCriterion('Event Date','>'.date('m/d/Y')); 

$result = $findCommand->execute();

// Get records from found set 
if(!FileMaker::isError($result)){
  $records = $result->getRecords(); 
}



?>
doc:
<?php if(FileMaker::isError($result)): ?>
  error: <?php echo $result->getMessage() ?>
<?php endif ?>
  count: <?php echo count($records) ?>

  sites:
<?php foreach($records as $r): ?>
    -
      code: <?php echo $r->getField('zkp_location_code_t') ?>

      location_id: <?php echo $r->getField('zkp_location_t') ?>

      booking_link: <?php echo $r->getField('Booking Link') ?>

      name: <?php echo $r->getField('Location_Name') ?>

      address: <?php echo preg_replace("/[\n\r]/",' ',$r->getField('Location_Address')) ?>

      city: <?php echo $r->getField('Location_City') ?>

      state: <?php echo $r->getField('Location_State') ?>

      zip: <?php echo $r->getField('Location_Zip') ?>

      url: <?php echo $r->getField('Location_URL') ?>

      phone: <?php echo $r->getField('Location_Phone') ?>

      fax: <?php echo $r->getField('Location_Fax') ?>

      region: <?php echo $r->getField('zkc_region_t') ?>

<?php endforeach ?>