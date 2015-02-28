#!/usr/bin/perl

use strict;
use warnings;

print "Starting...\n";

my $list = `grep thecoaches.com /home/ctiadmin/change.log | awk '{print \$7}'`;

    my @files = split(/\n/,$list);

print "Files have been split\n";

my %seen;
foreach my $file (@files){
    next if $seen{$file};
    $seen{$file} = 1;
    $file =~ s/\"//g;
    $file =~ s{/home/ctiadmin/www.thecoaches.com/}{};
    next if $file =~ m/CI_test/;
    if($file =~ m/(\.js)/){
    print "$file\n";
    print "Diffing\n";
	my $diff = `git diff $file`;
    if($diff =~ m/32f02e/){
	print "This file is compromised... reverting\n";
	my $revert = `git checkout HEAD -- $file`;
	print $revert;
	print "Reverted\n";
#    sleep 1;
    }
    }
}
