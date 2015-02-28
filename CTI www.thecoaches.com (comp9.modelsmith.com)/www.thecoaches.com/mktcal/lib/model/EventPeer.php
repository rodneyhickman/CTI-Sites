<?php

class EventPeer extends BaseEventPeer
{

  public static function getEventsByDate( ){
    $c = new Criteria();
    $c->addAscendingOrderByColumn( EventPeer::START_DATE );
    $events = EventPeer::doSelect( $c );

    return $events;
  }

  public static function getEventsByMonth( $month, $year ){

    $year2 = $year;
    if($month == 12){
      $month2 = 1;
    }
    else {
      $month2 = $month + 1;
    }

    // returns array of days, with padding, with events
    $c = new Criteria();
    $c->add(EventPeer::START_DATE, Date('Y-m-d H:i:s',strtotime("$year-$month-01 00:00:00")), Criteria::GREATER_EQUAL  );
    $c->add(EventPeer::START_DATE, Date('Y-m-d H:i:s',strtotime("$year2-$month2-01 00:00:00")), Criteria::LESS_THAN  );
    $c->addAscendingOrderByColumn( EventPeer::START_DATE );
    $events = EventPeer::doSelect( $c );

    return $events;
  }

  public static function getYears( ){
    $years_assoc = array( );

    $c = new Criteria();
    $c->addAscendingOrderByColumn( EventPeer::START_DATE );
    $events = EventPeer::doSelect( $c );

    foreach($events as $event){
      $year = Date('Y',strtotime($event->getStartDate()));
      $years_assoc[$year] = 1;
    }

    $keys = array_keys( $years_assoc ) ;

    return $keys;
  }


  public static function getQuarters( ){
    $quarters_assoc = array( );

    $c = new Criteria();
    $c->addAscendingOrderByColumn( EventPeer::START_DATE );
    $events = EventPeer::doSelect( $c );

    foreach($events as $event){
      $year = Date('Y',strtotime($event->getStartDate()));
      $month = Date('n',strtotime($event->getStartDate()));
      if($month >= 1 && $month <= 3){
        $quarters_assoc[$year."_Q1"] = 1;
      }
      elseif($month >= 4 && $month <= 6){
        $quarters_assoc[$year."_Q2"] = 1;
      }
      elseif($month >= 7 && $month <= 9){
        $quarters_assoc[$year."_Q3"] = 1;
      }
      elseif($month >= 10 && $month <= 12){
        $quarters_assoc[$year."_Q4"] = 1;
      }
    }

    $keys = array_keys( $quarters_assoc ) ;

    return $keys;

  }


  public static function updateEvents( $params )
  {
    $course_type_ids = array( 
    '3' => 'FUN',
    '4' => 'PRO',
    '5' => 'BAL',
    '6' => 'FUL',
    '7' => 'SYN',
    '11' => 'LP1',
    '12' => 'LP2',
    '13' => 'LP3',
    '14' => 'LP4',
    '120' => 'Webinar',
    '130' => 'Ambassador events ',
    '145' => 'Conferences where we have a booth or are speaking',
    '148' => 'Relationship Agility Hybrid',
    '150' => 'Pathways',
    '156' => 'Co-Active Sales',
    '159' => 'Ambassador events ',
    '157' => 'Pathways',
    '160' => 'Ambassador events ',
    '173' => 'Co-Active Marketing',
    '171' => 'Exec Coaching',
    '172' => 'Bigger Game',
    '186' => 'Leadership Way',
    '190' => 'Learning Event',
    '191' => 'Learning Event',
    '192' => 'Learning Event',
    '193' => 'Leader from within'

    );

    $non_north_american_regions = array(
      'DE' => 1,
      'NL' => 1,
      'None' => 1,
      'N/A' => 1,
      'ES' => 1,
      'FR' => 1,
      'BR' => 1,
      'GB' => 1,
      'MX' => 1,
      'TR' => 1,
      'CN' => 1,
      'DK' => 1,
      'SE' => 1,
      'FI' => 1,
      'JP' => 1,
      'KR' => 1,
      'NO' => 1,
      'AE' => 1,
      'BE' => 1,
      'CH' => 1

      
    );

    // update based on $data
    // see /home/thomas/code/cti_scripts/geteventsR_yaml
    // see curl 'http://crm.thecoaches.com/fmi-test/webcomp2_newFM/geteventsJSON.php?start=0&range=10'

    // [{"fmid":"17024","course_type_id":"129","event":"Leader Days","date":"04\/08\/2014","edate":"04\/09\/2014",
    //   "region":"CA","location":"CA-Napa","publish":"Don't Publish","call_time":"","student_count":"6","pod_name":"",
    //   "leader_name":"","assistant_count":"","assistant_wait_count":"","booking_link":"","mod_id":"05\/08\/2013 10:04:26",
    //   "mod_date":"05\/08\/2013","mod_time":"10:04:26"}, ... ]

    $json = @$params['json'];
    if($json != ''){
      $incoming_events = json_decode($json, true); // decode as assoc array
      
      foreach($incoming_events as $incoming_event){
        // is it an event we are interested in?
        if( isset( $course_type_ids[$incoming_event['course_type_id']] ) ){

          // grab region from location string if available
          $location_region = preg_replace('/-.*/','',$incoming_event['location']); // remove everything after dash, if present

          if( ! isset( $non_north_american_regions[$incoming_event['region']] ) 
              && ! isset( $non_north_american_regions[$location_region] ) ){

          // find event by fmid
          $c = new Criteria();
          $c->add(EventPeer::FMID, $incoming_event['fmid']);
          $event = EventPeer::doSelectOne( $c );
          
          // if found, update
          if(!isset($event)){
            $event = new Event();
            $event->setFmid( $incoming_event['fmid'] );
          }

          $event->setCourseTypeId( $incoming_event['course_type_id'] );
          $event->setName( $incoming_event['event'] );
          $event->setStartDate( $incoming_event['date'] );
          $event->setEndDate( $incoming_event['edate'] );
          $event->setPublish( $incoming_event['publish'] );
          $event->setLocation( $incoming_event['location'] );
          $event->setLocationName( SiteDataPeer::getLocationName( $incoming_event['location'] ) );
          $event->setRegion( $incoming_event['region'] );
          $event->setCallTime( $incoming_event['call_time'] );
          $event->setBookingLink( $incoming_event['booking_link'] );
          $event->setPodName( $incoming_event['pod_name'] );
          $event->setLeaderName( $incoming_event['leader_name'] );
          $event->setDescription( '' );
          $event->setUrl( '' );
          $event->save();

          } 
        }
      }
    }
  }



