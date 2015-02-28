package Apache::CTITicketTool;

use strict;
use Tie::DBI ();
use Apache::Cookie ();
use CGI::Cookie ();
use MD5 ();
#use LWP::Simple ();
use Apache::File ();
use Apache::URI ();
use Data::Dumper qw(Dumper);
use Email::Valid;

#my $ServerName = Apache->server->server_hostname;
my $ServerName = 'www.thecoaches.com';

my %DEFAULTS = (
   'TicketDatabase' => "mysql:CTIDATABASE",
   'TicketTable'    => 'user_info:user_name:passwd',
   'TicketExpires'  => 60,
   'TicketSecret'   => '/www/thecoaches/lib/secure/key.txt',
   'TicketDomain'   => '.thecoaches.com',
);


my %CACHE;  # cache objects by their parameters to minimize time-consuming operations

# Set up default parameters by passing in a request object
sub new {
    my($class, $r) = @_;
    my %self = ();
    foreach (keys %DEFAULTS) {
	$self{$_} = $r->dir_config($_) || $DEFAULTS{$_};
    }

    # post-process TicketDatabase and TicketDomain
    # ($self{TicketDomain} = $r->server->server_hostname) =~ s/^[^.]+// 
    #	unless $self{TicketDomain};

    # try to return from cache
    my $id = join '', sort values %self;
    return $CACHE{$id} if $CACHE{$id};

    # otherwise create new object
    return $CACHE{$id} = bless \%self, $class;
}

# TicketTool::authenticate()
# Call as:
# ($result,$explanation) = $ticketTool->authenticate($user,$passwd)
sub authenticate {
    my($self, $user, $passwd) = @_;
    my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

#return(undef,"$user $passwd ".Dumper $self);
    tie my %DB, 'Tie::DBI', {
       'db'    => $self->{TicketDatabase},
        #'db'    => "CSV:f_dir=/Users/thomas/CTI/web_assets/cticoaches/secure/db;csv_eol=\n;",
        #'db'    => "CSV:f_dir=/www/cticoaches/secure/db;csv_eol=\n;",
	'table' => $table,
        'key'   => $userfield,
	'user' => 'cticoaches',
        'password' => '',
    } or return (undef, "couldn't open database");
    return (undef, "email address not found - please register")
	unless $DB{$user};
    my $user_ref = $DB{$user};
 #   return (undef, Dumper $user_ref)
#	unless ref($user_ref) eq 'REF';

    my $saved_passwd = $user_ref->{$passwdfield};
    return (undef, "Password incorrect or missing - please try again")
	unless $saved_passwd eq crypt($passwd, $saved_passwd);

    return (1, '');
}

# TicketTool::is_registered()
# Call as:
# ($result,$explanation) = $ticketTool->is_registered($user)
sub is_registered {
    my($self, $user) = @_;
    my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

#return(undef,"$user ".Dumper $self);
    tie my %DB, 'Tie::DBI', {
       'db'    => $self->{TicketDatabase},
        #'db'    => "CSV:f_dir=/Users/thomas/CTI/web_assets/cticoaches/secure/db;csv_eol=\n;",
        #'db'    => "CSV:f_dir=/www/cticoaches/secure/db;csv_eol=\n;",
	'table' => $table,
        'key'   => $userfield,
	'user' => 'cticoaches',
        'password' => '',
    } or return (undef, "couldn't open database");
    return (undef, "email address not found")
	unless exists $DB{$user};
    return 1;
}


# TicketTool::add_user()
# Call as:
# ($result,$explanation) = $ticketTool->add_user($user,$passwd)
sub add_user {
    my($self, $user, $passwd) = @_;
    my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

    tie my %DB, 'Tie::DBI', {
	'db'    => $self->{TicketDatabase},
        #'db'    => "CSV:f_dir=/www/cticoaches/secure/db;csv_eol=\n;",
	'table' => $table, 
	'key' => $userfield,
	'user' => 'cticoaches',
        'password' => '',
        CLOBBER => 1 ,
    } or return (undef, "couldn't open database");
#return(undef,"$user ".Dumper $DB{$user});
    # return if already in database
    return (undef, "This email address is already registered")
      if $DB{$user};
    # validate email address
    return (undef, "Email address is not valid - try again")
      unless Email::Valid->rfc822($user);
    # save password
    my $salt = '$!$AsDfGhUz';
    $DB{$user} = {user_name => $user,
		  passwd    => crypt($passwd,$salt),
                  id        => 'nil',
		  };
    return (1, '');
}

