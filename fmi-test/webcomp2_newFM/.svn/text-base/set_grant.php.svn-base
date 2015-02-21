<?php
require_once ('OrgGrants.php');

// test this thusly:
// curl -X POST -d @/Users/thomas/Desktop/post_data.txt http://webcomp.modelsmith.com/fmi-test/webcomp/set_org.php

if($_POST['postkey'] == 'fjgh15t'){
  
  $org_grant = new OrgGrant();
  //$org_grant->get_record_by_id( $_POST['fmid'] );  
  $org_grant->get_record_by_id_dummy( $_POST['fmid'] );

  if( isset($org_grant->record) ){

 $data['org_id']   = $_POST['org_id']; 
  $data['board_meeting']   = $_POST['board_meeting']; 
  $data['grant_number']   = $_POST['grant_number']; 
  $data['project_name']   = $_POST['project_name']; 
  $data['project_description']   = $_POST['project_description']; 
  $data['br_project_budget']   = $_POST['br_project_budget']; 
  $data['br_number_youth']   = $_POST['br_number_youth']; 
  $data['br_age']   = $_POST['br_age']; 
  $data['br_collaborative_partners']   = $_POST['br_collaborative_partners']; 
  $data['br_other_funding']   = $_POST['br_other_funding']; 
  $data['br_edu_extended_learning_day']   = $_POST['br_edu_extended_learning_day']; 
  $data['br_edu_credentialed_teachers']   = $_POST['br_edu_credentialed_teachers']; 
  $data['br_edu_summer_program']   = $_POST['br_edu_summer_program']; 
  $data['app_1a_describe']   = $_POST['app_1a_describe']; 
  $data['app_1b_goals']   = $_POST['app_1b_goals']; 
  $data['app_1c_timeline']   = $_POST['app_1c_timeline']; 
  $data['app_1d_num_impacted']   = $_POST['app_1d_num_impacted']; 
  $data['app_2a_strategies']   = $_POST['app_2a_strategies']; 
  $data['app_2b_other_sources']   = $_POST['app_2b_other_sources']; 
  $data['app_2c_personnel']   = $_POST['app_2c_personnel']; 
  $data['app_3a_demographics']   = $_POST['app_3a_demographics']; 
  $data['app_3b_measurements']   = $_POST['app_3b_measurements']; 
  $data['app_4a_collaboration']   = $_POST['app_4a_collaboration']; 
  $data['app_4b_share_w_programs']   = $_POST['app_4b_share_w_programs']; 
  $data['app_4c_share_w_teachers']   = $_POST['app_4c_share_w_teachers']; 
  $data['app_5a_project_budget']   = $_POST['app_5a_project_budget']; 
  $data['app_5b_agency_budget']   = $_POST['app_5b_agency_budget']; 
  $data['app_6a_reflection']   = $_POST['app_6a_reflection']; 
  $data['app_6b_changes']   = $_POST['app_6b_changes']; 
  $data['app_6c_new_goals']   = $_POST['app_6c_new_goals']; 
  $data['app_7a_one_child_journey']   = $_POST['app_7a_one_child_journey']; 
  $data['app_8a_renewal_goals']   = $_POST['app_8a_renewal_goals']; 




    //$org_grant->set_org( $data );
    $org_grant->set_grant_dummy( $data );

  }
  else {
    // JSON response
    echo '{"result":"failed","reason":"couldnt create record","source":"set_org.php"}';
  }
}
else {
  // JSON response
  echo '{"result":"failed","reason":"postkey incorrect","source":"set_org.php"}';
}

?>
