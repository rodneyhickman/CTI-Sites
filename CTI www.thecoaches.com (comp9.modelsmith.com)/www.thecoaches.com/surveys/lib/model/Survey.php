<?php

class Survey extends BaseSurvey
{
  protected $q_map = array( );

  public function getLeaderQuestionNumber(){
    return $this->getExtra1();
  }
  public function getUniqueQuestionNumber(){ // identifies which question in survey is unique (eg. Course Date)
    return $this->getExtra2();
  }
  public function getUniqueType(){ // identifies the type of the unique question (eg. text, date, number)
    return $this->getExtra3();
  }
  

  public function getQuestionSet() {
    // returns array:
    // array( 
    //   array( heading => '...', content => '...' ),
    //   array( heading => '...', content => '...' ),
    //   ...
    // )

    $question_array = array( );

    $c = new Criteria();
    $c->add( QuestionPeer::SURVEY_ID, $this->getId() );
    $questions = QuestionPeer::doSelect( $c );


    if(isset($questions)){

      // get a map of record ids
      $next  = array( );
      $index = array( );
      $last  = -1;
      foreach($questions as $i => $q){
        $index[ $q->getId() ]    = $i; // save index
        $next[ $q->getNextId() ] = $q->getId(); // save next_id reference
        if( $q->getNextId() == 0 ){
          $last = $i; // index of last question
        }
      }

      // unshift questions onto array
      $prev  = $last;
      $count = 0;
      while($count < count($questions) ){
        $question = $questions[ $prev ];
        array_unshift($question_array, array( 'heading' => $question->getHeading(), 'content' => $question->getContent(), 'qid' => $question->getId(), 'is_range' => $question->getIsRange()  ) );
        if( array_key_exists( $question->getId(), $next ) ){
          $prev = $index[ $next[ $question->getId() ] ];
        }
        $count++;
      }

    }

    return $question_array;
  }

  public function getQuestionFromQNumber( $q_number ){
    // returns question id 
    if(!isset($this->q_map) || count($this->q_map) == 0){
      // get q numbers and cache them
      $c = new Criteria();
      $c->add(QuestionPeer::SURVEY_ID, $this->getId() );
      $questions = QuestionPeer::doSelect( $c );
      
      if(isset($questions)){
        foreach($questions as $q){
          $this->q_map[$q->getQNumber()] = $q->getId();
        }
      }
    }
    return $this->q_map[$q_number];
  }

  public function collateByName( $leader_name ){
    // collate survey answers for this survey by leader name
    // NOTE: names are matched without trailing CPCC, etc.

    // figure out which survey question is leader_name

    // get answer set for just those surveys for leader_name

  }
}
