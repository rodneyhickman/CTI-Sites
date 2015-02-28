package User;

use constant AUTH_USERS   => 'auth_users';
use constant AUTH_GROUPS  => 'auth_groups';
use constant USER_CONTEXT => 'user_context';

sub new { 
    my $class = shift; 
    my $dbh = shift; 
    return (bless { id => 0, dbh => $dbh }, $class);
}

sub id {
    my $self = shift;
    if (@_) { $self->{id} = shift }
    return $self->{id};
}

sub email {
    my $self = shift;
    if (@_) { $self->{email} = shift }
    return $self->{email};
}

sub is_guest {
    my $self = shift;
    $self->{id} = 0;
    return $self;
}

sub is_authorized_for {
    my $self = shift;
}

sub context {
    my $self = shift;
    my $ukey = shift;  # user key
    my $value;
    if(@_){ 
	$value = shift;
	# set value
	my $sth = $self->{dbh}->prepare('DELETE FROM '.USER_CONTEXT.' where uid=? and ukey=?');
	$sth->execute($self->{id}, $ukey);
	$sth = $self->{dbh}->prepare('INSERT INTO '.USER_CONTEXT.' (uid,ukey,value) VALUES (?,?,?)');
	$sth->execute($self->{id}, $ukey, $value);
    } else {
	# get value
	my $sth = $self->{dbh}->prepare('SELECT value from '.USER_CONTEXT.' where uid=? AND ukey=?');
	$sth->execute($self->{id}, $ukey);
	$value = $sth->fetchrow_array;
    }
    return $value;
}


1;


