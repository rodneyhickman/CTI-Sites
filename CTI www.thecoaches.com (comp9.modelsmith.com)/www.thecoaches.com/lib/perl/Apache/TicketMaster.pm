package Apache::TicketMaster;

use strict;
use Apache::Constants qw(:common);
use Apache::TicketTool ();
use CGI '-autoload';

# This is the log-in screen that provides authentication cookies.
# There should already be a cookie named "request_uri" that tells
# the login screen where the original request came from.
sub handler {
    my $r = shift;
    my($user, $pass) = map { param($_) } qw(user password);
    my $request_uri = param('request_uri') || 
	($r->prev ? $r->prev->uri : cookie('request_uri'));

    unless ($request_uri) {
	no_cookie_error();
	return OK;
    }

    my $ticketTool = Apache::TicketTool->new($r);
    my($result, $msg);
    if ($user and $pass) {
	($result, $msg) = $ticketTool->authenticate($user, $pass);
	if ($result) {
	    my $ticket = $ticketTool->make_ticket($r, $user);
	    unless ($ticket) {
		$r->log_error("Couldn't make ticket -- missing secret?");
		return SERVER_ERROR;
	    }
	    go_to_uri($r, $request_uri, $ticket);
	    return OK;
	}
    }
    make_login_screen($msg, $request_uri);
    return OK;
}

sub go_to_uri {
    my($r, $requested_uri, $ticket) = @_;
    print header(-refresh => "1; URL=$requested_uri", -cookie => $ticket),
    start_html(-title => 'Successfully Authenticated', -bgcolor => 'white'),
    h1('Congratulations'),
    h2('You have successfully authenticated'),
    h3("Please stand by..."),
    end_html();
}

sub make_login_screen {
    my($msg, $request_uri) = @_;
    print header(),
    start_html(-title => 'Log In', -bgcolor => 'white'),
    h1('Please Log In');
    print  h2(font({color => 'red'}, "Error: $msg")) if $msg;
    print start_form(-action => script_name()),
    table(
	  Tr(td(['Name', textfield(-name => 'user')])),
	  Tr(td(['Password', password_field(-name => 'password')]))
	  ),
	      hidden(-name => 'request_uri', -value => $request_uri),
	      submit('Log In'), p(),
	      end_form(),
	      em('Note: '),
	      "You must set your browser to accept cookies in order for login to succeed.",
	      "You will be asked to log in again after some period of time has elapsed.";
}

# called when the user tries to log in without a cookie
sub no_cookie_error {
    print header(),
    start_html(-title => 'Unable to Log In', -bgcolor => 'white'),
    h1('Unable to Log In'),
    "This site uses cookies for its own security.  Your browser must be capable ", 
    "of processing cookies ", em('and'), " cookies must be activated. ",
    "Please set your browser to accept cookies, then press the ",
    strong('reload'), " button.", hr();
}

1;
__END__
