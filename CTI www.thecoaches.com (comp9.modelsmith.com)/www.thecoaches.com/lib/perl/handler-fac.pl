package MyMason::FAC;

# Bring in Mason with Apache support.
use HTML::Mason::ApacheHandler;
use strict;

# List of modules that you want to use within components.
{ package HTML::Mason::Commands;
  use Apache::Cookie;
  use Apache::DBI;
  use Data::Dumper;
  use DBI;
  use Tie::DBI;
  use vars qw($dbh %DB);
}

# Create ApacheHandler object at startup.
my $ah = new HTML::Mason::ApacheHandler( comp_root => '/www/thecoaches/fac/mason',
                                         data_dir => '/www/thecoaches/fac/mason-data' );

sub handler
{
    my ($r) = @_;

    my $status = $ah->handle_request($r);
    return $status;
}

1;
