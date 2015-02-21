<?php

class ActivityPeer extends BaseActivityPeer
{

  public static function ContactSearchPager( $query, $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();

    if($query != ''){
      $c->add(ActivityPeer::VALUE, '%'.$query.'%', Criteria::LIKE);
      // $c->add(ProfilePeer::NAME, $query, Criteria::LIKE);
    }
    else {
      $c->add(ActivityPeer::DECRIPTION, 'first_contact');
    }
  
    $pager = new sfPropelPager( 'Activity', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }


  public static function EngagementPager( $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();

    $c->add(ActivityPeer::DECRIPTION, 'added_client');
    $c->addDescendingOrderByColumn(ActivityPeer::ACTIVITY_DATE);

    // $c1 = $c->getNewCriterion(ActivityPeer::DECRIPTION, 'first_contact');
    // $c2 = $c->getNewCriterion(ActivityPeer::DECRIPTION, 'added_client');
    // $c1->addOr($c2);
    // $c->add($c1);

    $pager = new sfPropelPager( 'Activity', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }



}
