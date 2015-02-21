<?php

class Student extends BaseStudent
{

  // ==================================
  // Eligibility test

  public function isEligibleForProgram() {
    if($this->isFacultyCoach()){
      return true;
    }
    if($this->isCpccCoach()){
      return true;
    }
    if($this->isCertificationStudent()){
      return true;
    }
    return false;
  }


  // ==================================
  // Role tests. Test returns true if student fits the role
  
  public function isFacultyCoach() {
    if($this->getCtiFaculty() == 'x' && $this->getActive() == 1){
      return true;
    }
    return false;
  }

  public function isCpccCoach() {
    if($this->getCpccCertDate('Y') > 1980){
      return true;
    }
    $name = $this->getName();
    if(preg_match('/cpcc/i',$name)){
      return true;
    }
    return false;
  }

  public function isCertificationStudent() {
    // true if taking certification course (cert date undefined, no CPCC in name, cert_courses defined)
    if( ! $this->isCpccCoach() && ! $this->isFacultyCoach() ){
      $cert_courses = $this->getCourseCertification();
      if(preg_match('/cert/i',$cert_courses)){
        return true;
      }
    }
    return false;
  }


  // ==================================
  // Certification classification

# Example of a certification student... 
# - cert date undefined
# - no CPCC in name
# - cert_courses defined
# 

### $s: {
###       active => undef,
###       cert_courses => '2/11/09.Cert.Gull.Bridge',
###       courses => '7/4/08.Fun.London,8/15/08.Ful.London,9/12/08.Bal.London,10/10/08.Pro.London,11/14/08.ITB.London,6/26/09.Ful.LONDON-HAT,9/25/09.Bal.LONDON-HAT',
###       cpcc_cert_date => undef,
###       cpcc_grad => undef,
###       cti_faculty => undef,
###       email => 'johnmcguire@broadlandsconsulting.com',
###       first_name => 'John',
###       fm_id => '81929',
###       last_activity => '07/21/2010 11:52:12',
###       last_name => 'McGuire',
###       level => '6'
###     }




}
