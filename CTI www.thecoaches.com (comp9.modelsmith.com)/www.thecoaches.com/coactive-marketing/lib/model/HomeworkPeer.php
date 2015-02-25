<?php

class HomeworkPeer extends BaseHomeworkPeer
{
  
  public static function retrieveCurrentByProfile( $profile_id ){
    $group = GroupPeer::currentGroup(); // current group
    $week  = $group->getCurrentWeek();  // current week starting date

    $c = new Criteria();
    $c->add(HomeworkPeer::PROFILE_ID, $profile_id);
    $c->add(HomeworkPeer::WEEK_STARTING, $week);
    $homework = HomeworkPeer::doSelectOne( $c );

    // create new record if necessary
    if(!isset($homework)){
      $homework = new Homework();
      $homework->setProfileId( $profile_id );
      $homework->setGroupId( $group->getId() );
      $homework->setWeekStarting( $week );
      $homework->save();
    }

    return $homework;
  } 

  public static function retrieveByProfile( $profile_id, $group_id, $week ){

    // check to see if this homework exists...
    $c = new Criteria();
    $c->add(HomeworkPeer::PROFILE_ID, $profile_id);
    $c->add(HomeworkPeer::GROUP_ID, $group_id);
    $c->add(HomeworkPeer::WEEK_STARTING, $week);
    $homework = HomeworkPeer::doSelectOne( $c );

    // if not, create it
    if(!isset($homework)){
      $homework = new Homework();
      $homework->setProfileId( $profile_id );
      $homework->setGroupId( $group_id );
      $homework->setWeekStarting( $week );
      $homework->save();
    }

    return $homework;
  }

  public static function csvReportByGroup( $group_id ){
    return '';
  }

  public static function reportByGroup( $group_id ){
    return '';
  }


// T. Beutel added 12/26/12
  public static function register( $profile_id, $group_id ){
    $homework = null;

    $group = GroupPeer::retrieveByPk( $group_id );
    if($group){
      $week = $group->getStartDate();

      $homework = new Homework();
      $homework->setProfileId( $profile_id );
      $homework->setGroupId( $group_id );
      $homework->setWeekStarting( $week );
      $homework->save();
    }
    
    return $homework;
  }

}
