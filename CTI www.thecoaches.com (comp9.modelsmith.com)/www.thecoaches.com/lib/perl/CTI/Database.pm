package CTI::Database;

#
# Thomas Beutel
# For The Coaches Training Institute
# 10-May-2007

use strict;
use vars qw($VERSION @ISA @EXPORT_OK);
use Smart::Comments;
use SQL::Library;

# abstract the following
our $library = new SQL::Library { lib => [ <DATA> ] };


require Exporter;

@ISA = qw(Exporter);
@EXPORT_OK = qw( get_sql
                 add_update_maker
		 );


sub get_sql {
    my $name = shift;
    return $library->retr( $name );
}


sub add_update_maker {
    my $dbh       = shift;
    my $libprefix = shift;

    my $find_sql   = get_sql ( $libprefix . '_find' );
    my $insert_sql = get_sql ( $libprefix . '_insert' );
    my $update_sql = get_sql ( $libprefix . '_update' );
    my $last_sql =   get_sql ( $libprefix . '_last_inserted' );

  if($find_sql   eq '' or
     $insert_sql eq '' or
     $update_sql eq '' or
     $last_sql   eq '') {
      warn 'SQL statement not available - please check the spelling of your libprefix';
      return undef;
  }

    return sub {
        my ($criteria,$data) = @_;  # both are array_refs
        my $err;

    # perform the find to get $id
        my $id = $dbh->selectrow_array($find_sql,undef,@$criteria);
        $err = $dbh->errstr;

    # found in database, so just update it
        if( $id > 0 ){ 
            $dbh->do($update_sql,undef,@$data,$id);
            $err .= $dbh->errstr;
            return ($id,$err);
        }

    # not found in database, so add it
        $dbh->do($insert_sql,undef,@$data);
        $err .= $dbh->errstr;
    
    # get the id for this new record
        ($id) = $dbh->selectrow_array($last_sql,undef);
        $err .= $dbh->errstr;

        return ($id,$err);
    }
}



1;

=head1 Methods and Functions

=over

=item get_sql


=cut



=item add_update_maker

    my $filter_updater = add_update_maker('filter_by_pseudocode');

...

my ($id,$err) = $filter_updater->(
  ['0,18,"foobar";'],
  ['sub{}','0,18,"foobar";']   
                                  );
 
=cut 

__DATA__
[dummy_statement]
SELECT * FROM dummy

[get_r5_retreats]
SELECT id,event,location,start_date_formatted,end_date_formatted FROM event_calendar
WHERE course_type_id=57


[get_boi_leadership_retreats]
SELECT id,event,start_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND location like '%BOI'

[get_spanish_leadership_retreats]
SELECT id,event,start_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='SPAIN' or location like 'ES%' or location like 'IT%')

[get_north_american_leadership_retreats]
SELECT id,event,start_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='MTree' OR location='Wildwood' OR location='Sequoia' OR location="WESTERBEKE")

[get_leadership_info_calls]
SELECT id,event,start_date,start_date_formatted,call_time,day_of_week FROM event_calendar
WHERE course_type_id=52

[get_free_info_calls]
SELECT id,event,start_date,start_date_formatted,call_time,day_of_week FROM event_calendar
WHERE course_type_id=9


[get_supervisor]
SELECT sup_info.id,sup_info.name,sup_info.admin_rights,sup_info.timezone,sup_info.special_url,sup_info.email_address
FROM sup_info,user_info
WHERE sup_info.user_name=?
LIMIT 1

[get_supervisor_tz]
SELECT sup_info.id,sup_info.name,sup_info.timezone
FROM sup_info,user_info
WHERE sup_info.user_name=?
LIMIT 1

[get_special_url]
SELECT sup_info.id
FROM sup_info
WHERE special_url=?

[update_special_url]
UPDATE sup_info
SET special_url=?
WHERE id=?

[get_supervisor_by_url]
SELECT sup_info.id,sup_info.name
FROM sup_info
WHERE sup_info.special_url=?
LIMIT 1

[get_supervisor_email_by_id]
SELECT email_address FROM sup_info
WHERE id=?
LIMIT 1

[get_supervisor_login_info]
SELECT sup_info.name,sup_info.admin_rights,sup_info.user_name
FROM sup_info
WHERE sup_info.id=?
LIMIT 1

# stuff for /supervisor/admin.html

[get_supervisor_by_username]
SELECT id FROM sup_info
WHERE user_name=?
LIMIT 1

[get_serial_by_username]
SELECT serial FROM user_info
WHERE user_name=?
LIMIT 1

[update_supervisor_by_username]
UPDATE sup_info
SET name=?, admin_rights=?
WHERE user_name=?

[update_user_by_username]
UPDATE user_info
SET passwd=?
WHERE user_name=?

[insert_supervisor]
INSERT INTO sup_info
(name,admin_rights,user_name,email_address,timezone) values (?,?,?,?,'Pacific')

[insert_user]
INSERT INTO user_info
(user_name,passwd) values (?,?)

[delete_supervisor_by_id]
DELETE FROM sup_info
WHERE id=?

# supervisor group
[supervisor_find]
SELECT id,user_serial,admin_rights FROM sup_info
WHERE name=?

[supervisor_insert]
INSERT INTO sup_info
(name,user_serial,admin_rights,created,modified) values (?,?,?,NOW(),NOW())

[supervisor_update]
UPDATE sup_info
SET name=?,user_serial=?,admin_rights=?
WHERE id=?

[supervisor_last_inserted]
SELECT LAST_INSERT_ID() FROM sup_info
LIMIT 1

