<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_GET['postkey'] == 'fjgh15t'){

  $student = new Student();
  
  $fmid =   @$_GET['fmid'];
  if($fmid){
    $student->get_record_by_id( $fm, $fmid );
  }
  else {
    $em = @$_GET['em'];
    if($em){
      $student->get_record( $fm, $em );
    }
  }
  
  if(isset($student->record)){  
    $r = $student->record;
    $json = '{"status":"ok",'."\n";
    $json .= '"record_id":"'      .$r->getField('zkc_contact_recID')."\",\n";
    $json .= '"first_name":"'     .$r->getField('con_nameF')."\",\n";
    $json .= '"middle_initial":"' .$r->getField('con_nameM')."\",\n";
    $json .= '"last_name":"'      .$r->getField('con_nameL')."\",\n";
    $json .= '"address":"'        .$r->getField('add_hm_street')."\",\n";
    $json .= '"address_2":"'      .$r->getField('add_hm_street2')."\",\n";
    $json .= '"city":"'           .$r->getField('add_hm_city')."\",\n";
    $json .= '"state":"'          .$r->getField('add_hm_state')."\",\n";
    $json .= '"zip":"'            .$r->getField('add_hm_zip')."\",\n";
    $json .= '"country":"'        .$r->getField('add_hm_country')."\",\n";

    $json .= '"home_phone":"'     .$r->getField('add_hm_phone')."\",\n";
    $json .= '"cell_phone":"'     .$r->getField('add_hm_phone_cell')."\",\n";
    $json .= '"business_phone":"",'."\n";
    $json .= '"level":"'              .$r->getField('zk_level_max_compl')."\",\n";
    $json .= '"y_lp_n":"'             .$r->getField('y_LP_n')."\",\n";
    $json .= '"cpcc_cert_date":"'     .$r->getField('CPCC Cert')."\",\n";
    $json .= '"cpcc_grad_pod":"'      .$r->getField('CPCC Grad')."\",\n";
    $json .= '"faculty":"'            .$r->getField('y_faculty_n')."\",\n";
    $json .= '"zc_level_max_compl":"' .$r->getField('zc_level_max_compl')."\",\n";

    $courses = preg_replace( '/\n/',',',$r->getField('y_reg_complcore_ct') );
    $json .= '"y_reg_complcore_ct":"'."$courses\",\n";

    $json .= '"fmid":"'               .$r->getField('zkp_contact_n')."\"\n";
    
     $json .= "}\n";
     echo $json;
  }
  else {
    echo '{"status":"'.$student->error . "\"}\n";
  }
}

?>