  public static function getMonthsFromQuarter( $quarter ){
    // utility function: returns array of year-month from quarter
    $year = preg_replace('/_.*/','',$quarter);
    $q = preg_replace('/.*Q/','',$quarter);
    if($q == 1){
      return array($year.'-1',$year.'-2',$year.'-3');
    }
    if($q == 2){
      return array($year.'-4',$year.'-5',$year.'-6');
    }
    if($q == 3){
      return array($year.'-7',$year.'-8',$year.'-9');
    }
    if($q == 4){
      return array($year.'-10',$year.'-11',$year.'-12');
    }

  }

  // Ticket #347: Adding functionality for Jill, Nick and Janaki to add new events through website.  
  // Note: These events are not stored in the FileMaker.
  public static function saveNewEvent( $params, $user )
  {
      
    $c = new Criteria();
    $c->addDescendingOrderByColumn(EventPeer::FMID);
    $event_tmp = EventPeer::doSelectOne( $c );

    $event = new Event();
    // if not found, create new event and set fmid to 50000
    if(!isset($event_tmp)){
      $event->setFmid(10000000);
    } else {
      if (intval($event_tmp->getFmid()) < 10000000) {
          $event_tmp->setFmid(10000000);
      }
    }

    $event->setFmid(strval(intval($event_tmp->getFmid()) + 1 ));
    $event->setName( $params['event_name'] );
    $event->setDate(strtotime($params['event_date']) );
    $event->setTime($params['event_time']);
    $event->setLocationName($params['event_location'] );
    $event->setLocation($params['event_location'] );
    //$event->setLocationName(SiteDataPeer::getLocationName( $params['event_location'] ) );
    $event->setCourseTypeId(10000000);
    $event->setUpdatedBy($user); // store the logged user
    $event->save();
  }

  // Ticket #645: Enhancing the functionality provided for ticket #347.  
  // The enhancement is editing and deleting the events.
  public static function SearchEventPager( $query, $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();
    $c->add(EventPeer::FMID, 99999, Criteria::GREATER_THAN);
    if($query != ''){
      $c->add(EventPeer::NAME, '%'.$query.'%', Criteria::LIKE);
    }
  
    $pager = new sfPropelPager( 'Event', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }
  
  /**
   * Retrieve a single event by Id.
   *
   * @param      int $id
   * @return     Event
   */
  public static function retrieveById($id)
  {
    $c = new Criteria();
    $c->add(EventPeer::ID, $id);
    $event = EventPeer::doSelectOne( $c );

    return isset($event) ? $event : null;
  }
  
  /**
   * Update a single event by Id.
   *
   * @param      int $params
   * @return     Event
   */
  public static function updateEvent( $params, $user )
  {
    $c = new Criteria();
    $c->add(EventPeer::ID, $params['id']);
    $event = EventPeer::doSelectOne( $c );

    if (isset($event)) {
      $event->setName( $params['event_name'] );
      $event->setDate(strtotime($params['event_date']) );
      $event->setTime($params['event_time']);
      $event->setLocationName($params['event_location'] );
      $event->setLocation($params['event_location'] );
      //$event->setLocationName(SiteDataPeer::getLocationName( $params['event_location'] ) );
      $event->setUpdatedBy($user);
      $event->save();
    }
    
    return $event;
  }
  
}
// 3 FUN
// 4 PRO
// 5 BAL
// 6 FUL
// 7 SYN
// 156 Co-Active Sales
// 173 Co-Active Marketing
// 171 Exec Coaching
// 172 Bigger Game
// 148 Relationship Agility Hybrid (we don't need to include RA that we're offering corporately, ie Alliance Data - we want to include hybrids like Vancouver and  DC)
// 159 Ambassador events 
// 150, 157 Pathways
// 145 Conferences where we have a booth or are speaking
// ??? Community events