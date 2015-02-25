#!/usr/local/bin/perl

use CGI;
$query = new CGI;
$email = $query->param('email');
$list = "ctielist";
$listdom = "thecoaches.com";
$redirect = "http://www.thecoaches.com";
@email = split('@',$email);

if ( ($email ne "") && (index($email,'@') > -1) ) {
`/var/qmail/bin/qmail-inject $list-subscribe-@email[0]=@email[1]\@$listdom < /dev/null`;
}
print $query->redirect("$redirect");

exit (0);
