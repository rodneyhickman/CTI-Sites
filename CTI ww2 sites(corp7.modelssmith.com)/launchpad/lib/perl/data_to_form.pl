#!/usr/bin/perl

use strict;

use URI::URL;
use LWP::UserAgent;
use HTTP::Request;
use HTTP::Request::Common;
use HTTP::Request::Form;
use HTML::TreeBuilder 3.0;
use Smart::Comments;
use LWP::UserAgent;

my $row = {
'adminpid' => -2,
         'dietary[beef]' => 'yes',
         'dietary[crucial_dietary_restrictions]' => 'no',
         'dietary[describe_dietary_restrictions]' => '',
         'dietary[email1]' => 'beutelevision@gmail.com',
         'dietary[first_name]' => 'Thomas',
         'dietary[lamb]' => 'yes',
         'dietary[last_name]' => 'Beutel',
         'dietary[pork]' => 'yes',
         'dietary[poultry]' => 'yes',
         'dietary[seafood]' => 'yes',
         'dietary[vegan]' => 'no',
         'dietary[vegan_with_eggs]' => 'no',
         'focus' => '',
         'referer' => '',
        'role' => 'participant',
         'tribe_id' => '14'

};

my $ua = LWP::UserAgent->new;

### starting
post_data($ua, 'http://ww2.thecoaches.com/launchpad/ctiforms/DietaryRequirements', $row);

### done

sub post_data {
  my ($ua, $url, $row) = @_;

  my $url = url $url;
  my $res = $ua->request(GET $url);
  my $tree = HTML::TreeBuilder->new;
  $tree->parse($res->content);
  $tree->eof();

  my @forms = $tree->find_by_tag_name('FORM');
  die "What, no forms in $url?" unless @forms;
  my $f = HTTP::Request::Form->new($forms[0], $url);

  foreach my $field(keys %$row){
    $f->field($field,$row->{$field});
  }

  $f->dump();

  my $response = $ua->request($f->press());

### $response

#  $f->field("q", "perl");
#  my $response = $ua->request($f->press("search"));

}

sub form_fields {
  my ($ua, $url, $row) = @_;



  my $url = url $url;
  my $res = $ua->request(GET $url);
  my $tree = HTML::TreeBuilder->new;
  $tree->parse($res->content);
  $tree->eof();

  my @forms = $tree->find_by_tag_name('FORM');
  die "What, no forms in $url?" unless @forms;
  my $f = HTTP::Request::Form->new($forms[0], $url);

  my @all_fields = $f->allfields();

### @all_fields

  my %map = map { $_ => '' } @all_fields ;

### %map

}
