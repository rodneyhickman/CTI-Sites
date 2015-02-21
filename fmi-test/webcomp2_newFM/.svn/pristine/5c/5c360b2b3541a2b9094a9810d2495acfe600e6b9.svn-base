<?php
require_once ('FileMaker.php');
require_once ('Student.php');
include ('xtea.class.php');
include ('shared_secret.php');

$fm = new FileMaker(); 

$fm->setProperty('database', 'CTI_DB'); 
$fm->setProperty('username', 'Admin'); 
$fm->setProperty('password', 'alpha123'); 

if($_GET['postkey'] == 'fjgh15t'){
  
  $student = new Student();
  $student->get_record( $fm, $_GET['em'] );
  
  if(isset($student->record)){
    $xtea = new XTEA($key);
    $cc_type      = $xtea->Decrypt( $_GET['cc_type'] );
    $cc_number    = $xtea->Decrypt( $_GET['cc_number'] );
    $cc_exp_month = $xtea->Decrypt( $_GET['cc_exp_month'] );
    $cc_exp_year  = $xtea->Decrypt( $_GET['cc_exp_year'] );
    $cc_name      = $xtea->Decrypt( $_GET['cc_name'] );
    echo $student->set_certification_cc_card( $cc_type, $cc_number, $cc_exp_month, $cc_exp_year, $cc_name );
  }
  else {
    echo 'fail';
  }
}

?>
