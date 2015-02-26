<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/javascript');

$username = "cticoaches";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

//select a database to work with 
$selected = mysql_select_db("CTIDATABASE",$dbh) 
  or die("Could not select examples");


$html = '';


// NORTHERN CALIFORNIA

$NA_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='MTree' OR location='Wildwood' OR location='Sequoia' OR location="WESTERBEKE"  OR location="MCC") ORDER BY start_date ASC
EOS;

$NA_retreats = get_events( $NA_sql, 'NA' );
$html .= emit_calendar( $NA_retreats, 'Northern California, USA', 'Northern California' );


// EAST COAST

$BOI_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND location like '%BOI' ORDER BY start_date ASC
EOS;

$BOI_retreats = get_events( $BOI_sql, '' );
$html .= emit_calendar( $BOI_retreats, 'East Coast, USA', 'East Coast' );



// SPAIN

$ES_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='SPAIN' or location like 'ES%'  or location like 'IT%') ORDER BY start_date ASC
EOS;

$ES_retreats = get_events( $ES_sql, '' );
$html .= emit_calendar( $ES_retreats, 'Sitges, Spain', 'Sitges, Spain' );


// Turkey

$TR_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location like 'TR%'  ) ORDER BY start_date ASC
EOS;

$TR_retreats = get_events( $TR_sql, '' );
$html .= emit_calendar( $TR_retreats, 'Istanbul, Turkey', 'Istanbul, Turkey' );



// JAPAN

$JP_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND location like '%HGJC' ORDER BY start_date ASC
EOS;

//$JP_retreats = get_events( $NA_sql );
//$html .= emit_calendar( $NA_retreats, 'Northern California, USA', 'Northern California' );

$html = preg_replace('/\n/'," \\\n",$html); // change <cr> to \<cr>
$html = preg_replace('/\'/'," \\'",$html);  // change \' to \\' 



function get_events( $sql, $region ) {

    $events = array( );

// # North American Events
// my ($events) = $dbh->selectall_arrayref($NA_sql,{Columns=>{}});

    $result = mysql_query( $sql );

    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

// for (@$events){
//   $_->{event} =~ m/ ( .*? ) [ ] ( \d ) \z /xms; # get pod name
//   $_->{pod} = $1;
//   my $days = $2 < 3 ? 5 : 4; # 6 days for retreats 1 and 2, 5 days for the rest
//   $_->{start_date_formatted} =~ m/ \A ( \w+ ) .*? (\d\d\d\d) \z /xms; # get month

//   $_->{month} =  UnixDate( ParseDate($_->{start_date}),"%B %Y");
//   $_->{sort_id} = UnixDate(ParseDate($_->{start_date}),"%Y%m%d");
//   $_->{start_date_formatted} = UnixDate(ParseDate($_->{start_date}),"%B %d, %Y");
//   $_->{end_date_formatted} = UnixDate(DateCalc(ParseDate($_->{start_date}),"+ $days days"),"%B %d, %Y");
// }

        // skip this course, it is canceled
        if($row['fmid'] == 20475){
            continue;
        }

        $event = array( );
        $event['event'] = $row['event'];

        preg_match('/(.*?) (\d)$/',$row['event'],$matches);
        $event['pod'] = $matches[1];

        $delta = $matches[2] < 3 ? 5 : 4; // +5 days for retreats 1 and 2,  +4 days for the rest
        $event['month']                = date('F Y',strtotime($row['start_date']));
        $event['sort_id']              = date('Ymd',strtotime($row['start_date']));
        $event['start_date_formatted'] = date('F j, Y',strtotime($row['start_date']));
        $event['end_date_formatted']   = date('F j, Y',strtotime($row['start_date']) + ($delta * 86400));

        //Ticket #639: The above logic of adding 5 or 4 days to start date for Northern California for the specific 
        //start date 'February 15, 2015' does not work.  Hence added an if condition.
        if ($region == 'NA') {
            $temp_start_date = date('F j, Y',strtotime($row['start_date']));
            if ($temp_start_date == 'February 15, 2015') {
                $event['end_date_formatted'] = 'February 19, 2015';
            }  
        }

        $events[] = $event;
    }

    //echo "Events:\n";
    //print_r($events);

