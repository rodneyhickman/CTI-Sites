<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);

if($_REQUEST['postkey'] == 'fjgh15t'){
  
  $data = $_REQUEST["data"];

  try {
    $decoded_data = json_decode ( $data, true );
    
    // JSON format:
    // { "subscribers" : 
    //   [
    //     { "em" : "foo@example.com,
    //       "unsub_type" : "marketing,newsletter"
    //     },
    //     { "em" : "bar@example.com,
    //       "unsub_type" : "marketing,newsletter"
    //     }
    //   ] 
    // }

    // curl test line:
    // curl -d 'data={"subscribers":[{"em":"ping@me.com","unsub_type":"newsletter"}]}' "webcomp.modelsmith.com/fmi-test/webcomp/set_unsubscribe_bulk.php?postkey=fjgh15t"

    $subscribers = $decoded_data["subscribers"];
    $result      = '';

    foreach($subscribers as $subscriber){
      $student = new Student();
      $student->get_record( $fm, $subscriber['em'] );
      
      if(isset($student->record)){
        if( preg_match("/marketing/",$subscriber['unsub_type']) ){
          $result .= $student->unsubscribe( "marketing" );
        }
        if( preg_match("/newsletter/",$subscriber['unsub_type']) ){
          $result .= $student->unsubscribe( "newsletter" );
        }
      }
    }
    // print_r( $data );
    //echo "ok ($result)";
    echo "ok";
  } 
  
  catch (Exception $e){
    echo "fail - $e";
  }


}

?>
