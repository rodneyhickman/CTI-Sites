<?php

class FeedbackPeer extends BaseFeedbackPeer
{

  public static function SearchPager( $query, $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();

    if($query != ''){
      $c->add(FeedbackPeer::VALUE, '%'.$query.'%', Criteria::LIKE);
      // $c->add(ProfilePeer::NAME, $query, Criteria::LIKE);
    }
    else {
      $c->add(FeedbackPeer::ID, 0, Criteria::GREATER_THAN);
    }
  
    $pager = new sfPropelPager( 'Feedback', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }


}
