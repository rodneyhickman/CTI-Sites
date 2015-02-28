package Apache::TicketTool;

use strict;
use Tie::DBI ();
use CGI::Cookie ();
use MD5 ();
use LWP::Simple ();
use Apache::File ();
use Apache::URI ();
use Data::Dumper qw(Dumper);

my $ServerName = Apache->server->server_hostname;

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
    ($self{TicketDomain} = $r->server->server_hostname) =~ s/^[^.]+// 
	unless $self{TicketDomain};

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

    my $lcuser = $user;

    tie my %DB, 'Tie::DBI', {
	#'db'    => $self->{TicketDatabase},
        'db'    => "mysql:CTIDATABASE",
	'table' => $table, 'key' => $userfield,
	'user' => 'cticoaches',
        'password' => '',
    } or return (undef, "couldn't open database");
#return(undef,"$user ".Dumper $DB{$user});
    return (undef, "invalid account")
	unless $DB{$lcuser};
    my $user_ref = $DB{$lcuser};
 #   return (undef, Dumper $user_ref)
#	unless ref($user_ref) eq 'REF';
    
    my $saved_passwd = $user_ref->{$passwdfield};
    return (undef, "password mismatch")
	unless $saved_passwd eq crypt($passwd, $saved_passwd);
    
    return (1, '');
}

# TicketTool::fetch_secret()
# Call as:
# $ticketTool->fetch_secret();
sub fetch_secret {
    my $self = shift;
    unless ($self->{SECRET_KEY}) {
	if ($self->{TicketSecret} =~ /^http:/) {
	    $self->{SECRET_KEY} = LWP::Simple::get($self->{TicketSecret});
	} else {
	    my $fh = Apache::File->new($self->{TicketSecret}) || return;
	    $self->{SECRET_KEY} = <$fh>;
	}
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
    my $ip_address = $r->connection->remote_ip;
    my $expires = $self->{TicketExpires};
    my $now = time;
    my $secret = $self->fetch_secret() or return undef;
    my $hash = MD5->hexhash($secret .
                 MD5->hexhash(join ':', $secret, $ip_address, $now,
			       $expires, $user_name)
               );
    return CGI::Cookie->new(-name => 'Ticket',
			    -path => '/',
			    -domain => $self->{TicketDomain},
			    -value => {
				'ip' => $ip_address,
				'time' => $now,
				'user' => $user_name,
				'hash' => $hash,
				'expires' => $expires,
			    });
}


# TicketTool::verify_ticket()
# Call as:
# ($result,$msg) = $ticketTool->verify_ticket($r)
sub verify_ticket {
    my($self, $r) = @_;
    my %cookies = CGI::Cookie->parse($r->header_in('Cookie'));
    return (0, 'user has no cookies') unless %cookies;
    return (0, 'user has no ticket') unless $cookies{'Ticket'};
    my %ticket = $cookies{'Ticket'}->value;
    return (0, 'malformed ticket')
	unless $ticket{'hash'} && $ticket{'user'} && 
	    $ticket{'time'} && $ticket{'expires'};
    return (0, 'IP address mismatch in ticket')
	unless $ticket{'ip'} eq $r->connection->remote_ip;
    return (0, 'ticket has expired')
	unless (time - $ticket{'time'})/60 < $ticket{'expires'};
    my $secret;
    return (0, "can't retrieve secret") 
	unless $secret = $self->fetch_secret;
    my $newhash = MD5->hexhash($secret .
                     MD5->hexhash(join ':', $secret,
			       @ticket{qw(ip time expires user)})
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
