#!/usr/bin/perl

use CTI::Model::Course;
use CTI::Model::CoursePeer;
use Smart::Comments;

use strict;

my $course = CTI::Model::Course->new({id=>1,fmid=>1000});

### $course

my $row = {id=>1,fmid=>1000};
my $course2 = CTI::Model::CoursePeer->new_from_row($row);

### $course2

