<?php

$dbh = mysql_connect('localhost', 'ctivisuser', '5tGFr4')
    or die("Unable to connect to MySQL");

 
$selected = mysql_select_db("ctivision",$dbh) 
  or die("Could not select examples");


if(isset($_POST['how-does-coative-way-generate']) && isset($_POST['what-is-the-new-world']) && isset($_POST['submit-btn'])){

// generate new anonymous profile
  $query = sprintf("INSERT INTO profile (email,name, created_at) values ('%s','%s',NOW())",
                  mysql_real_escape_string('anon@example.com'),
                   mysql_real_escape_string('Anonymous at '.Date('Y-m-d H:i:s')));
  mysql_query($query);
  $profile_id = mysql_insert_id();
  
  $how            = $_POST['how-does-coative-way-generate'];
  $what           = $_POST['what-is-the-new-world'];
  
  $query = sprintf("INSERT INTO form_answer (profile_id,question_name,question_answer,created_at) values ('%s','%s','%s',NOW())",
                   mysql_real_escape_string($profile_id),
                   mysql_real_escape_string('How does Co-active Way Generate'),
                   mysql_real_escape_string($how) );
  mysql_query($query);
 
  $query = sprintf("INSERT INTO form_answer (profile_id,question_name,question_answer,created_at) values ('%s','%s','%s',NOW())",
                   mysql_real_escape_string($profile_id),
                   mysql_real_escape_string('What is the new world'),
                   mysql_real_escape_string($what) );
  mysql_query($query);
}

$redirect = "/vision/fable#&panel1-5";

header('Location: '.$redirect);


 
?>