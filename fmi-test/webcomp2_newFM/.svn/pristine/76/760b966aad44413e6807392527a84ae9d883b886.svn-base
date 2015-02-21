<html>
<body>
<p>FileMaker Test Page</p>

<?php
require_once ('FileMaker.php');


$fm = new FileMaker(); 
$databases = $fm->listDatabases(); 

// changed 3/10/12

$fm->setProperty('database', Student::DATABASE); 
$fm->setProperty('username', Student::USERNAME); 
$fm->setProperty('password', Student::PASSWORD);



$values['First_Name']='PHP';
$values['Last_Name']='Test';
$values['Referred_By']='web form';
$values['Address']='1491 31st Avenue';
$values['Address_2']='Suite 34';
$values['City']='San Francisco';
$values['State']='CA';
$values['Zip']='94122';
$values['Home_Phone']='415-681-9675';
$values['Cell_Phone']='415-254-7563';
$values['Email']='ping@me.com';



$rec = $fm->createRecord('CONTACT', $values); 
$result = $rec->commit(); 

?>

<pre>
Databases:
<?php print_r($databases) ?>

PHP result:
<?php echo $result ?>
</pre>

</body>
</html>
