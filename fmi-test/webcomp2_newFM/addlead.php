<html>
<body>
<p>Add Lead</p>

<?php
require_once ('FileMaker.php');
require_once ('Student.php');

$fm = new FileMaker(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);


if($_GET['postkey'] == 'xcsd34'){

  $values['First_Name']    = @$_GET['first'];
  $values['Last_Name']     = @$_GET['last'];
  $values['Lead_Source']   = @$_GET['source'];
  $values['import_source'] = 'Web';
  $values['Email']         = @$_GET['email'];
  $values['Address']       = @$_GET['address1'];
  $values['Address2']      = @$_GET['address2'];
  $values['City']          = @$_GET['city'];
  $values['State']         = @$_GET['state'];
  $values['Zip']           = @$_GET['zip'];
  //$values['Home_Phone']    = @$_GET['phone'] . ' ' . @$_GET['office'];
  $values['Cell_Phone']    = @$_GET['cell'].' '.@$_GET['phone'].' '.@$_GET['office'];
  $values['Work_Phone']    = @$_GET['work'];

  // see /contact/schedule-a-call/index.html
  $values['Time_Zone']     = @$_GET['00N40000001OeVs'];
  $values['Best_Time']     = @$_GET['00N40000001OeVx'];
  $values['Message']       = @$_GET['00N40000001OeVt'];

  // Usage: $fm->createRecord('LAYOUT',$values);

  $rec =& $fm->createRecord('Web Lead Import', $values);  // LAYOUT
  $result = $rec->commit(); 


}


?>

<?php if(FileMaker::isError($result)): ?>
<pre>
<?php echo $result->getMessage() ?>
</pre>
<?php endif ?>

</body>
</html>
