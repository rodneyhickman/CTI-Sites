package CTI09::ApacheHandler;

# Bring in Mason with Apache support.
use HTML::Mason::ApacheHandler;
use strict;

# List of modules that you want to use within components.
{ package HTML::Mason::Commands;
  use Apache2::Cookie;
  use Data::Dumper;
  use DBI;
  #use Tie::DBI;
  use lib '/www/www.thecoaches.com/lib/perl';
  use User;
  use vars qw($dbh %DB $Name $Ext $gs_student $gs_group $gs_week $User $Secret);
}

# Create ApacheHandler object at startup.
my $ah = new HTML::Mason::ApacheHandler( comp_root => '/www/www.thecoaches.com/docs',
                                         data_dir => '/www/www.thecoaches.com/mason-data' );

sub handler
{
    my ($r) = @_;

    my $status = $ah->handle_request($r);
    return $status;
}

1;
