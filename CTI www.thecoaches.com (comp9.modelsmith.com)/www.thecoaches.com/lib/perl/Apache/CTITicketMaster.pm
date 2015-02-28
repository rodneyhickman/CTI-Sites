package Apache::CTITicketMaster;

use strict;
use Apache::Constants qw(:common);
use Apache::CTITicketTool ();
use CGI '-autoload';

sub start_html {
  # CTI specific header
  my $param = shift;
  my $title = 'CTI';
  if(ref $param eq 'HASH'){
    $title = $param->{title} || 'CTI';
  }
  return "<html><head><title>$title</title></head><body>";
}

sub end_html {
  # CTI specific footer
  return "</body></html>";
}

# This is the log-in screen that provides authentication cookies.
# There should already be a cookie named "request_uri" that tells
# the login screen where the original request came from.
sub handler {
    my $r = shift;
    my($user, $pass, $pass2) = map { param($_) } qw(user password passwd2);
    my $is_registered = param('is_registered');
    my $squestion     = param('squestion');
    my $sanswer       = param('sanswer');
    my $request_uri   = param('request_uri') || 
	($r->prev ? $r->prev->uri : cookie('request_uri'));

    unless ($request_uri) {
	no_cookie_error();
	return OK;
    }


    my $ticketTool = Apache::CTITicketTool->new($r);
    my($result, $msg);
    # if $pass eq $pass2, add to database
    if($is_registered eq 'no'){
      make_reg_screen($user,'',$request_uri);
      return OK;
    }


    if($pass ne '' and $pass2 ne ''){
      if($pass ne $pass2){
	make_reg_screen($user,'Password mismatch - try again',$request_uri);
	return OK;
      } else {
	($result, $msg) = $ticketTool->add_user($user,$pass,$squestion,$sanswer);
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
    } elsif ($user and $pass) {
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

sub make_reg_screen {
    my($user, $msg, $request_uri) = @_;
    print header(),
    start_html(-title => 'Log In', -bgcolor => 'white');
    print start_form(-action => script_name()),
      p( "New user: $user" );
    print h2(font({color => 'red'}, $msg)) if $msg;
    print
      p( b('Please enter a password: '),password_field(-name => 'password'),
	 br(),
	 b('Please re-enter the password: '),password_field(-name => 'passwd2'),
       ),
      hidden(-name => 'request_uri', -value => $request_uri),
      hidden(-name => 'user', -value => $user),
      p( b('Please choose a security question.'), br(), 'If you forget your password, you will need to answer this question to retrieve your password.', br() );
    print <<EOT ;
<select name="squestion" tabindex="4" size="1">
<option value="" selected>Please Choose One
<option value="What city was my place of birth?">What city was my place of birth?
<option value="What kind of pet do I have and what is the pet's name?">What kind of pet do I have and what is the pet's name?
<option value="What high school did I attend?">What high school did I attend?
</select>
EOT
      print p( b('What is your security answer? '),textfield(-name => 'sanswer'),),
      submit('Log In'), p(),
      end_form(),
      end_html();
}

sub make_login_screen {
    my($msg, $request_uri) = @_;
    print header(),
    start_html(-title => 'Log In', -bgcolor => 'white'),
    h1('Please Log In');
    print  h2(font({color => 'red'}, "Error: $msg")) if $msg;
    print start_form(-action => script_name()),
      p( b('What is your email address?'),
	 br(),
	 'My email address is ',
	 textfield(-name => 'user')
       ),
      p( b('Do you have a CTIcoaches.com password?'),
	 br(),
	 radio_group(-name      =>'is_registered',
		     -values    =>['no','yes'],
		     -default   =>'no',
		     -linebreak =>'true',
		     -labels    =>{ no  => 'No, I\'m a new user',
                                    yes => 'Yes, and my password is '}),
         password_field(-name => 'password')
       ),
      hidden(-name => 'request_uri', -value => $request_uri),
	submit('Log In'), p(),
	  end_form(),
	    em('Note: '),
	      "You must set your browser to accept cookies in order for login to succeed.",
	      "You will be asked to log in again after some period of time has elapsed.",
    end_html();
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
