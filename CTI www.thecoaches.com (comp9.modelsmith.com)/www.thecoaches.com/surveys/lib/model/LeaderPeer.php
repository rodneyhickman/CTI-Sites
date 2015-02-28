<?php

class LeaderPeer extends BaseLeaderPeer
{
  public static function retrieveByName( $name, $survey_id ){
    // create is not exists
    $c = new Criteria();
    $c->add(LeaderPeer::NAME, $name );
    $c->add(LeaderPeer::SURVEY_ID, $survey_id );
    $leader = LeaderPeer::doSelectOne( $c );

    if(!isset($leader)){
      $leader = new Leader();
      $leader->setName( $name );
      $leader->setRetrievalKey( commonTools::randomKey() );
      $leader->setSurveyId( $survey_id );
      $leader->save();
    }

    return $leader;
  }

  public static function retrieveByKey( $key, $survey_id ){
    $c = new Criteria();
    $c->add(LeaderPeer::RETRIEVAL_KEY, $key );
    $c->add(LeaderPeer::SURVEY_ID, $survey_id );
    $leader = LeaderPeer::doSelectOne( $c );
    return $leader;
  }

}
