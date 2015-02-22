#!/usr/bin/perl

use strict;
use DBI;
use Data::Dumper;
$|++;


my $dbh = DBI->connect("DBI:mysql:CTIDATABASE",'cticoaches','');

 my $sql = "select id,start_date,event,TO_DAYS(start_date),TO_DAYS(now()) from event_calendar WHERE region='DVR' AND fmid=21311";

my $result = $dbh->selectall_arrayref( $sql, {Columns=>{}});

foreach (1..60) {

my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) =
                                                localtime(time);
print "$hour:$min:$sec\n";
print Dumper $result;

sleep 15;
}

