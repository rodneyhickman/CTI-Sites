<?php

require 'lib/model/om/BaseFlexformQuestionPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'flexform_question' table.
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
class FlexformQuestionPeer extends BaseFlexformQuestionPeer {

  public static function newFromArray( $flexform, $question  ){ // recursive function

    $label     = $question['label'];
    $number    = null;
    if(preg_match('/^\s*(\d+)/',$label,$matches)){
      $number = $matches[1];
    }
    $css_class = $question['class'];

    $param_name = commonTools::createParamName( $label,27 );

    for($param_count = 1; $param_count <= 10; $param_count++){
      $c = new Criteria();
      $c->add(FlexformQuestionPeer::FLEXFORM_ID, $flexform->getId() );
      $c->add(FlexformQuestionPeer::PARAM_NAME, $param_name);
      $other = FlexformQuestionPeer::doSelectOne( $c );
      if( ! isset($other)){
        break;
      }
      $param_name = commonTools::createParamName( $label,27 ).'_'.$param_count;
    }

    $type = $question['type'];
      
    $flexform_question = new FlexformQuestion();
    $flexform_question->setFlexformId( $flexform->getId() );
    $flexform_question->setType($type);
    $flexform_question->setLabel($label);
    $flexform_question->setNumber($number);
    $flexform_question->setCssClass($css_class);
    $flexform_question->setParamName($param_name);
    $flexform_question->setDisplayOrder($flexform->display_order);
    $flexform_question->setOptions('');
    $flexform_question->save();



    $flexform->display_order++;
    
    if(isset($question['questions'])){
      $questions = $question['questions'];
      foreach($questions as $q){
        FlexformQuestionPeer::newFromArray( $flexform, $q  ); // recursive
      }
    }

    return $flexform_question;
  }
  


} // FlexformQuestionPeer