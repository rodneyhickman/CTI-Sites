<?php

class Group extends BaseGroup
{


  public function getDisplayName(){
    if($this->getName() != ''){
      return $this->getName();
    }
    return $this->getStartDate();
  }

  public function getStartDateFormatted(){
    $time = strtotime( $this->getStartDate() );
    $date_formatted = Date('F j, Y',$time);
    return $date_formatted;
  }


  public function getCurrentWeek(){
    // gets current week starting date, based on this groups starting date

    $starting_week    = $this->getStartDate();
    if( strtotime($starting_week) > time() ){  // if starting date greater than today, use it.
      return $starting_week;
    }

    $starting_weekday = date('w', strtotime($starting_week) );  
    $starting_weekday = $starting_weekday + 1; // make it the day after - example: thursday
    if($starting_weekday > 6){
      $starting_weekday = $starting_weekday - 7; // subtract a week
    }

    $todays_weekday   = date('w', time() );  // example: wednesday

    // get difference in day of week
    $diff = $todays_weekday-$starting_weekday;   // example: 3 - 4 = -1
    if($diff<0){ $diff += 7; }                   // example: 6

    // calculate the current week that starts on the $starting_weekday 
    $current_week_time = time() - ($diff*86400);  // example: now - 6 * 86400, eg last thursday
    $current_week = date('Y-m-d',$current_week_time);

    return $current_week;
  }

  public function getHomework(){


    // returns:
    // array( participants => array( 'name', columns => ( 'column_name', ... ) )
    
    // get profiles, in name order, for this group
    $c = new Criteria();
    $c->add(ProfilePeer::NAME, null, Criteria::ISNOTNULL);
    $c->add(HomeworkPeer::GROUP_ID, $this->getId() );
    $c->addJoin(ProfilePeer::ID, HomeworkPeer::PROFILE_ID);
    $c->addAscendingOrderByColumn(ProfilePeer::NAME);
    $c->setDistinct(true); 
    $profiles = ProfilePeer::doSelect( $c );

    // get weeks of completed homework for this group 
    $weeks = $this->getHomeworkWeeks();
    $columns = array( 'Total Clients'=>'getTotalClients', 
                      'S.S.<br/>Commit'=>'getSsCommit', 
                      'S.S<br/>Done'=>'getSsCompleted',
                      'Clients<br/>Commit'=>'getClientsCommit',
                      'Clients<br/>Done'=>'getClientsCompleted',
                      '#100<br />Commit'=>'getPointsCommit',
                      '#100<br />Earned'=>'getPointsEarned' );

    $group_homework = array( );

    foreach($profiles as $profile){
      $row = array( 'name' => $profile->getName(), 'columns' => array( ) );
      $row['columns'][] = array( 'Program<br/>Goal', Group::shortenForPopup($profile->getProgramGoal()) );
      foreach($weeks as $week){
        // get homework for this group id, profile and week
        $c = new Criteria();
        $c->add(HomeworkPeer::GROUP_ID, $this->getId() );
        $c->add(HomeworkPeer::PROFILE_ID, $profile->getId() );
        $c->add(HomeworkPeer::WEEK_STARTING, $week );
        $homework = HomeworkPeer::doSelectOne( $c );
        

        foreach($columns as $key => $value){
          if(isset($homework)){
            $cell_value = '';
            eval('$cell_value = $homework->'.$value.'();');
            if($key == 'Total Clients'){
              $row['columns'][] = array( $week .':<br/>'. $key, '<a  style="text-decoration:none;color:#00a;" href="'.sfContext::getInstance()->getController()->genUrl('admin/addHomework').'?gid='.$this->getId().'&pid='.$profile->getId().'&w='.$week.'">'.$cell_value.'&nbsp;&nbsp;&#8230;</a>' );
            }
            else {
              $row['columns'][] = array( $key, $cell_value );
            }
          }
          else { // for case where this profile did not do homework this week
            if($key == 'Total Clients'){
              $row['columns'][] = array( $week .':<br/>'. $key, '<a  style="font-size:9px;text-decoration:none;color:#00a;" href="'.sfContext::getInstance()->getController()->genUrl('admin/addHomework').'?gid='.$this->getId().'&pid='.$profile->getId().'&w='.$week.'">Add&#8230;</a>' );
            }
            else {
              $row['columns'][] = array( $key, '' ); 
            }
          }
        }
      }
      $group_homework[] = $row;
    }

    return $group_homework;
  }


  public function getHomeworkCSV(){
    // returns CSV text
    $group_homework = $this->getHomework();

    $homework_csv = array( );

    $header_row = array( );
    $header_row[] = 'Participants';

    // header row (grab headers from first participant)
    foreach($group_homework as $row){
      $columns = $row['columns'];
      foreach($columns as $column){
        $header_row[] = preg_replace('/<br\s*\/>/','',$column[0]);
      }
      break;
    }

    $homework_csv[] = $header_row;

    // loop through array and remove breaks <br/>
    foreach($group_homework as $row){
      $columns  = $row['columns'];
      $data_row = array( );
      $data_row[] = $row['name'];

      foreach($columns as $column){
        $data_row[] = preg_replace('/<br\s*\/>/','',$column[1]);
      }
      $homework_csv[] = $data_row;
    }


    return $homework_csv;
  }


  public function getHomeworkWeeks(){
    $c = new Criteria();
    $c->add(HomeworkPeer::GROUP_ID, $this->getId() );
    $c->addAscendingOrderByColumn(HomeworkPeer::WEEK_STARTING);
    $homeworks = HomeworkPeer::doSelect( $c );

    $weeks = array( );
    foreach($homeworks as $homework){
      $weeks[] = $homework->getWeekStarting();
    }

    $weeks = array_unique( $weeks );
    return $weeks;
  }


  public static function shortenForPopup( $string ){
    if($string != ''){
      $string = preg_replace('/"/','',$string);
      $output = substr($string,0,7);
      return '<a href="#" class="tooltip" style="text-decoration:none;" title="'.$string.'"><span style="font-size:9px">'.$output.'&#8230;</span></a>';
    }
  }
}
