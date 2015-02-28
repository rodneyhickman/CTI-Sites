package CTI::Model::Course;
use Class::Std::Utils;


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
  my %assistant_wait_count;
  my %booking_link;
  my %pod_name;

  sub new {
    my ($class, $params) = @_;

    my $new_object = bless anon_scalar(), $class;

    $id{ident $new_object} = $params->{id};
    $fmid{ident $new_object} = $params->{fmid};
    $date{ident $new_object} = $params->{date};
    $event{ident $new_object} = $params->{event};
    $region{ident $new_object} = $params->{region};
    $location{ident $new_object} = $params->{location};
    $total{ident $new_object} = $params->{total};
    $call_time{ident $new_object} = $params->{call_time};
    $course_type_id{ident $new_object} = $params->{course_type_id};
    $start_date{ident $new_object} = $params->{start_date};
    $end_date{ident $new_object} = $params->{end_date};
    $start_date_formatted{ident $new_object} = $params->{start_date_formatted};
    $end_date_formatted{ident $new_object} = $params->{end_date_formatted};
    $student_count{ident $new_object} = $params->{student_count};
    $day_of_week{ident $new_object} = $params->{day_of_week};
    $series_id{ident $new_object} = $params->{series_id};
    $assistant_count{ident $new_object} = $params->{assistant_count};
    $assistant_wait_count{ident $new_object} = $params->{assistant_wait_count};
    $booking_link{ident $new_object} = $params->{booking_link};
    $pod_name{ident $new_object} = $params->{pod_name};

    return $new_object;
  }

  sub get_id {
    my ($self) = @_;
    return $id{ident $self};
  }
  sub set_id {
    my ($self,$id) = @_;
    $id{ident $self} = $id;
  }



}




1;
