<?php

require 'lib/model/om/BasePodPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pod' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Jul 20 17:57:23 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PodPeer extends BasePodPeer {

  public static function CurrentPods( $loc ){
        // return all future pods and pods started less than two weeks ago
    $c = new Criteria();

    if( $loc == 'all' ){
      // no extra criteria
      $c->add(PodPeer::NAME, 'Unassigned', Criteria::NOT_EQUAL);
    }

    //$c->add(PodPeer::RETREAT1_DATE, date('Y-m-d', strtotime('2 weeks ago')), Criteria::GREATER_EQUAL);
    $c->addAscendingOrderByColumn(PodPeer::START_DATE);

    $pods = PodPeer::doSelect($c);
    return $pods;

  }

  public static function GetUnassignedPodId() {
    $c = new Criteria();
    $c->add(PodPeer::NAME, 'Unassigned'); 
    $pod = PodPeer::doSelectOne($c);
    if(isset($pod)){
      return $pod->getId();
    }
    return 0;
  }

} // PodPeer
