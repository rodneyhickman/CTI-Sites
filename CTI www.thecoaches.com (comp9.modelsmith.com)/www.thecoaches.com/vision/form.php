<?php

$dbh = mysql_connect('localhost', 'ctivisuser', '5tGFr4')
    or die("Unable to connect to MySQL");

 
$selected = mysql_select_db("ctivision",$dbh) 
  or die("Could not select examples");


if(isset($_POST['submit-entry']) && isset($_POST['your-email']) ){

  $name            = $_POST['your-name'];
  $email           = $_POST['your-email'];

  update_record( $name, $email );

}

  $redirect = "index.html";

if(isset($_POST['redirect'])){
  $redirect = $_POST['redirect'];
}

header('Location: '.$redirect);


function update_record( $name = 'unknown', $email = '' ){
  if($email != ''){
    $query = sprintf("SELECT id,email FROM profile WHERE email='%s' LIMIT 1",mysql_real_escape_string($email) );
    $result = mysql_query($query);
    if (!$result) {
      die("Invalid query: " . mysql_error());
    }
    $row = mysql_fetch_assoc($result);

    // update or insert email, name
    if($row['id'] > 0){
      $query = sprintf("UPDATE profile SET name='%s', created_at=NOW()",mysql_real_escape_string($name) );
      mysql_query($query);
      $profile_id = $row['id'];
    }
    else {
      $query = sprintf("INSERT INTO profile (email,name, created_at) values ('%s','%s',NOW())",
                       mysql_real_escape_string($email),
                       mysql_real_escape_string($name));
      mysql_query($query);
      $profile_id = mysql_insert_id();
    }

    // insert answer
    foreach($_POST as $key => $value){
      if($key != 'your-name' && $key != 'your-email'){
        $query = sprintf("INSERT INTO form_answer (profile_id,question_name,question_answer,created_at) values ('%s','%s','%s',NOW())",
                         mysql_real_escape_string($profile_id),
                         mysql_real_escape_string($key),
                         mysql_real_escape_string($value) );
         mysql_query($query);
      }
    }
  }
}