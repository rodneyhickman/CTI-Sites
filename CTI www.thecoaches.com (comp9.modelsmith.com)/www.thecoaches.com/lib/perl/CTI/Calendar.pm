package CTI::Calendar;

#
# By Thomas Beutel
# 10-May-2007

use strict;
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK);  
use Smart::Comments;



require Exporter;

@ISA = qw(Exporter);
@EXPORT_OK = qw(  );
$VERSION = '0.01';

#sub new {
#  my ($class,$data) = @_;
#  my $new_object = bless {}, $class;
#  $new_object->{data} = $data;
#  return $new_object;
#}

# sub Iterator (&) { return $_[0] }  # iterator sugar

# sub iterator_maker {
#   my $sql = retrieve( ' ' );
#   my $sth = $dbh->prepare( $sql );

#   $sth->execute();

#   my( $id, $title, $description );
#   $sth->bind_columns( undef, \$foo, \$bar, \$baz );

#   return Iterator {
#     $sth->fetch();

#     if($id > 0){
#       return ($id,$foo,$bar,$baz);
#     }
#     $sth->finish();
#     return undef;
#   }
# }



__END__