[supervisor_by_id]
SELECT name,user_serial,admin_rights FROM sup_info
WHERE id=?
LIMIT 1

[supervisor_all]
SELECT id,name,user_serial,user_name,admin_rights FROM sup_info
ORDER BY name

[supervisor_search]
SELECT id,name,user_serial,admin_rights FROM sup_info
WHERE name LIKE ?

[get_times]
SELECT sup_calevent.time,sup_student.name
FROM sup_calevent
LEFT JOIN sup_event_join
 ON sup_calevent.id=sup_event_join.event_id
LEFT JOIN sup_student
 ON sup_student.id=sup_event_join.student_id
WHERE sup_id=?
AND year=?
AND month=?
AND day=?

[get_id_for_time]
SELECT id,dt FROM sup_calevent
WHERE sup_id=?
AND year=?
AND month=?
AND day=?
AND time=?
LIMIT 1

[add_sup_cal_time]
INSERT INTO sup_calevent
(sup_id,year,month,day,time,dt,timezone) values (?,?,?,?,?,?,?)

[last_event_id]
SELECT LAST_INSERT_ID() FROM sup_calevent

[get_sup_timezone]
SELECT timezone FROM sup_info
WHERE id=?
LIMIT 1

[del_sup_cal_time]
DELETE FROM sup_calevent
WHERE sup_id=?
AND year=?
AND month=?
AND day=?
AND time=?

[get_month]
SELECT sup_calevent.day,sup_calevent.time,sup_student.name
FROM sup_calevent
LEFT JOIN sup_event_join
 ON sup_calevent.id=sup_event_join.event_id
LEFT JOIN sup_student
 ON sup_student.id=sup_event_join.student_id
WHERE sup_id=?
AND year=?
AND month=?

[update_supervisor_profile]
UPDATE sup_info
SET name=?,timezone=?,email_address=?
WHERE id=?

# Certification

[get_pod_names]
SELECT pod_name FROM event_calendar
WHERE course_type_id=1

[get_pods]
SELECT id,pod_name FROM event_calendar
WHERE course_type_id=1


# Supervision Students
[get_student_by_email]
SELECT id FROM sup_student
WHERE email=?
LIMIT 1

[get_student_info]
SELECT sup_student.id,sup_student.name,sup_student.email,sup_student.pod_event_id,event_calendar.pod_name
FROM sup_student, event_calendar
WHERE user_name=?
AND sup_student.pod_event_id=event_calendar.id
LIMIT 1

[check_student_pw]
SELECT id,password FROM sup_student
WHERE user_name=?
LIMIT 1

[get_student_by_reset_key]
SELECT id,user_name,email FROM sup_student
WHERE reset_key=?
LIMIT 1

[update_student_reset_key]
UPDATE sup_student
SET reset_key=?
WHERE id=?

[update_student_passwd]
UPDATE sup_student
SET password=?, reset_key=''
WHERE id=?

[insert_new_student]
INSERT INTO sup_student
(user_name,password,name,email,pod_event_id,created) VALUES (?,?,?,?,?,NOW())

[last_student_id]
SELECT LAST_INSERT_ID() FROM sup_student

[find_student_by_name]
SELECT id FROM sup_student
WHERE name=?

# start times

[get_start_times_by_student]
SELECT sup_calevent.* FROM sup_calevent,sup_event_join
WHERE sup_calevent.id=sup_event_join.event_id
AND sup_event_join.student_id=?
ORDER BY sup_calevent.dt


[get_open_start_times]
SELECT sup_calevent.* FROM sup_calevent
LEFT JOIN sup_event_join ON sup_calevent.id=sup_event_join.event_id
WHERE sup_event_join.id IS NULL
AND sup_calevent.sup_id=?
ORDER BY dt

[add_student_event_join]
INSERT INTO sup_event_join
(event_id,student_id,status,sup_id_cache,date_cache,created) values (?,?,?,?,?,NOW())


[get_successful_supervisions]
SELECT name,date_cache
FROM sup_event_join
LEFT JOIN sup_student ON sup_student.id=sup_event_join.student_id 
WHERE sup_id_cache=?
AND date_cache>?
AND date_cache<?
AND status='ok'
ORDER BY date_cache

[get_missed_supervisions]
SELECT name,date_cache
FROM sup_event_join
LEFT JOIN sup_student ON sup_student.id=sup_event_join.student_id 
WHERE sup_id_cache=?
AND date_cache>?
AND date_cache<?
AND status='missed'
ORDER BY date_cache

[get_rescheduled_supervisions]
SELECT name,date_cache
FROM sup_event_join
LEFT JOIN sup_student ON sup_student.id=sup_event_join.student_id 
WHERE sup_id_cache=?
AND date_cache>?
AND date_cache<?
AND status='self'
ORDER BY date_cache

[get_lt24_supervisions]
SELECT name,date_cache
FROM sup_event_join
LEFT JOIN sup_student ON sup_student.id=sup_event_join.student_id 
WHERE sup_id_cache=?
AND date_cache>?
AND date_cache<?
AND status='lt24'
ORDER BY date_cache

[get_gt24_supervisions]
SELECT name,date_cache
FROM sup_event_join
LEFT JOIN sup_student ON sup_student.id=sup_event_join.student_id 
WHERE sup_id_cache=?
AND date_cache>?
AND date_cache<?
AND status='gt24'
ORDER BY date_cache

[mark_event_status]
UPDATE sup_event_join
SET status=?
WHERE event_id=?


# Pods

[get_pods_and_dates]
SELECT pod_name,date FROM event_calendar
WHERE course_type_id=1
AND location='Bridge'
ORDER BY start_date

