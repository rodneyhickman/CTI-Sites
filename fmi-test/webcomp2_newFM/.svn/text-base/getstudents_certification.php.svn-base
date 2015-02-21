<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


// FindAll
// Usage: $fm->newFindAllCommand('LAYOUT',$values);
// $findCommand =& $fm->newFindAllCommand('Form View'); 

$ago = 8; // hours ago

// Find with criteria
$findCommand =& $fm->newFindCommand('Web Contact'); 
$findCommand->addFindCriterion('aa_MOD_m','>'.date('m/d/Y H:i:s', time() - ($ago * 3600) )); 


$result = $findCommand->execute();

if($_GET['postkey']=='fjgh15t'){
  // Get records from found set 
  if(!FileMaker::isError($result)){
    $records = $result->getRecords();
  } 
}


?>
doc:
<?php if(FileMaker::isError($result)): ?>
  error: <?php echo $result->getMessage() ?>
<?php endif ?>
  count: <?php echo count($records) ?>

  contacts:
<?php foreach($records as $r){
$cert_courses = $r->getField('y_reg_complcore_ct');
$cert_courses = preg_replace('/\n/',",",$cert_courses);
$courses = $r->getField('y_reg_complcore_ct');
$courses = preg_replace('/\n/',",",$courses);
?>
    -
      fm_id: <?php echo $r->getField('zkp_contact_n') ?>

      first_name: <?php echo $r->getField('con_nameF') ?>

      last_name: <?php echo $r->getField('con_nameL') ?>

      email: <?php echo $r->getField('con_email') ?>

      level: <?php echo $r->getField('zk_level_max_compl') ?>

      last_activity: <?php echo $r->getField('aa_MOD_m') ?>

      courses: "<?php echo $courses ?>"
      cert_courses: "<?php echo $cert_courses ?>"
      cpcc_cert_date: <?php echo $r->getField('CPCC Cert') ?>

      cpcc_grad: <?php echo $r->getField('CPCC Grad') ?>

      cti_faculty: <?php echo $r->getField('y_faculty_n') ?>

      active: <?php echo $r->getField('y_active_n') ?>

<?php } ?>



