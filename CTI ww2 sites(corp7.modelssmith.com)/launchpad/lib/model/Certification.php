<?php

require 'lib/model/om/BaseCertification.php';


/**
 * Skeleton subclass for representing a row from the 'certification' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Jul 20 17:57:22 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Certification extends BaseCertification {
  public function getDateCoachingBegan(){
    return $this->getExtra1();
  }
  
  public function setDateCoachingBegan($date){
    $this->setExtra1($date); 
    $this->save();
    return;
  }


  public function getPreviouslyRegistered(){
    return $this->getExtra2();
  }
  
  public function setPreviouslyRegistered($data){
    $this->setExtra2($data); 
    $this->save();
    return;
  }

  public function getNewRegistration(){
    return $this->getExtra3();
  }
  
  public function setNewRegistration($data){
    $this->setExtra3($data); 
    $this->save();
    return;
  }

  public function getIndicationOfAgreement(){
    return $this->getExtra4();
  }
  
  public function setIndicationOfAgreement($data){
    $this->setExtra4($data); 
    $this->save();
    return;
  }

  public function getComments(){
    return $this->getExtra5();
  }
  
  public function setComments($data){
    $this->setExtra5($data); 
    $this->save();
    return;
  }

  public function getStartMonthDeclaration(){
    return $this->getExtra6();
  }
  
  public function setStartMonthDeclaration($data){
    $this->setExtra6($data); 
    $this->save();
    return;
  }

  public function isStartMonthDeclarationOnly(){
    $your_certified_coach = $this->getYourCertifiedCoach();
    $start_month_declaration = $this->getStartMonthDeclaration();
    $i_agree = $this->getIndicationOfAgreement();

    if($start_month_declaration == 1 && ($your_certified_coach == '' || $i_agree == '')){
      return true;
    }
    return false;
  }
  


} // Certification