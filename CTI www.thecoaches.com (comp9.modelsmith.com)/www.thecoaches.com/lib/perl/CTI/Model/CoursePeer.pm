package CTI::Model::CoursePeer;
use CTI::Model::Course;

# TO DO:
# new_from_rows, returns array_ref of objects
# retrieveByPk, returns object
# doSelectOneBySql( $sql ), returns object
# doSelectBySql( $sql ), returns array_ref of objects

sub new_from_row {
  my ($class,$row);
  my $new_object = CTI::Model::Course->new( $row );
  return $new_object;
}




1;
