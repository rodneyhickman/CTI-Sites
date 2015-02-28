<?php
  // AnswerSetPeer is not a Propel model

  //class AnswerSetPeer extends BaseAnswerSetPeer
class AnswerSetPeer
{
  public static function saveAnswers( $profile, $survey, $answers ){
    $profile_group_id = 3; // default profile_group_id
    $answer_set = null;
    $random_key = commonTools::randomKey();

    if(isset($profile)){
      // loop through answers and save them in Answer table
      foreach($answers as $q_number => $answer){
        $answer_record = new Answer();
        $answer_record->setProfileId( $profile->getId() );
        $answer_record->setProfileGroupId( $profile_group_id );
        $answer_record->setQuestionId( $survey->getQuestionFromQNumber( $q_number ) );
        $answer_record->setResponse( $answer );
        $answer_record->setRandomKey( $random_key );
        $answer_record->save();
      }

    }
    return $answer_set;
  }

//#819 START
public static function retrieveArchiveBySurvey( $survey_id, $alpha_sort ){
    // NOTE: many concepts are abstracted, such as which question contains the leader, which question is unique, etc. 
    // Read the following code carefully

    $leaders     = array( );

    $survey = SurveyPeer::retrieveByPk( $survey_id );
	
    if(isset($survey)){
      $leader_question_number = $survey->getLeaderQuestionNumber();
      $unique_question_number = $survey->getUniqueQuestionNumber();
      $unique_type            = $survey->getUniqueType();
 
      // get answers for this question
      $c = new Criteria();
      $c->add(ArchivePeer::QUESTION_ID, $leader_question_number );

      $c->addDescendingOrderByColumn(ArchivePeer::UPDATED_AT); // ensures that latest will be saved first in $unique_keys
 
      $answers = ArchivePeer::doSelect( $c );
	  
		 //print_r($c);exit;
      // loop through answers and collect the answer set 
      foreach($answers as $answer){
        $answer_set_key = $answer->getRandomKey(); // identifies an answer set

        // find leader from this answer set
        $c = new Criteria();
        $c->add(ArchivePeer::QUESTION_ID, $leader_question_number);
        $c->add(ArchivePeer::EXTRA1, $answer_set_key );
        $leader_answer = ArchivePeer::doSelectOne( $c );
        $leader_name = $leader_answer->getResponse();
        //$leader_name = AnswerSetPeer::normalizeLeaderName( $leader_answer->getResponse() );

        if($leader_name != ''){

          if(!array_key_exists($leader_name,$leaders)){
            $leaders[$leader_name] = array( 
              'unique_keys' => array( ), 
              'answer_set_keys' => array( ) 
              );
          }

          // the following code's sole purpose is to make sure that we are not
          // saving duplicate answer sets for the same date (aka unique_question) for this leader

          // find unique question from this answer set
          $c = new Criteria();
          $c->add(ArchivePeer::QUESTION_ID, $unique_question_number);
          $c->add(ArchivePeer::EXTRA1, $answer_set_key );
          $unique_question_answer = ArchivePeer::doSelectOne( $c );
          $unique_response = $unique_question_answer->getResponse();
          if($unique_type == 'date'){
            $unique_key = intval(strtotime($unique_response));   // DATES INTERPRETED HERE... update this to account for 5/17-5/19/2013 format
            // if $unique_key == 0, that means that date was not entered correctly
          }
          else {
            $unique_key = $unique_response;
          }

          if($unique_key != 0 && !array_key_exists($unique_key, $leaders[$leader_name]['unique_keys'])){
            $leaders[$leader_name]['unique_keys'][$unique_key] = 1;     // add this unique key to array
            $leaders[$leader_name]['answer_set_keys'][] = $answer_set_key; // add this answer set key to array
          }
        }
      }
    }

    // remove leaders who have no valid surveys
    foreach($leaders as $leader_name => $value){
      if(count($value['answer_set_keys']) < 1){
        unset($leaders[$leader_name]);
      }
    }

    // change names without certifications (ie. CPCC MCC etc.) and change them
    foreach($leaders as $leader_name => $value){
      // if name does not have comma...
      if(!preg_match('/,/', $leader_name)){
        // change Sam to Samuel
        if(preg_match("/sam house/i",$leader_name)){
          $leader_name = "Samuel House";
        }
        // if name matches another name
        foreach($leaders as $leader_name2 => $value2){
          if($leader_name != $leader_name2 && preg_match("/$leader_name/i",$leader_name2)){
            // transfer answer set keys to leader_name2
            $answer_set_keys = $leaders[$leader_name]['answer_set_keys']; // array
            foreach($answer_set_keys as $answer_set_key){
              $leaders[$leader_name2]['answer_set_keys'][] = $answer_set_key;
            }
            // remove leader_name
            unset($leaders[$leader_name]);
            break;
          }
        }
      }
    }

    // foreach leader, create or update the leader retrieval key
    foreach($leaders as $leader_name => $value){
      $leader_retrieval_key = LeaderPeer::retrieveByName( $leader_name, $survey_id );
      $leaders[$leader_name]['leader_retrieval_key'] = $leader_retrieval_key->getRetrievalKey();
    }

    if($alpha_sort == 1){
      //ksort($leaders);
      uksort($leaders, 'strnatcasecmp');
    }

    return $leaders;
  }
/*#891*/
public static function collateArchiveByLeader( $leader_name, $survey_id ){

 
      // answer set keys for this survey
      $leaders         = AnswerSetPeer::retrieveArchiveBySurvey( $survey_id );
      //print_r($leaders);exit;
      if(array_key_exists($leader_name,$leaders)){
        $leader_array    = $leaders[$leader_name];
        $answer_set_keys = $leader_array['answer_set_keys'];
        
        // collate the answers
        $collated_answers = AnswerSetPeer::collateAnswersArchive( $survey_id, $answer_set_keys );
        
        return $collated_answers;
      }

    return null;
  }

