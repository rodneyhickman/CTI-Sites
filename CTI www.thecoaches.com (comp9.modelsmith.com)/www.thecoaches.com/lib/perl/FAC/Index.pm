package FAC::Index;

use Text::English;
use Data::Dumper;
use strict;
use vars qw(%stop_word);

# these words will not be included in the index
%stop_word = map { $_ => 1 } qw(
a
after
also
an
am
and
as
at
be
because
before
between
but
before
coach
for
however
from
i
if
in
is
into
of
or
other
out
since
such
than
that
the
these
there
this
those
to
under
upon
was
when
where
whether
which
with
within
without
);

sub add {
  my $file  = shift;
  my $id    = shift;
  my @words = @_;

  # massage the words into stems
  $_ = lc foreach @words;            # lowercase the words
  s/[^a-zA-Z0-9]//g foreach @words;  # remove non alphanumeric chars
  my @stems = Text::English::stem(grep { $stop_word{$_} ? '' : $_ }
				  @words);   # remove stopwords and stem the rest

# print Dumper \@words;
# print Dumper \@stems;
# return;

  # Check for the LOCK file
  for (1..5) {
    last unless -e "$file.lock";
    sleep 2;  # wait a little bit
  }

  return "File not not released" if -e "$file.lock";
  open(LOCK,">$file.lock")
    or return "Can't create lock";
  print LOCK $$,"\n";  # write out the process number
  close LOCK;

  # Read the INDEX file
  open(INDEX,$file)
    or return "Can't open INDEX";
  my %hash = map { split(' ',$_,2) } <INDEX>; # store index in hash
  chomp $hash{$_} foreach keys %hash;
  close INDEX;

  # Add id to each stem word unless id already exists for the stem word
  foreach my $stem (@stems){
    next unless $stem;
    if(exists $hash{$stem}){
      my %ids = map { $_,1 } split(' ',$hash{$stem});
      $hash{$stem} = "$hash{$stem} $id" unless $ids{$id} or $stem eq ''; 
        # append id to this word
    } else {
      $hash{$stem} = $id; # initial value for this stem
    }
  }

  delete $hash{''}; # remove the '' key if it exists
#print Dumper \%hash;

  # Write the INDEX
  open(INDEX,">$file") 
    or return "Can't write INDEX";
  print INDEX join("\n",map { "$_ $hash{$_}" } sort keys %hash),"\n"; # write the index
  close INDEX;
  unlink "$file.lock";
  return undef; # everything is OK
}

1;
__END__

=pod

Note that ids are not scrubbed from the INDEX if an id exists on a previous stem word that is no longer used.

=cut
