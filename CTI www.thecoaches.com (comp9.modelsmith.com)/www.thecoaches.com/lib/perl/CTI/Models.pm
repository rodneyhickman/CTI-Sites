package CTI::Model::Course;
use Class::Std:Utils;


{
  # objects of this class have the following attributes
  my %id;
  my %fmid;
  my %date;
  my %event;
  my %region;
  my %location;
  my %total;
  my %call_time;
  my %course_type_id;
  my %start_date;
  my %end_date;
  my %start_date_formatted;
  my %end_date_formatted;
  my %student_count;
  my %day_of_week;
  my %series_id;
  my %assistant_count;
  my 

  sub new {
    my ($class) = @_;

    my $new_object = bless \do{my $anon_scalar}, $class;

    $course{ident $new_object};
    return $new_object;
  }


}


package CTI::Model::CourseSeries;
use Class::Std:Utils;


1;