  public static function collateAnswersArchive( $survey_id, $answer_set_keys){
    $collated_answers = array( );

    // get survey
    $survey = SurveyPeer::retrieveByPk( $survey_id );
    $questions = $survey->getQuestionSet();

    // loop through questions
    foreach($questions as $question){
      $answers = array( );

      // loop through keys to get answers for this question

      foreach($answer_set_keys as $key){
        $c = new Criteria();
        $c->add(ArchivePeer::QUESTION_ID, $question['qid']);
        $c->add(ArchivePeer::EXTRA1, $key);
        $answer = ArchivePeer::doSelectOne( $c );

        if(isset($answer)){
          $answers[] = $answer->getResponse();

          // calculate range percentages
        }
      }

      $formmatted_answers = AnswerSetPeer::formatAnswers( $question, $answers );
      $collated_answers[] = array( 'question' => $question, 'answers' => $answers, 'formatted_answers' => $formmatted_answers );
    }

    return $collated_answers; // which also contain the answers
  }
/*#891*/

  public static function retrieveLeadersBySurvey( $survey_id, $alpha_sort ){
    // NOTE: many concepts are abstracted, such as which question contains the leader, which question is unique, etc. 
    // Read the following code carefully

    $leaders     = array( );

    $survey = SurveyPeer::retrieveByPk( $survey_id );
    if(isset($survey)){
      $leader_question_number = $survey->getLeaderQuestionNumber();
      $unique_question_number = $survey->getUniqueQuestionNumber();
      $unique_type            = $survey->getUniqueType();

      // get answers for this question
      $c = new Criteria();
      $c->add(AnswerPeer::QUESTION_ID, $leader_question_number );

      $c->addDescendingOrderByColumn(AnswerPeer::UPDATED_AT); // ensures that latest will be saved first in $unique_keys

      $answers = AnswerPeer::doSelect( $c );

      // loop through answers and collect the answer set 
      foreach($answers as $answer){
        $answer_set_key = $answer->getRandomKey(); // identifies an answer set

        // find leader from this answer set
        $c = new Criteria();
        $c->add(AnswerPeer::QUESTION_ID, $leader_question_number);
        $c->add(AnswerPeer::EXTRA1, $answer_set_key );
        $leader_answer = AnswerPeer::doSelectOne( $c );
        $leader_name = $leader_answer->getResponse();
        //$leader_name = AnswerSetPeer::normalizeLeaderName( $leader_answer->getResponse() );

        if($leader_name != ''){

          if(!array_key_exists($leader_name,$leaders)){
            $leaders[$leader_name] = array( 
              'unique_keys' => array( ), 
              'answer_set_keys' => array( ) 
              );
          }

          // the following code's sole purpose is to make sure that we are not
          // saving duplicate answer sets for the same date (aka unique_question) for this leader

          // find unique question from this answer set
          $c = new Criteria();
          $c->add(AnswerPeer::QUESTION_ID, $unique_question_number);
          $c->add(AnswerPeer::EXTRA1, $answer_set_key );
          $unique_question_answer = AnswerPeer::doSelectOne( $c );
          $unique_response = $unique_question_answer->getResponse();
          if($unique_type == 'date'){
            $unique_key = intval(strtotime($unique_response));   // DATES INTERPRETED HERE... update this to account for 5/17-5/19/2013 format
            // if $unique_key == 0, that means that date was not entered correctly
          }
          else {
            $unique_key = $unique_response;
          }

          if($unique_key != 0 && !array_key_exists($unique_key, $leaders[$leader_name]['unique_keys'])){
            $leaders[$leader_name]['unique_keys'][$unique_key] = 1;     // add this unique key to array
            $leaders[$leader_name]['answer_set_keys'][] = $answer_set_key; // add this answer set key to array
          }
        }
      }
    }

    // remove leaders who have no valid surveys
    foreach($leaders as $leader_name => $value){
      if(count($value['answer_set_keys']) < 1){
        unset($leaders[$leader_name]);
      }
    }

    // change names without certifications (ie. CPCC MCC etc.) and change them
    foreach($leaders as $leader_name => $value){
      // if name does not have comma...
      if(!preg_match('/,/', $leader_name)){
        // change Sam to Samuel
        if(preg_match("/sam house/i",$leader_name)){
          $leader_name = "Samuel House";
        }
        // if name matches another name
        foreach($leaders as $leader_name2 => $value2){
          if($leader_name != $leader_name2 && preg_match("/$leader_name/i",$leader_name2)){
            // transfer answer set keys to leader_name2
            $answer_set_keys = $leaders[$leader_name]['answer_set_keys']; // array
            foreach($answer_set_keys as $answer_set_key){
              $leaders[$leader_name2]['answer_set_keys'][] = $answer_set_key;
            }
            // remove leader_name
            unset($leaders[$leader_name]);
            break;
          }
        }
      }
    }

    // foreach leader, create or update the leader retrieval key
    foreach($leaders as $leader_name => $value){
      $leader_retrieval_key = LeaderPeer::retrieveByName( $leader_name, $survey_id );
      $leaders[$leader_name]['leader_retrieval_key'] = $leader_retrieval_key->getRetrievalKey();
    }

    if($alpha_sort == 1){
      //ksort($leaders);
      uksort($leaders, 'strnatcasecmp');
    }

    return $leaders;
  }
  



