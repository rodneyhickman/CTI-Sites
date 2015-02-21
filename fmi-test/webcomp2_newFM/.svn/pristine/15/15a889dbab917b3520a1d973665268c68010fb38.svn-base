<?php

  // updated Mar 7, 2012


class Student 
{
  const DATABASE = 'CTI_REG_web';
  const USERNAME = 'Web';
  const PASSWORD = 'cti_web123';

  public $fm     = null;
  public $email  = '';
  public $record = null;
  public $course_records = null;
  public $error  = '';
  public $fmid = 0;

  public $course_type_id_map = array(
    "Ful" => 3,
    "Fun" => 4,
    "Bal" => 5,
    "Pro" => 6,
    "Syn" => 7,

    "BkDigital" => 1001,
    "CUR UPDT"  => 1002,
    "Cert"      => 1003,
    "Cert-H"    => 1004,
    "ExR"       => 1005,
    "FEE"       => 1006,
    "FRPR"      => 1007,
    "ITB"       => 1008,
    "LC"        => 1009,
    "LCUK"      => 1010,
    "LDF"       => 1011,
    "LP"        => 1012,
    "LP-H"      => 1013,
    "LP1"       => 1014,
    "LP2"       => 1015,
    "LP3"       => 1016,
    "LP4"       => 1017,
    "PTHWY"     => 1018,
    "Webinar"   => 1019

  );

  public function authenticate( $password )
  {
    if(!isset($this->record)){
      return false;
    }
    if($this->record->getField('Password') == $password){
      return true;
    }
    else {
      return false;
    }
  }

  public function authenticate_webinar( $password )
  {
    if(!isset($this->record)){
      return false;
    }
    if($this->record->getField('Password') == $password){
      if($this->record->getField('web_login') == 'Yes'){ // if "web_login" not blank, then student has paid for webinar
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  
  
  public function authenticate_cpcc( $password )
  {
    if(!isset($this->record)){
      return false;
    }
    if($this->record->getField('Password') == $password){
      if($this->record->getField('CPCC Cert') != ''){ // if "CPCC Cert" not blank, then student is certified
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }

  public function set_password( $new_password )
  {
    $this->record->setField('Password',$new_password);
    $result = $this->record->commit();
  }

  public function unsubscribe( $unsub_type )
  {
    $result='no action taken';
    if( $unsub_type == 'marketing' ){
      $this->record->setField('y_optout_email_n','1');
      $result='ok';
    }
    else if( $unsub_type == 'newsletter' ){
      $this->record->setField('y_optout_newsletter_n','1');
      $result='ok';
    }
    if($result=='ok'){
    $this->record->commit();
    }
    return $result;
  }

  public function set_terms( $date, $number )
  {
    if( $number == 1 ){
      $this->record->setField('Terms_and_Conditions_1_Date',$date);
    }
    if( $number == 2 ){
      $this->record->setField('Terms_and_Conditions_2_Date',$date);
    }
    if( $number == 3 ){
      $this->record->setField('Terms_and_Conditions_3_Date',$date);
    }

    $result = $this->record->commit();
  }

 public function set_bridging_content( $number )
  {
    $this->record->setField('y_Bridge_n',$number);
    $this->record->setField('y_Bridge_d_compl',date('m/d/Y'));

    $result = $this->record->commit();
  }

  public function get_record( $fm, $email )
  {
    $this->fm    = $fm;
    $this->email = preg_replace('/@/','\@',$email);

    // perform find
    // Find with criteria
    $findCommand =& $fm->newFindCommand('Web Contact'); // LAYOUT
    $findCommand->addFindCriterion('con_email',$this->email); 


    $result = $findCommand->execute();
    
    if(FileMaker::isError($result)){
      $this->record = null;
      $this->error  = $result->getMessage();

    }
    else {
      // Get records from found set 
      $records = $result->getRecords(); 
      $this->record = $records[0]; // first record (there should only be one)
    }

  }

  public function get_record_by_id( $fm, $fmid )
  {
    $this->fm    = $fm;
    $this->fmid  = $fmid;

    // perform find
    // Find with criteria
    $findCommand =& $fm->newFindCommand('Web Contact');  // LAYOUT
    $findCommand->addFindCriterion('zkp_contact_n',$this->fmid); 


    $result = $findCommand->execute();
    
    if(FileMaker::isError($result)){
      $this->record = null;
      $this->error  = $result->getMessage();

    }
    else {
      // Get records from found set 
      $records = $result->getRecords(); 
      $this->record = $records[0]; // first record (there should only be one)
    }

  }

  public function get_courses( $fm, $fmid )  
  {
    $this->fm    = $fm;
    $this->fmid  = $fmid;

    if(isset($this->record)){
    
      // perform find
      // Find with criteria
      $findCommand =& $fm->newFindCommand('Web Course'); // LAYOUT
      $findCommand->addFindCriterion('zkc_contact_n',$this->fmid); 

      $result = $findCommand->execute();
    
      if(FileMaker::isError($result)){
        $this->course_records = null;
        $this->error  = $result->getMessage();
      }
      else {
        // Get records from found set 
        $this->course_records = $result->getRecords(); 
      }
    }

  }


  public function new_commlog( $message, $regarding )
  {
    $fm = $this->fm;
 
   // get customer code

    $customer_code = $this->record->getField('zkp_contact_n');

    // fill $values

    $values['zkc_contact_n']     = $customer_code;
    $values['Message']           = $message;
    $values['Regarding']         = $regarding;
    $values['Type']              = 'Web';

    //$values['Campaign']          = 'WEBAUTOFUNCTION';
    //$values['To_Do']             = 0;
    //$values['Created_Timestamp'] = date('m/d/Y H:M:S');

    // create new Comm Log record

    $rec =& $fm->createRecord('Web Commlog', $values); // LAYOUT
    $result = $rec->commit();

    //echo $result->getMessage(); 
  }

  public function set_certification_cc_card( $cc_type, $cc_number, $cc_exp_month, $cc_exp_year, $cc_name )
  {
    // set fields for Certification CC card

    // commlog entry
    $this->new_commlog( "Certification CC Card stored ".$cc_exp_year, "Certification Registration" );
    return 'ok';
  }

}