// # get names of #1 retreat (i.e. Salmon 1)
// my @pod_names = 
//   uniq 
//   grep { $_ ne '' }
//   map  { $_->{pod} if $_->{event} =~ m/ [ ] 1 \z /xms; } 
//   @$events; # 

    $pod_names = array_unique( 
                 array_map( 'pod_name', 
                 array_filter( $events, 'pod_one_only' ) ) );

//    print_r($pod_names);

// # get month of #1 retreat (i.e. Salmon 1)
// my @months = 
//   uniq 
//   grep { $_ ne '' }
//   map  { $_->{month} if $_->{event} =~ m/ [ ] 1 \z /xms; } 
//   @$events; # 


    $months = array_unique( 
              array_map( 'month_name', 
              array_filter( $events, 'pod_one_only' ) ) );


                    
// # Foreach #1 retreat, get #2, #3, #4 retreats and create $retreats hashref

// my $retreats = [ ];

// foreach my $pod (@pod_names) {
//   my @events = 
//     sort { $a->{sort_id} <=> $b->{sort_id} }
//     grep { $_->{pod} eq $pod } 
//     @$events;

//   push(@$retreats,
//        {
//          id       => eval { $events[0]->{sort_id} },
//          month    => eval { $events[0]->{month}   },
//          retreat1 => eval { $events[0]->{start_date_formatted} . ' - ' . $events[0]->{end_date_formatted} },
//          retreat2 => eval { $events[1]->{start_date_formatted} . ' - ' . $events[1]->{end_date_formatted} },
//          retreat3 => eval { $events[2]->{start_date_formatted} . ' - ' . $events[2]->{end_date_formatted} },
//          retreat4 => eval { $events[3]->{start_date_formatted} . ' - ' . $events[3]->{end_date_formatted} },
//        });
         
// }

    $retreats = array( );

    foreach($pod_names as $pod_name){
        $retreat_events = array( );
        foreach($events as $event){
            if($event['pod'] == $pod_name){
                $retreat_events[$event['sort_id']] = $event;
            }
        }
        //print_r($retreat_events);
        ksort($retreat_events); // retreat_events now contains retreats for 'pod_name' in order
   
        //echo "Retreats events:\n";
        //print_r($retreat_events);
        
        $keys = array_keys( $retreat_events );

        $retreats[] = array(
            'id'       => $retreat_events[$keys[0]]['sort_id'],
            'month'    => $retreat_events[$keys[0]]['month'],
            'pod'    => $retreat_events[$keys[0]]['pod'],
            'retreat1' => $retreat_events[$keys[0]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[0]]['end_date_formatted'],
            'retreat2' => $retreat_events[$keys[1]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[1]]['end_date_formatted'],
            'retreat3' => $retreat_events[$keys[2]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[2]]['end_date_formatted'],
            'retreat4' => $retreat_events[$keys[3]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[3]]['end_date_formatted'],
        );
    }

    //echo "Retreats:\n";
    //print_r($retreats);
    return $retreats;
}


function pod_name($v){
    return $v['pod'];
}

function month_name($v){
    return $v['month'];
}

    function pod_one_only($v){
        if( preg_match('/1$/',$v['event']) ){ // if event name has a '1', return pod name
            return true;
        }
        return false;
    }

function emit_calendar( $retreats, $sub_head, $location ){
    $html = '';
    $html .= '<h2 id="calendar-sub-head">'.$sub_head.'</h2>';

    foreach($retreats as $retreat){
        $html .= '<h3>'.$retreat['month'].' - '.$location.'</h3><p>';
        $html .= '<strong>Retreat #1:</strong> '.$retreat['retreat1'].'<br />';
        $html .= '<strong>Retreat #2:</strong> '.$retreat['retreat2'].'<br />';
        $html .= '<strong>Retreat #3:</strong> '.$retreat['retreat3'].'<br />';
        $html .= '<strong>Retreat #4:</strong> '.$retreat['retreat4'].'<br />';
        $html .= '</p>';
    }
    $html .= '<p><a href="dates-locations/retreat-locations">Click here for information on the '.$location.' retreat location.</a><br />&nbsp;</p>';


    return $html;
}

?>
document.write('<?php echo $html ?>');