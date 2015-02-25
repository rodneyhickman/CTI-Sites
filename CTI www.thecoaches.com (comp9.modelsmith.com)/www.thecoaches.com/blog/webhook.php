<?php
$apikey="8d7e95e7827bba725bff4a01d84b5a38-us1";
$postkey="fjgh15t";
$webhookkey="84b5a38";

  //print_r( $_POST );

 //connection to the database
 $dbhandle = mysql_connect('localhost', 'cticoaches', '') 
  or die("failed - Unable to connect to MySQL");

 //select a database to work with 
 $selected = mysql_select_db("CTIDATABASE",$dbhandle) 
  or die("failed - Could not select database");

$dummy = <<<EOT

TO DO: 8/13/2010
    - Create update_subscribe.php locally for testing purposes
    - Copy Student.php locally for testing purposes - write to log file
    - (done) Create webhook_test.php to test this page, esp unsubscribe
    - (done) update the real Student.php
    - implement unsubscribe below


"type": "subscribe", 
  "fired_at": "2009-03-26 21:35:57", 
  "data[id]": "8a25ff1d98", 
  "data[list_id]": "a6b5da1054",
  "data[email]": "api@mailchimp.com", 
  "data[email_type]": "html", 
  "data[merges][EMAIL]": "api@mailchimp.com", 
  "data[merges][FNAME]": "MailChimp", 
  "data[merges][LNAME]": "API", 
  "data[merges][INTERESTS]": "Group1,Group2", 
  "data[ip_opt]": "10.20.10.30", 
  "data[ip_signup]": "10.20.10.30"

"type": "unsubscribe", 
  "fired_at": "2009-03-26 21:40:57", 
  "data[id]": "8a25ff1d98", 
  "data[list_id]": "a6b5da1054",
  "data[email]": "api+unsub@mailchimp.com", 
  "data[email_type]": "html", 
  "data[merges][EMAIL]": "api+unsub@mailchimp.com", 
  "data[merges][FNAME]": "MailChimp", 
  "data[merges][LNAME]": "API", 
  "data[merges][INTERESTS]": "Group1,Group2", 
  "data[ip_opt]": "10.20.10.30"
  "data[campaign_id]": "cb398d21d2"

"type": "upemail", 
  "fired_at": "2009-03-26\ 22:15:09", 
  "data[list_id]": "a6b5da1054",
  "data[new_id]": "51da8c3259", 
  "data[new_email]": "api+new@mailchimp.com", 
  "data[old_email]": "api+old@mailchimp.com"

"type": "cleaned", 
  "fired_at": "2009-03-26 22:01:00", 
  "data[list_id]": "a6b5da1054",
  "data[reason]": "hard",
  "data[email]": "api+cleaned@mailchimp.com"

EOT;

// defaults
$list_id   = '';
$list_name = '???';
$email     = '';
$result    = 'failed';

// Unsubscribe
if($_POST['type']=='unsubscribe' && $_GET['key'] == $webhookkey){
  $data        = $_POST['data'];
  $email       = $data['email'];
  $list_id     = $data['list_id'];
  $fired_at    = $_POST['fired_at'];
  $campaign_id = isset($data['campaign_id']) ? $data['campaign_id'] : ''; 
  $data_id     = isset($data['data_id'])     ? $data['data_id']     : ''; 
  $reason      = isset($data['reason'])      ? $data['reason']      : ''; 

  // can this be cached?
  $lists_json = file_get_contents("http://us1.api.mailchimp.com/1.2/?output=json&method=lists&apikey=$apikey");
  $lists = json_decode($lists_json);
  foreach($lists as $list){
    $array = (array) $list;
    //echo $array['name']."<br/>";
    $list_name = $array['name'];
    if( $list_id == $array['id'] ){
      if(@$_POST['test']){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
      }
      // determine newsletter or marketing
      if( preg_match("/newsletter/i",$list_name) ){
        $unsub_type="newsletter";
      }
      else {
        $unsub_type="marketing";
      }

      
      // unsubscribe this user
      //$result = file_get_contents("http://webcomp.modelsmith.com/fmi-test/webcomp/set_unsubscribe.php?postkey=$postkey&em=$email&unsub_type=$unsub_type");

      
      $db_result = mysql_query("INSERT INTO `unsubscribes` (`fired_at`,`type`,`reason`,`data_id`,`data_email`,`data_campaign_id`,`data_list_id`,`list`,`received_at`) VALUES ('$fired_at','$unsub_type','$reason','$data_id','$email','$campaign_id','$list_id','$list_name',NOW())");
      
    }
  }
}

// Unsubscribe
if($_POST['type']=='cleaned' && $_GET['key'] == $webhookkey){
  $data    = $_POST['data'];
  $email   = $data['email'];
  $fired_at    = $_POST['fired_at'] ?  "'".$_POST['fired_at']."'" : 'NOW()'  ;
  $campaign_id = isset($data['campaign_id']) ? $data['campaign_id'] : ''; 
  $data_id     = isset($data['data_id'])     ? $data['data_id']     : ''; 
  $reason      = isset($data['reason'])      ? $data['reason']      : '';
  $list_id = '';
  $list_name = '';


  $unsub_type="newsletter,marketing";
  //$result = file_get_contents("http://webcomp.modelsmith.com/fmi-test/webcomp/set_unsubscribe.php?postkey=$postkey&em=$email&unsub_type=$unsub_type");
      $db_result = mysql_query("INSERT INTO `unsubscribes` (`fired_at`,`type`,`reason`,`data_id`,`data_email`,`data_campaign_id`,`data_list_id`,`list`,`received_at`) VALUES ($fired_at,'$unsub_type','$reason','$data_id','$email','$campaign_id','$list_id','$list_name',NOW())");


}

if($db_result==1){ $result = 'ok'; }

email_unsub($email,$unsub_type,$list_name,$webhookkey . ' ' . $result . ' ' . print_r($_REQUEST,true));

function email_unsub($email,$unsub_type,$list_name,$result){
  $to = "ping@mac.com";
  $subject  = "Unsubscribe notification";
  $headers  = "From: webmaster@modelsmith.com\r\n";
  //$headers .= "Cc: thomas@techcoachtom.com" . "\r\n";
  //$headers .= "Bcc: beutelevision@gmail.com" . "\r\n";
  // prepare email body text
  $body = "";
  $body .= "$email has unsubscribed from $unsub_type list: $list_name\n";
  $body .= "Result was $result\n";
  $sent = mail($to, $subject, $body, $headers) ;
}

if(@$_POST['test']){
  echo "<p>Done. List ID: $list_id Email: $email</p>";
}


echo $result;
?>
