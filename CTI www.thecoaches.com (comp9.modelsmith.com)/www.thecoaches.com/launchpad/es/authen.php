<?php
// Get user from cookie
// Example: sessionES MAC&2ec8fe8d6f40f619e24128180f2f6963ee88c735&username&thomastest		

// From Perl: 
// <%once>
//   use Apache2::Const qw(:common);
//   use Digest::SHA1;
//   use CTI::Secret;
// </%once>
// <%init>
//  my %c = eval{ Apache2::Cookie->fetch };
//  my ($username,$MAC);
//  my %values;
//  if(exists $c{sessionES}){
//   %values   = $c{sessionES}->value;
//   $username = lc $values{username}; # lower case so that it matches database
//   $MAC      = $values{MAC};
//  }
//  $m->redirect('launchpadES_login.html')
//   unless $MAC eq Digest::SHA1::sha1_hex( $username, Secret::value() );
//  $m->print($username);
// </%init>

$secret   = '002-8445364-4399527eedcvFrTgbNHg';

$redirect = 'http://www.thecoaches.com/docs/leadership/launchpad/launchpadES_login.html';

  // Get the cookie
$sessionES = $_COOKIE['sessionES'];
if($sessionES == ''){
  // If no cookie, redirect to login
  header("Location: $redirect");
  die();
}

$values = explode('&',$sessionES);


  // Get the username
$username = $values[3];

  // Get the MAC
$MAC0 = $values[1];

  // Calculate the SHA1 digest. If not good, then redirect to login
$MAC = sha1( $username.$secret );

if( $MAC != $MAC0 ){
  header("Location: $redirect");
  die();
}

//connection to the database
$dbuser = "cticoaches";
$password = "";
$hostname = "localhost"; 
