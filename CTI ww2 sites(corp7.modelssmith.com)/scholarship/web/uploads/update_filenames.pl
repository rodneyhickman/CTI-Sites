#!/usr/bin/perl

use strict;

use DBI;
use Data::Dumper;

my $dbh = DBI->connect("DBI:mysql:scholardb",'scholaruser','2wSDe3');

my $rows = $dbh->selectall_arrayref("select *,execcoach.id AS execcoach_id from execcoach,profile where profile_id=profile.id AND profile_id > 0", { Columns => {} });

foreach my $row (@$rows) {

  if ($row->{profile_id} <706 ) {
    my $profile_id = $row->{profile_id};
    my $resume = $row->{bio_resume};
    my $photo = $row->{photo};
    my $first_name = $row->{first_name};
    $first_name =~ s/[^A-Za-z0-9]+/-/g;
    my $last_name = $row->{last_name};
    $last_name =~ s/[^A-Za-z0-9]+/-/g;
    my $prepend = "$profile_id"."-$first_name"."-$last_name";
    
  print "profile_id: $row->{profile_id} $first_name $last_name $resume $photo ($prepend)\n";

    if (-f $resume) {
      my ($ext) = ($resume =~ m/\.([^\.]*)$/ms);
      my $new_resume = "$prepend-resume.$ext";
      if ($resume ne $new_resume) {
        `mv '$resume' $new_resume`;
        print "moved $resume to $new_resume\n";
        $dbh->do('update execcoach set bio_resume=? where id=?',undef,$new_resume,$row->{execcoach_id});
      }
    }

    if (-f $photo) {
      my ($ext) = ($photo =~ m/\.([^\.]*)$/ms);
      my $new_photo = "$prepend-photo.$ext";
      if ($photo ne $new_photo) {
        `mv '$photo' $new_photo`;
        print "moved $photo to $new_photo\n";
        $dbh->do('update execcoach set photo=? where id=?',undef,$new_photo,$row->{execcoach_id});
      }
    }

    #print Dumper $row;
  }


}
