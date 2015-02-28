package Apache::CTITicketAccess;

use strict;
use Apache::Constants qw(:common);
use Apache::CTITicketTool ();

sub handler {
    my $r = shift;
    my $ticketTool = Apache::CTITicketTool->new($r);
    my($result, $msg) = $ticketTool->verify_ticket($r);
    unless ($result) {
	$r->log_reason($msg, $r->filename);
	my $cookie = $ticketTool->make_return_address($r);
	$r->err_headers_out->add('Set-Cookie' => $cookie);
	return FORBIDDEN;
    }
    return OK;
}

1;
__END__