# TicketTool::fetch_secret()
# Call as:
# $ticketTool->fetch_secret();
sub fetch_secret {
    my $self = shift;
    unless ($self->{SECRET_KEY}) {
#	if ($self->{TicketSecret} =~ /^http:/) {
#	    $self->{SECRET_KEY} = LWP::Simple::get($self->{TicketSecret});
#	} else {
	    my $fh = Apache::File->new($self->{TicketSecret}) || return;
	    $self->{SECRET_KEY} = <$fh>;
#	}
    }
    $self->{SECRET_KEY};
}

# invalidate the cached secret
sub invalidate_secret { undef shift->{SECRET_KEY}; }

# TicketTool::make_ticket()
# Call as:
# $cookie = $ticketTool->make_ticket($r);
#
sub make_ticket {
    my($self, $r, $user_name) = @_;
#    my $ip_address = $r->connection->remote_ip;
    my $expires = $self->{TicketExpires};
    my $now = time;
    my $secret = $self->fetch_secret() or return undef;


#    my $hash = MD5->hexhash($secret .
#                 MD5->hexhash(join ':', $secret, $ip_address, $now,
#			       $expires, $user_name)
#               );

    my $hash = MD5->hexhash($secret .
                 MD5->hexhash(join ':', $secret, $now,
			       $expires, $user_name)
               );

    return CGI::Cookie->new(-name => 'Ticket',
			    -path => '/',
			    -domain => $self->{TicketDomain},
			    -value => {
#				'ip' => $ip_address,
				'time' => $now,
				'user' => $user_name,
				'hash' => $hash,
				'expires' => $expires,
			    });
}

# TicketTool::make_ticket_a()
# Call as:
# $cookie = $ticketTool->make_ticket_a($r);
#
sub make_ticket_a {
    my($self, $r, $user_name) = @_;
#    my $ip_address = $r->connection->remote_ip;
    my $expires = $self->{TicketExpires};
    my $now = time;
    my $secret = $self->fetch_secret() or return undef;

#    my $hash = MD5->hexhash($secret .
#                 MD5->hexhash(join ':', $secret, $ip_address, $now,
#			       $expires, $user_name)
#               );

    my $hash = MD5->hexhash($secret .
                 MD5->hexhash(join ':', $secret, $now,
			       $expires, $user_name)
               );

    return Apache::Cookie->new($r,
			       -name => 'Ticket',
			       -path => '/',
			       -domain => $self->{TicketDomain},
			       -value => {
#				   'ip' => $ip_address,
				   'time' => $now,
				   'user' => $user_name,
				   'hash' => $hash,
				   'expires' => $expires,

			       });
}

# TicketTool::make_reset_ticket()
# Call as:
# $cookie = $ticketTool->make_reset_ticket($r);
#
sub make_reset_ticket {
    my($self, $r, $user_name) = @_;
#    my $ip_address = $r->connection->remote_ip;
    my $now = time;
    my $secret = $self->fetch_secret() or return undef;

#    my $hash = MD5->hexhash($secret .
#                 MD5->hexhash(join ':', $secret, $ip_address, $now,
#			       $user_name)
#               );

    my $hash = MD5->hexhash($secret .
                 MD5->hexhash(join ':', $secret, $now,
			       $user_name)
               );

    return Apache::Cookie->new($r,
			       -name => 'Reset',
			       -path => '/',
			       -domain => $self->{TicketDomain},
			       -expires => '+2d',
			       -value => {
#				   'ip' => $ip_address,
				   'time' => $now,
				   'user' => $user_name,
				   'hash' => $hash,
			       });
}


# TicketTool::validate_ticket_and_key()
# Call as:
# $cookie = $ticketTool->validate_ticket_and_key($key);
#
sub validate_ticket_and_key {
    my($self, $r, $key) = @_;
    my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

    tie my %DB, 'Tie::DBI', {
      'db'    => $self->{TicketDatabase},
      'table' => $table,
      'key'   => $userfield,
	'user' => 'cticoaches',
        'password' => '',
    } or return (0, "couldn't open database");


    my %cookies = CGI::Cookie->parse($r->header_in('Cookie'));
    return (0, 'user has no cookies') unless %cookies;
    return (0, 'user has no ticket') unless $cookies{'Reset'};
    my %ticket = $cookies{'Reset'}->value;
    return (0, 'malformed ticket')
	unless $ticket{'hash'} && $ticket{'user'} && 
	    $ticket{'time'};
#    return (0, 'IP address mismatch in ticket')
#	unless $ticket{'ip'} eq $r->connection->remote_ip;
    my $secret;
    return (0, "can't retrieve secret") 
	unless $secret = $self->fetch_secret;
#    my $newhash = MD5->hexhash($secret .
#                     MD5->hexhash(join ':', $secret,
#			       @ticket{qw(ip time user)})
#           );
    my $newhash = MD5->hexhash($secret .
                     MD5->hexhash(join ':', $secret,
			       @ticket{qw(time user)})
           );
    unless ($newhash eq $ticket{'hash'}) {
	$self->invalidate_secret;  #maybe it's changed?
	return (0, 'ticket mismatch');
    }

    my $user = $ticket{'user'};

    return (0, 'email address not found in database')
      unless exists $DB{$user};

    return(0, "stored key didn't match for $user, actual key is $DB{$user}->{squestion}")
      unless $key eq $DB{$user}->{squestion};

    return ($user, 'ok');
  
}


