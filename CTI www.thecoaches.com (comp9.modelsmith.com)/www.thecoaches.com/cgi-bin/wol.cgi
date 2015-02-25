#!/usr/bin/perl
use strict;
use Data::Dumper;
use CGI::Carp  qw(fatalsToBrowser);
use CGI qw(:standard);

use GD;

my @q = ();
$q[1] = param('q3');
$q[2] = param('q4');
$q[3] = param('q5');
$q[4] = param('q6');
$q[5] = param('q7');
$q[6] = param('q8');
$q[7] = param('q1');
$q[8] = param('q2');

$q[9] = param('q9');


foreach my $r (1..9) {
  if ($q[$r] > 10.0 or $q[$r]< 0.0) {
    $q[$r] = 0;
  }
}

# create a new image
my $im = newFromPng GD::Image('/www/www.thecoaches.com/docs/images/results_wheel.png');
#my $im = new GD::Image(400,400);

# truecolor mode
#$im->trueColor(1);
$im->alphaBlending(1);

# allocate some colors
my $white = $im->colorAllocate(255,255,255);
my $black = $im->colorAllocateAlpha(0,0,0,30);       
my $red = $im->colorAllocateAlpha(255,0,0,30);      
my $blue = $im->colorAllocateAlpha(0,0,255,30);


my $c1 = $im->colorAllocateAlpha(106,196,235,0); #6ac4eb
my $c2 = $im->colorAllocateAlpha(255,212,87,0); #ffd457
my $c3 = $im->colorAllocateAlpha(225,91,140,0); #e15b8c
my $c4 = $im->colorAllocateAlpha(212,104,108,0); #d4686c

my $c5 = $im->colorAllocateAlpha(248,168,99,0); #f8a863
my $c6 = $im->colorAllocateAlpha(77,141,196,0); #4d8dc4
my $c7 = $im->colorAllocateAlpha(148,108,178,0); #946cb2
my $c8 = $im->colorAllocateAlpha(117,203,129,0); #75cb81

#$im->setAntiAliased($white);


my @arc_color = (undef,$c3,$c4, $c5,$c6,$c7,$c8,$c1,$c2);

# make the background transparent and interlaced
#$im->transparent($white);
#$im->interlaced('true');

# Put a black frame around the picture
#$im->rectangle(0,0,99,99,$black);

# $image->filledArc($cx,$cy,$width,$height,$start,$end,$color [,$arc_style])
# This method is like arc() except that it colors in the pie wedge with the selected color. $arc_style is optional. If present it is a bitwise OR of the following constants:
#   gdArc           connect start & end points of arc with a rounded edge
#   gdChord         connect start & end points of arc with a straight line
#   gdPie           synonym for gdChord
#   gdNoFill        outline the arc or chord
#   gdEdged         connect beginning and ending of the arc to the center

my @xoffset = ( undef, 
9.23878684288748, 3.82680565464419, -3.82687118374823, -9.23881398584895, -9.23877327123246, -3.82677289001997,3.82683841922028, 9.23880041442631, 
);
my @yoffset = ( undef, 
3.82683841922028, 9.23880041442631, 9.23878684288748, 3.82680565464419, -3.82687118374823, -9.23881398584895, -9.23877327123246, -3.82677289001997,
);
# Draw arcs
foreach my $r (1..8) {
  $im->filledArc(150+$xoffset[$r],130+$yoffset[$r],180*($q[$r]/10),180*($q[$r]/10),(45*($r-1)),(45*$r),$arc_color[$r]);
}

# make sure we are writing to a binary stream
binmode STDOUT;

# Mime header
print "Content-Type: image/png\n\n";

# Convert the image to PNG and print it on standard output
print $im->png;