  public static function collateAnswersByLeader( $leader_name, $survey_id ){


      // answer set keys for this survey
      $leaders         = AnswerSetPeer::retrieveLeadersBySurvey( $survey_id );
      
      if(array_key_exists($leader_name,$leaders)){
        $leader_array    = $leaders[$leader_name];
        $answer_set_keys = $leader_array['answer_set_keys'];
        
        // collate the answers
        $collated_answers = AnswerSetPeer::collateAnswers( $survey_id, $answer_set_keys );
        
        return $collated_answers;
      }

    return null;
  }

  public static function collateAnswers( $survey_id, $answer_set_keys){
    $collated_answers = array( );

    // get survey
    $survey = SurveyPeer::retrieveByPk( $survey_id );
    $questions = $survey->getQuestionSet();

    // loop through questions
    foreach($questions as $question){
      $answers = array( );

      // loop through keys to get answers for this question
      foreach($answer_set_keys as $key){
        $c = new Criteria();
        $c->add(AnswerPeer::QUESTION_ID, $question['qid']);
        $c->add(AnswerPeer::EXTRA1, $key);
        $answer = AnswerPeer::doSelectOne( $c );

        if(isset($answer)){
          $answers[] = $answer->getResponse();

          // calculate range percentages
        }
      }

      $formmatted_answers = AnswerSetPeer::formatAnswers( $question, $answers );
      $collated_answers[] = array( 'question' => $question, 'answers' => $answers, 'formatted_answers' => $formmatted_answers );
    }

    return $collated_answers; // which also contain the answers
  }

  public static function formatAnswers( $question, $answers ){

    // if question is first or last name, just report number of answers
    // if(preg_match('/(first|last).*name/i',$question['heading'])){
    //   if(count($answers) == 1){
    //     return '<p>1 Response</p>';
    //   }
    //   return count($answers).' Responses';
    // }

    // if question is range, collate the range and publish as table
    if($question['is_range'] == 'yes'){
      $html = '';
      $temp_array = array( );

      // get original HTML
      $content = $question['content'];

      // split HTML into divs and get indicies
      $min = 0;
      $max = 0;
      $regexp = '<div.*>(.*)<\/div>';
      if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) { // match across line breaks (s), case-insensitive (i), ungreedy (U)
        foreach($matches as $match){
          $index_text = preg_replace('/<[^>]*>/',' ',$match[1]);
          $value = intval(preg_replace('/[^\d]*(\d+).*/','$1',$index_text));
          if($value < $min){
            $min = $value;
          }
          if($value > $max){
            $max = $value;
          }

            $temp_array[ $value ] = array( 'text' => $index_text, 'count' => 0, 'percentage' => 0 );

        }
      }

      

      // iterate over answers and count them
      foreach($answers as $answer){
        $temp_array[ $answer ]['count'] += 1;
      }
      
      // calculate percentages and format the HTML
      $html .= '<table>';
      for($i = $min; $i <= $max; $i++){
        if(preg_match("/\w/",$temp_array[$i]['text'])){ // create row only if there is text T. Beutel 1/3/12
          $temp_array[$i]['percentage'] = round(100.0 * ( $temp_array[$i]['count'] / count($answers) ) );
          $html .= '<tr><td style="width:80%">'.$temp_array[$i]['text'].'&nbsp;</td><td>'.$temp_array[$i]['count'].'</td><td>'.$temp_array[$i]['percentage'].'%</td></tr>';
        }
      }
      $html .= '</table>';

      return $html;
    }

    // if question is textarea or input, list the answers in a table
    $html = '<table>';
    foreach($answers as $answer){
      $html .= '<tr><td>'.$answer.'</td></tr>';
    }
    $html .='</table>';
    return $html;

  }

  public static function normalizeLeaderName( $name ){
    return $name;
  }
}

