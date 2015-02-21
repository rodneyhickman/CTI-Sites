<?php
require_once ('OrgGrants.php');

// test this thusly:
// curl -X POST -d @/Users/thomas/Desktop/post_data.txt http://webcomp.modelsmith.com/fmi-test/webcomp/set_org.php

if($_POST['postkey'] == 'fjgh15t'){
  
  $org_grant = new OrgGrant();
  //$org_grant->get_record_by_id( $_POST['fmid'] );  
  $org_grant->get_record_by_id_dummy( $_POST['fmid'] );

  if( isset($org_grant->record) ){

    $data['first_name']   = $_POST['first_name'];
    $data['last_name']    = $_POST['last_name'];
    $data['organization'] = $_POST['organization'];
    $data['grant_type']   = $_POST['grant_type'];
    $data['org_id']       = $_POST['org_id'];
    $data['unique_id']    = $_POST['unique_id'];
    $data['address1']     = $_POST['address1'];
    $data['address2']     = $_POST['address2'];
    $data['population']   = $_POST['population'];
    $data['city']         = $_POST['city'];
    $data['state'] = $_POST['state'];
    $data['zip'] = $_POST['zip'];
    $data['country'] = $_POST['country'];
    $data['location'] = $_POST['location'];
    $data['phone'] = $_POST['phone'];
    $data['phone_cell'] = $_POST['phone_cell'];
    $data['fax'] = $_POST['fax'];
    $data['url'] = $_POST['url'];
    $data['email'] = $_POST['email'];
    $data['creation_date'] = $_POST['creation_date'];
    $data['proof_of_501c3_rcvd'] = $_POST['proof_of_501c3_rcvd'];

    //$org_grant->set_org( $data );
    $org_grant->set_org_dummy( $data );

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
