<?php

  // AnswerSet is not a Propel model
  //class AnswerSet extends BaseAnswerSet

class AnswerSet
{
  protected $profile_group;
  protected $survey_id;
  protected $answer_array = array( );

  public function getCollatedAnswers(){
    // collate the answers (including histogram) and return answer_array

    // answer_array = 
    //   array(
    //     id345 => array(
    //       heading   => '...',
    //       content   => '...',
    //       answers   => array( 3, 4, 3, 5, 7, 2 ),  // or text
    //       mean      => 5.2,  // 'na' if not applicable
    //       histogram => array( '1' => 0,
    //                           '2' => 1,
    //                           '3' => 2,
    //                           '4' => 1 )
  }

  public function getAnswerArray( $question, $profile_group ){
    // collate answers for this question


  }

  public function getHistogram( $answers ){

  }

  public function getMean( $question ){

  }

 
  
}
