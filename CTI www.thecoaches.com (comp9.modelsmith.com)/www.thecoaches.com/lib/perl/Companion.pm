package Companion;

use LWP::Simple qw(get);
use HTML::TreeBuilder;
use URI::Escape;
use strict;

sub new {
  my ($pkg, %data) = @_;
  return bless \%data, $pkg
    if $data{url} and $data{layout} and $data{format} and $data{DB};
  return undef;
}

sub Find {
  my ($self,%fields) = @_;
#    my $html = get("$self->{url}/FMPro?".
#  		 join('&',
#  		      "-DB=$self->{DB}",
#  		      "-lay=$self->{layout}",
#  		      "-format=$self->{format}",
#  		      ( map { uri_escape($_)."=".uri_escape($fields{$_}) } keys %fields ),
#  		      "-Find"
#  		     )
# 		  );

  my $html = `cat ../sample.html`;

  my $tree = HTML::TreeBuilder->new; # empty tree
  $tree->parse($html);

  return map { [ map { $_->as_text } $_->find('td') ] } $tree->find('tr');
}



1;
