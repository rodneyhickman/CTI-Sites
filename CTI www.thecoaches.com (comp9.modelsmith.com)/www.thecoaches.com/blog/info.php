<?php phpinfo();?>

<?php
$to      = 'parivallal.d@madronesoft.com';
$subject = 'Cron From Godaddy';
$message = 'hello world!, welcome come next';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>