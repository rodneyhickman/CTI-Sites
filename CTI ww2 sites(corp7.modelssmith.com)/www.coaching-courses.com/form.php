<?php

$params  = $_POST;

$referer = $_SERVER['HTTP_REFERER'];

// referer must be a CTI page
if( ! preg_match('/(thecoaches|coaching-courses)/',$referer) ){
  redirect('error.html');
}

$redirect = $_POST['redirect'] ? $_POST['redirect'] : 'contact/conference/thank-you.html';

// make sure external redirects don't go elsewhere
if( preg_match('/:\/\//',$redirect) && ! preg_match('/(thecoaches|amerisites|cartserver|coaching-courses)/',$redirect) ){
  redirect('error.html');
}

$recipient  = $_POST['recipient'];
$recipients = explode(',', $recipient);
$recipient_domains = array('thecoaches.com','cticoach.com','coactivespace.com','modelsmith.com','coaching-courses.com');

// make sure recipients are in recipient domains
foreach($recipients as $r){
  $matched = 0;
  foreach($recipient_domains as $d){
    if(preg_match("/$d/",$r) ){
      $matched = 1;
    }
  }
  if(! $matched){
    redirect('error.html');
  }
}

// if fmlead == 1, then create a new record in FileMaker 10
// if($args->{fmlead} == 1){

//   # capture values for creating a record in FileMaker
//   my $parameters = 'postkey=xcsd34'; # key to allow FM record creation
//   foreach my $key (keys %$args){
//     foreach my $newkey (@list){
//      if( $newkey !~ m/^[123]$/ and $key =~ m/ $newkey /xmsi ){
//         my $value = $args->{$key};
//         # remove any non-alphanumeric characters
//         $value =~ s/[^A-Za-z0-9-_ \'\,\@\.]+//gxms;
//         # convert spaces to %20
//         $value =~ s/[ ]/%20/gxms;
//         $parameters .= '&' . $newkey . '=' .$value;
//         last;
//       } 
//     }
//   }

//   # create the record
//   $url = "http://webcomp.modelsmith.com/fmi-test/webcomp/addlead.php?$parameters";
//   $get_result = get($url);
// }

// no we know that everything is ok, so let's sort the parameters

// get all parameters and loop through them
$params['redirect'] = null;
$params['recipient'] = null;

function sort_by_name($a, $b) {
  $list = array('full'=>1, 'first'=>2, 'last'=>3, 'email'=>4, 'address1'=>5, 'address2'=>6, 'address'=>7, 'city'=>8, 'town'=>9, 'state'=>10, 'region'=>11, 'province'=>12, 'zip'=>13, 'postal'=>14, 'country'=>15, 'home'=>16, 'work'=>17, 'office'=>18, 'cell'=>19, 'mobile'=>20, 'phone'=>21, 'web'=>22, 'site'=>23, 'refer'=>24, 'source'=>25, 'coupon'=>26, '00N40000001OeVs'=>27, '00N40000001OeVx'=>28, '00N40000001OeVt'=>29, '1'=>30, '2'=>31, '3'=>32, 'op'=>33, 'agree'=>34, 'message'=>35, 'time'=>36);
  

}

uasort($params,'sort_by_name');

// all done, now redirect
redirect($redirect);

function redirect($loc) {
 header( "Location: $loc" ) ;
 exit(0);
}

?>
NULL
