<?php

require 'lib/model/om/BaseFlexformSubmissionPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'flexform_submission' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Tue May 21 23:14:40 2013
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class FlexformSubmissionPeer extends BaseFlexformSubmissionPeer {

  public static function retrieveByKey( $name ){
    $c = new Criteria();
    $c->add(FlexformSubmissionPeer::EXTRA1, $name);
    $flexform_submission = FlexformSubmissionPeer::doSelectOne( $c );
    return $flexform_submission;
  }

  public static function retrieveByProfileId( $profile_id ){
    $c = new Criteria();
    $c->add(FlexformSubmissionPeer::PROFILE_ID, $profile_id);
    $flexform_submission = FlexformSubmissionPeer::doSelectOne( $c );
    return $flexform_submission;
  }
  public static function getSubmission( $user, $flexform ){
    $c = new Criteria();
    $c->add(FlexformSubmissionPeer::PROFILE_ID, $user->getProfileId() );
    $c->add(FlexformSubmissionPeer::FLEXFORM_ID, $flexform->getId() );
    $flexform_submission = FlexformSubmissionPeer::doSelectOne( $c );
    if( ! isset( $flexform_submission ) ){
      $flexform_submission = new FlexformSubmission();
      $flexform_submission->setProfileId( $user->getProfileId() );
      $flexform_submission->setFlexformId( $flexform->getId() );
      $flexform_submission->setKey( $flexform->getKey() );
      $flexform_submission->save();

      FlexformAnswerPeer::initializeAnswers( $flexform_submission );
    }

    return $flexform_submission;
  }

  public static function getMostRecentFORL( $profile_id ){
    $c = new Criteria();
    $c->add(FlexformSubmissionPeer::PROFILE_ID, $profile_id);
    $c->add(FlexformSubmissionPeer::EXTRA1, 'FORL');
    $c->addDescendingOrderByColumn(FlexformSubmissionPeer::ID);
    $flexform_submission = FlexformSubmissionPeer::doSelectOne( $c );
    return $flexform_submission;
  }

} // FlexformSubmissionPeer