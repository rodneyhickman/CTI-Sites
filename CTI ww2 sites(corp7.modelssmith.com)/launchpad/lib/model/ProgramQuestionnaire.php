<?php

require 'lib/model/om/BaseProgramQuestionnaire.php';


/**
 * Skeleton subclass for representing a row from the 'program_questionnaire' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Apr 13 02:34:43 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ProgramQuestionnaire extends BaseProgramQuestionnaire {

  public function getFriend(){
    return $this->getExtra3();
  }
  public function getFriend_CR(){
    $list = preg_split( "/[,:]/",$this->getExtra3() );
    return implode(", ",$list);
  }
  public function setFriend( $name ){
    $this->setExtra3( $name );
    $this->save();
    return;
  }

  public function getCTIFacultyMember(){
    return $this->getExtra4();
  }
  public function getCTIFacultyMember_CR(){
    $list = preg_split( "/[,:]/",$this->getExtra4() );
    return implode(", ",$list);
  }
  public function setCTIFacultyMember( $name ){
    $this->setExtra4( $name );
    $this->save();
    return;
  }

  public function getProgramAdvisor(){
    return $this->getExtra5();
  }
  public function getProgramAdvisor_CR(){
    $list = preg_split( "/[,:]/",$this->getExtra5() );
    return implode(", ",$list);
  }
  public function setProgramAdvisor( $name ){
    $this->setExtra5( $name );
    $this->save();
    return;
  }

  public function getOtherInfluence(){
    return $this->getExtra6();
  }
  public function getOtherInfluence_CR(){
    $list = preg_split( "/[,:]/",$this->getExtra6() );
    return implode(", ",$list);
  }
  public function setOtherInfluence( $name ){
    $this->setExtra6( $name );
    $this->save();
    return;
  }


  public function getFriend1(){
    $list = explode( ":",$this->getExtra3() );
    return $list[0];
  }
  public function getCTIFacultyMember1(){
    $list = explode( ":",$this->getExtra4() );
    return $list[0];
  }
  public function getProgramAdvisor1(){
    $list = explode( ":",$this->getExtra5() );
    return $list[0];
  }
  public function getOtherInfluence1(){
    $list = explode( ":",$this->getExtra6() );
    return $list[0];
  }

  public function getFriend2(){
    $list = explode( ":",$this->getExtra3() );
    return $list[1];
  }
  public function getCTIFacultyMember2(){
    $list = explode( ":",$this->getExtra4() );
    return $list[1];
  }
  public function getProgramAdvisor2(){
    $list = explode( ":",$this->getExtra5() );
    return $list[1];
  }
  public function getOtherInfluence2(){
    $list = explode( ":",$this->getExtra6() );
    return $list[1];
  }

  public function getFriend3(){
    $list = explode( ":",$this->getExtra3() );
    return $list[2];
  }
  public function getCTIFacultyMember3(){
    $list = explode( ":",$this->getExtra4() );
    return $list[2];
  }
  public function getProgramAdvisor3(){
    $list = explode( ":",$this->getExtra5() );
    return $list[2];
  }
  public function getOtherInfluence3(){
    $list = explode( ":",$this->getExtra6() );
    return $list[2];
  }

  public function getFriend4(){
    $list = explode( ":",$this->getExtra3() );
    return $list[3];
  }
  public function getCTIFacultyMember4(){
    $list = explode( ":",$this->getExtra4() );
    return $list[3];
  }
  public function getProgramAdvisor4(){
    $list = explode( ":",$this->getExtra5() );
    return $list[3];
  }
  public function getOtherInfluence4(){
    $list = explode( ":",$this->getExtra6() );
    return $list[3];
  }




// ============================================
// Leadership Assistant questionnaire overloads
// All are prepended with LA

  public function getLAGraduationTribe(){
    return $this->getExtra1();
  }
  public function setLAGraduationTribe( $text ){
    $this->setExtra1( $text );
    $this->save();
    return;
  }

  public function getLACompletionDate(){
    return $this->getExtra2();
  }
  public function setLACompletionDate( $text ){
    $this->setExtra2( $text );
    $this->save();
    return;
  }

  public function getLALeader1(){
    return $this->getExtra3();
  }
  public function setLALeader1( $text ){
    $this->setExtra3( $text );
    $this->save();
    return;
  }

  public function getLALeader2(){
    return $this->getExtra4();
  }
  public function setLALeader2( $text ){
    $this->setExtra4( $text );
    $this->save();
    return;
  }

  public function getLASoulType(){
    return $this->getExtra5();
  }
  public function setLASoulType( $text ){
    $this->setExtra5( $text );
    $this->save();
    return;
  }

  public function getLAMisc(){
    return $this->getExtra5();
  }
  public function setLAMisc( $text ){
    $this->setExtra5( $text );
    $this->save();
    return;
  }

  public function getLAIAmType(){
    return $this->getExtra6();
  }
  public function setLAIAmType( $text ){
    $this->setExtra6( $text );
    $this->save();
    return;
  }

  public function getLACPR(){
    return $this->getExtra6();
  }
  public function setLACPR( $text ){
    $this->setExtra6( $text );
    $this->save();
    return;
  }


  public function getLAImpact(){
    return $this->getExtra7();
  }
  public function setLAImpact( $text ){
    $this->setExtra7( $text );
    $this->save();
    return;
  }

  public function getLAWhatPromptedYou(){
    return $this->getExtra8();
  }
  public function setLAWhatPromptedYou( $text ){
    $this->setExtra8( $text );
    $this->save();
    return;
  }

  public function getLAExperience(){
    return $this->getExtra9();
  }
  public function setLAExperience( $text ){
    $this->setExtra9( $text );
    $this->save();
    return;
  }

  public function getLAStak(){
    return $this->getExtra10();
  }
  public function setLAStak( $text ){
    $this->setExtra10( $text );
    $this->save();
    return;
  }

  public function getLASpace(){
    return $this->getExtra10();
  }
  public function setLASpace( $text ){
    $this->setExtra10( $text );
    $this->save();
    return;
  }

  public function getLAWantToGain(){
    return $this->getExtra11();
  }
  public function setLAWantToGain( $text ){
    $this->setExtra11( $text );
    $this->save();
    return;
  }

  public function getLACommit(){
    return $this->getExtra12();
  }
  public function setLACommit( $text ){
    $this->setExtra12( $text );
    $this->save();
    return;
  }

  public function getLALifeImpact(){
    return $this->getExtra13();
  }
  public function setLALifeImpact( $text ){
    $this->setExtra13( $text );
    $this->save();
    return;
  }

  public function getLAAnticipate(){
    return $this->getExtra14();
  }
  public function setLAAnticipate( $text ){
    $this->setExtra14( $text );
    $this->save();
    return;
  }

  public function getLAChallenge(){
    return $this->getExtra15();
  }
  public function setLAChallenge( $text ){
    $this->setExtra15( $text );
    $this->save();
    return;
  }

  public function getLAStay(){
    return $this->getExtra16();
  }
  public function setLAStay( $text ){
    $this->setExtra16( $text );
    $this->save();
    return;
  }

  public function getLASelfManagement(){
    return $this->getExtra17();
  }
  public function setLASelfManagement( $text ){
    $this->setExtra17( $text );
    $this->save();
    return;
  }

  public function getLAExpectationsLeaders(){
    return $this->getExtra18();
  }
  public function setLAExpectationsLeaders( $text ){
    $this->setExtra18( $text );
    $this->save();
    return;
  }

  public function getLACoAssistantExpectations(){
    return $this->getExtra19();
  }
  public function setLACoAssistantExpectations( $text ){
    $this->setExtra19( $text );
    $this->save();
    return;
  }

  public function getLADisappointing(){
    return $this->getExtra20();
  }
  public function setLADisappointing( $text ){
    $this->setExtra20( $text );
    $this->save();
    return;
  }

  public function getLALeadersCountOn(){
    return $this->getNationality();
  }
  public function setLALeadersCountOn( $text ){
    $this->setNationality( $text );
    $this->save();
    return;
  }

  public function getLAParticipantCountOn(){
    return $this->getRelationshipStatus();
  }
  public function setLAParticipantCountOn( $text ){
    $this->setRelationshipStatus( $text );
    $this->save();
    return;
  }

  public function getLAAssistantCountOn(){
    //return $this->getRelationshipStatus();
    return '';
  }
  //public function setLAAssistantCountOn( $text ){
  //  $this->setRelationshipStatus( $text );
  //  $this->save();
  //  return;
  //}


  public function getLACallForth(){
    return $this->getCurrentProfession();
  }
  public function setLACallForth( $text ){
    $this->setCurrentProfession( $text );
    $this->save();
    return;
  }

  public function getLARopesLimitations(){
    return $this->getPastProfession();
  }
  public function setLARopesLimitations( $text ){
    $this->setPastProfession( $text );
    $this->save();
    return;
  }

  public function getLAExplainRopesLimitations(){
    return $this->getStrengths();
  }
  public function setLAExplainRopesLimitations( $text ){
    $this->setStrengths( $text );
    $this->save();
    return;
  }

  public function getLAOtherLimitations(){
    return $this->getHoldsYouBack();
  }
  public function setLAOtherLimitations( $text ){
    $this->setHoldsYouBack( $text );
    $this->save();
    return;
  }

  public function getLAExplainOtherLimitations(){
    return $this->getHandleFailing();
  }
  public function setLAExplainOtherLimitations( $text ){
    $this->setHandleFailing( $text );
    $this->save();
    return;
  }

  public function getLATransportation(){
    return $this->getWillingToFail();
  }
  public function setLATransportation( $text ){
    $this->setWillingToFail( $text );
    $this->save();
    return;
  }

  public function getLAAnythingElse(){
    return $this->getWillingToListen();
  }
  public function setLAAnythingElse( $text ){
    $this->setWillingToListen( $text );
    $this->save();
    return;
  }

  public function __call($name, $arguments) {
    // Note: value of $name is case sensitive.
    // ProgramQuestionnaire.php getXXX__ function (the underscore indicates that it is the extended version. I couldn't think of something more clever.)
    // The purpose of this is as follows:
    // - A single MySQL record cannot store more than 8000 characters combined for all fields in that record
    // - Many applicants to leadership will write responses that are more than 8000 in aggregate
    // - This uses a separate record if the number of characters is greater than 320
    // Note that Pod.php is used to store these fields because it was determined that Pods are no longer necessary, so the table was unused.
    // The following fields are used in Pod.php:
    // name: 'pq_field'
    // extra1: pq_id
    // extra2: fieldName
    // extra3: value
    // General notes: obviously, it was an error in both programming and database setup not to know that responses could exceed 8000 characters. This
    // by necessity is a kludge, and does not represent best programming practice. Thomas Beutel Sept 5, 2011

    // ==== getXXX__() ====
    if( preg_match('/^get(.*)__/', $name, $matches) ){
      $field = $matches[1];
      $value = '';
      // first check to see if regular field is not blank
      eval("\$value = \$this->get".$field."();"); 
      if($value == ''){ // if value blank, see if it in Pod table
        $c = new Criteria();
        $c->add(PodPeer::NAME,   'pq_field');
        $c->add(PodPeer::EXTRA1, $this->getId() );
        $c->add(PodPeer::EXTRA2, $field);
        $pq_field = PodPeer::doSelectOne( $c );

        if(isset($pq_field)){
          $value = $pq_field->getExtra3();
        }
      }
      return trim($value); // trim leading and following whitespace
    }
    // ==== setXXX__() ====
    else if( preg_match('/^set(.*)__/', $name, $matches) ){
      $field = $matches[1];
      $value = $arguments[0]; // the value
      if(strlen($value) > 320){
        // clear value in PQ table
        eval("\$this->set".$field."('');");

        // store in Pod table
        $c = new Criteria();
        $c->add(PodPeer::NAME,   'pq_field');
        $c->add(PodPeer::EXTRA1, $this->getId() );
        $c->add(PodPeer::EXTRA2, $field);
        $pq_field = PodPeer::doSelectOne( $c );

        if(!isset($pq_field)){
          $pq_field = new Pod();
          $pq_field->setName( 'pq_field' );
          $pq_field->setExtra1( $this->getId() );
          $pq_field->setExtra2( $field );
        }
        $pq_field->setExtra3( $value );
        $pq_field->save();
      }
      else {
        eval("\$this->set".$field."(\$value);");
      }
      // assumption: $this->save() is performed after this call
    }
    else {  // fatal error if function name does not contain "get" or "set"
      exit("lib/model/ProgramQuestionnaire.php error: $name function not found");
    }
  }

} // ProgramQuestionnaire