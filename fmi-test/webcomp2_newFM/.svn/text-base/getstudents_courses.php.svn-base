<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 
//$databases = $fm->listDatabases(); 

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

      y_Bridge_d_compl: <?php echo $r->getField('y_Bridge_d_compl')  ?>

      courses: "<?php echo $courses ?>"

<?php } ?>