# TicketTool::change_password()
# Call as:
# $cookie = $ticketTool->change_password($user,$passwd);
#
sub change_password {
    my($self, $user, $passwd) = @_;
    my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

    tie my %DB, 'Tie::DBI', {
	'db'    => $self->{TicketDatabase},
	'table' => $table,
	'key'   => $userfield,
	'user' => 'cticoaches',
        'password' => '',
        CLOBBER => 2,
    } or return (undef, "couldn't open database");

    # return if already in database
    return (undef, "This email address is not in database")
      unless exists $DB{$user};

    my $id          = $DB{$user}->{id};
    my $user_serial = $DB{$user}->{user_serial};

    delete $DB{$user};

    # save new password
    my $salt = '$!$AsDfGhUz';
    $DB{$user} = {user_name => $user,
		  passwd    => crypt($passwd,$salt),
                  id        => $id,
		  squestion => '',
                  user_serial => $user_serial,
		  };
    return (1, '');


}


# TicketTool::make_key()
# Call as:
# $cookie = $ticketTool->make_key($email);
#
sub make_key {
  my($self, $user) = @_;
  my($table, $userfield, $passwdfield) = split ':', $self->{TicketTable};

  tie my %DB, 'Tie::DBI', {
     'db'    => $self->{TicketDatabase},
     'table' => $table,
     'key'   => $userfield,
	'user' => 'cticoaches',
        'password' => '',
     CLOBBER => 2,
  } or return (undef, "couldn't open database");

  return (undef, "email address not found")
    unless exists $DB{$user};

  my $text = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ23456789";
  my $length = int(rand() * 2) + 14;

  my $x = 0;
  my $key = "";
  while ($x<$length) {
    my $ranNo = int(rand() * length($text));
    my $a = substr($text, $ranNo, 1);
    $key .= $a; $x++;
  }

  my $passwd = $DB{$user}->{passwd};
  my $id     = $DB{$user}->{id};

  delete $DB{$user};

  # note: squestion and sanswer fields are not longer used, so let's use it for the key
  $DB{$user} = { user_name => $user,
	         passwd    => $passwd,
	         id        => $id,
	         squestion => $key,
	       };

  return $key;

}

# TicketTool::verify_ticket()
# Call as:
# ($result,$msg) = $ticketTool->verify_ticket($r)
sub verify_ticket {
    my($self, $r) = @_;
#return(0,Dumper $self);

    my %cookies = CGI::Cookie->parse($r->header_in('Cookie'));
    return (0, 'user has no cookies') unless %cookies;
    return (0, 'user has no ticket') unless $cookies{'Ticket'};
    my %ticket = $cookies{'Ticket'}->value;
    return (0, 'malformed ticket')
	unless $ticket{'hash'} && $ticket{'user'} && 
	    $ticket{'time'} && $ticket{'expires'};
#    return (0, 'IP address mismatch in ticket')
#	unless $ticket{'ip'} eq $r->connection->remote_ip;
    return (0, 'ticket has expired')
	unless (time - $ticket{'time'})/60 < $ticket{'expires'};
    my $secret;
    return (0, "can't retrieve secret") 
	unless $secret = $self->fetch_secret;
#    my $newhash = MD5->hexhash($secret .
#                     MD5->hexhash(join ':', $secret,
#			       @ticket{qw(ip time expires user)})
#           );
    my $newhash = MD5->hexhash($secret .
                     MD5->hexhash(join ':', $secret,
			       @ticket{qw(time expires user)})
           );
    unless ($newhash eq $ticket{'hash'}) {
	$self->invalidate_secret;  #maybe it's changed?
	return (0, 'ticket mismatch');
    }
    $r->connection->user($ticket{'user'});
    return (1, 'ok');
}

# Call as:
# $cookie = $ticketTool->make_return_address()
sub make_return_address {
    my($self, $r) = @_;
    my $uri = Apache::URI->parse($r, $r->uri);
    $uri->scheme("http");
    $uri->hostname($r->get_server_name);
    $uri->port($r->get_server_port);
    $uri->query(scalar $r->args);

    return CGI::Cookie->new(-name => 'request_uri',
			    -value => $uri->unparse,
			    -domain => $self->{TicketDomain},
			    -path => '/');
}

1;
__END__
