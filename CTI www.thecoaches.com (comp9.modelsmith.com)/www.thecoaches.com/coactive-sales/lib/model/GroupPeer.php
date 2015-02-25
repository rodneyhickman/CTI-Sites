<?php

class GroupPeer extends BaseGroupPeer
{

  public static function currentGroup(){
    // get most recent group
    $c = new Criteria();
    $c->addDescendingOrderByColumn(GroupPeer::START_DATE);  // start with group furthest in the future
    $groups = GroupPeer::doSelect( $c );

// T. Beutel added 12/26/12
    $now = time();
    foreach($groups as $candidate){
      $group = $candidate;
      if(strtotime($candidate->getStartDate()) < $now){
        break;
      }
    }
    return $group;
  }

  public static function newGroupFromDate( $date ){
    // $group = new Group();
    // $group->setStartDate( date('Y-m-d',strtotime( $date ) ) );
    // $group->setName( 'The '.date('F j',strtotime( $date ) ).' Group');
    // $group->save();

    // need to do direct SQL because Propel does not quote 'group' -- shouldn't have used 'group' as table name

    $connection = Propel::getConnection();
    if(isset($connection)){
      $query = sprintf( "INSERT INTO `group` (`start_date`,`name`,`created_at`,`updated_at`) values ('%s','%s',NOW(),NOW());", 
                       date('Y-m-d',strtotime( $date ) ),
                       'The '.date('F j',strtotime( $date ) ).' Group' 
      );

      $statement = $connection->prepare($query);
      $p = $statement->execute();
    }

  }

// T. Beutel added 12/26/12
  public static function futureCourses(){ // including courses that started up to two weeks ago
    $c  = new Criteria();
    $c->add(GroupPeer::START_DATE, date('Y-m-d', strtotime('-2 weeks')), Criteria::GREATER_THAN);
    $groups = GroupPeer::doSelect( $c );
    return $groups;
  }
}
