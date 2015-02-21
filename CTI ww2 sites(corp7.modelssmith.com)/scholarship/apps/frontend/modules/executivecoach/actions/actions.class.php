<?php
  //@require_once "Mail.php";

  /**
   * executivecoach actions.
   *
   * @package    sf_sandbox
   * @subpackage executivecoach
   * @author     Your name here
   * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
   */


class executivecoachActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }



  /**
   * Executes Castep1form action
   * This function will diplay the form
   *
   * @param sfRequest $request A request object
   */

  // make sure applicant is logged in

  public function executeForm(sfWebRequest $request)
  {
   
    if(!$this->getUser()->isAuthenticated() ){
      $this->getUser()->setAttribute('referer','executivecoach/form');
      $this->redirect('executivecoach/login');
    }

    $this->profile = ProfilePeer::GetProfileFromEmail( $this->getUser()->getAttribute( 'email' ) );

    if(!isset($this->profile) || gettype($this->profile) == 'NULL'){ // this should never happen... if person is authenticated, they should have email address and profile
      $this->getUser()->setAttribute('referer','executivecoach/form');
      $this->redirect('executivecoach/login');
    }

    // $test = isset($this->profile);
    // print_r(array('profile'=>$this->profile, 'test'=>$test, 'type'=>gettype($this->profile)));
    // return sfView::NONE;

    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID, $this->profile->getId() );
    $this->exec = ExeccoachPeer::doSelectOne( $c );
    if(!$this->exec){ // Create leadership scholarship form if none exists
      $this->exec = new Execcoach();
      $this->exec->setProfileId( $this->profile->getId() );
      $this->exec->setFaculty( 'no' );
      $this->exec->save();
    }

    

    // get refering url and pass to form
    $this->referer = $this->getRequest()->getReferer();
    $this->getUser()->setAttribute('referer', $this->referer);

    $this->show_critique = 1;
    $this->form_title = 'CTI Corporate Support';
    $this->edit_key = 0;

    return sfView::SUCCESS;
  }


  public function executeFaculty(sfWebRequest $request)
  {
   
    if(!$this->getUser()->isAuthenticated()){
      $this->getUser()->setAttribute('referer','executivecoach/faculty');
      $this->redirect('executivecoach/login');
    }

    $this->profile = ProfilePeer::GetProfileFromEmail( $this->getUser()->getAttribute( 'email' ) );

    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID, $this->profile->getId() );
    $this->exec = ExeccoachPeer::doSelectOne( $c );
    if(!$this->exec){ // Create leadership scholarship form if none exists
      $this->exec = new Execcoach();
      $this->exec->setProfileId( $this->profile->getId() );
      $this->exec->setFaculty( 'yes' );
      $this->exec->save();
    }

    

    // get refering url and pass to form
    $this->referer = $this->getRequest()->getReferer();
    $this->getUser()->setAttribute('referer', $this->referer);

    $this->show_critique = 0;
    $this->form_title = 'CTI Corporate Support (Faculty)';
    $this->edit_key = 0;

    $this->setTemplate('form');
  }


  public function executeAdminEdit(sfWebRequest $request)
  {

    $profile_id    = $request->getParameter('profile_id');
    $this->profile = ProfilePeer::retrieveByPk( $profile_id );

    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID, $this->profile->getId() );
    $this->exec = ExeccoachPeer::doSelectOne( $c );

    if($this->exec->getFaculty() == 'yes'){
      $this->show_critique = 0; // 0 for faculty, 1 for exec coach
      $this->form_title    = 'CTI Corporate Support (Faculty)';
    }
    else {
      $this->show_critique = 1; // 0 for faculty, 1 for exec coach
      $this->form_title    = 'CTI Corporate Support';
    }
    $this->edit_key      = 'abc123';
    $this->referer = '';

    $this->setTemplate('form');
  }


  public function executeThankYou(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(false);
    return sfView::SUCCESS;
  }



  /**
   * Executes Castep1process action
   * This function will process the form data
   *
   * @param sfRequest $request A request object
   */
  public function executeFormProcess(sfWebRequest $request)
  {
    $this->execcoach = $request->getParameter('execcoach');
    $this->edit_key  = $request->getParameter('edit_key');

    // $adminpid = $request->getParameter('adminpid');

    // if($adminpid > 0){
    //   // adminpid > 0 means that the form is being edited by admin
    //   $profile = ProfilePeer::retrieveByPk( $adminpid );
    // }
    // else if($this->execcoach['email1'] != '' && $adminpid == -2){
    //   // get profile id from email (or create new profile)
    //   $profile = ProfilePeer::getProfileFromEmail( $this->execcoach['email1'] );
    // }
    // else {

      $profile = ProfilePeer::getProfileFromEmail( $this->execcoach['email1'] );

      // $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    // }

    // Set profile items
    if( @$this->execcoach['email1'] ){
      $profile->setFirstName(       $this->execcoach['first_name'] );
      $profile->setLastName(        $this->execcoach['last_name'] );
      $profile->setEmail1(          $this->execcoach['email1'] );

      $profile->setPermAddress1(    $this->execcoach['perm_address1'] );
      $profile->setPermAddress2(    $this->execcoach['perm_address2'] );
      $profile->setPermCity(        $this->execcoach['perm_city'] );
      $profile->setPermStateProv(   $this->execcoach['perm_state_prov'] );
      $profile->setPermZipPostcode( $this->execcoach['perm_zip_postcode'] );
      $profile->setPermCountry(     $this->execcoach['perm_country'] );

      $profile->setTelephone1(      $this->execcoach['telephone1'] );
      $profile->setTelephone2(      $this->execcoach['telephone2'] );


    }
    $profile->save();


    // set leadership items
    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID,$profile->getId());
    $exec_coach = ExeccoachPeer::doSelectOne( $c );

    if(!$exec_coach){
      $exec_coach = new Execcoach();
    }

    $exec_coach->setProfileId( $profile->getId() );
    $exec_coach->setPhoneOffice(            $this->execcoach['phone_office'] );
    $exec_coach->setSkype(                  $this->execcoach['skype'] );
    $exec_coach->setHomeCountry(            $this->execcoach['home_country'] );
    $exec_coach->setTimeZone(               $this->execcoach['time_zone'] );
    $exec_coach->setLanguageFluency(        $this->execcoach['language_fluency'] );
    $exec_coach->setOtherLanguageFluency(        $this->execcoach['other_language_fluency'] );
    $exec_coach->setEducation(              $this->execcoach['education'] );
    $exec_coach->setCertifications(         $this->execcoach['certifications'] );
    $exec_coach->setExpectedCertification(         $this->execcoach['certifications_expected'] );
    $exec_coach->setAuthorizedToWork(       $this->execcoach['authorized_to_work'] );
    $exec_coach->setYearsCti(               $this->execcoach['years_cti'] );
    $exec_coach->setWhatCapacity(           $this->execcoach['what_capacity'] );
    $exec_coach->setOtherBrokering(           $this->execcoach['other_brokering'] );

    $exec_coach->setCorporateClients(       $this->execcoach['corporate_clients'] );
    $exec_coach->setTrainingStyle(          $this->execcoach['training_style'] );
    $exec_coach->setPublicationEngagements( $this->execcoach['publication_engagements'] );
    $exec_coach->setExpertise(              $this->execcoach['expertise'] );
    $exec_coach->setIndustries(             $this->execcoach['industries'] );
    $exec_coach->setCorporateEmployee(             $this->execcoach['corporate_employee'] );
    $exec_coach->setTypesOfCoaching(        $this->execcoach['types_of_coaching'] );
    $exec_coach->setNumberOfExecutives(     $this->execcoach['number_of_executives'] );
    $exec_coach->setBeenAnExecutive(     $this->execcoach['been_an_executive'] );
    $exec_coach->setOutcomesTracked(        $this->execcoach['outcomes_tracked'] );
    $exec_coach->setWorkVisa(               $this->execcoach['work_visa'] );
    $exec_coach->setTravelVisa(             $this->execcoach['travel_visa'] );
    $exec_coach->setMediaExposure(          $this->execcoach['media_exposure'] );
    $exec_coach->setSizeOfGroup(            $this->execcoach['size_of_group'] );
    $exec_coach->setEndorsements(           $this->execcoach['endorsements'] );
$exec_coach->setCritique(           $this->execcoach['critique'] );
    $exec_coach->setUtilizationCorpForl(    @$this->execcoach['utilization_corp_forl'] );
    $exec_coach->setUtilizationCorpCoach(   @$this->execcoach['utilization_corp_coach'] );
    $exec_coach->setUtilizationExecCoach(   @$this->execcoach['utilization_exec_coach'] );
    $exec_coach->setDateSubmitted(   $this->execcoach['date_submitted'] );

    // uploads
    
    $index = 0;
    $profile_id = $profile->getId();
    foreach ($request->getFiles() as $uploadedFile) {
      // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //print_r($uploadedFile);
      if($index == 0){ // first file
        if( $uploadedFile["name"] != '' ){
          move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$profile_id.'_'.$uploadedFile["name"]);
          $exec_coach->setBioResume( $profile_id.'_'.$uploadedFile["name"] );
        }
        $index++;
      } 
      else {
        if( $uploadedFile["name"] != '' ){
          move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$profile_id.'_'.$profile->getFirstName().'_'.$profile->getLastName().'.jpg');
          $exec_coach->setPhoto( $profile_id.'_'.$profile->getFirstName().'_'.$profile->getLastName().'.jpg' );
        }
      }
    }


    $exec_coach->save();

    if($this->edit_key == 'abc123'){
      $this->redirect('leadership/applicant?id='.$profile_id);
    }

    else {
      // Format results for email
      $array    = $profile->getExeccoachArray();
      $text     = commonTools::FormattedTextFromArray( $array );
      $subject  = "Form Results from Executive Coach Form";
      $headers  = "From: webserver@thecoaches.com\r\n";
      $to       = "register@thecoaches.com";
      //$to       = "ping@me.com";
      
      // prepare email body text
      $body = "Executive Coach Form for ".$profile->getFirstName().". Please keep this information for your records.\n\n";
      $body .= $text;
      
      // Send email
      //$sent = mail($to, $subject, $body, $headers) ;
      
      $this->redirect('executivecoach/thankYou');
    }

    // show form results
    //$this->text = commonTools::FormattedTextFromArray( $array );
    
    return sfView::SUCCESS;
  }
  


  /**
   * Executes Castep1form action
   * This function will diplay the form
   *
   * @param sfRequest $request A request object
   */



  public function executeLogin(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->msg = $request->getParameter( 'msg' );
    $this->logMessage('********************************************* Login');
    $this->result_r =  $this->getUser()->getAttribute('result_r');
    $this->redirect = ''; //$this->getUser()->getAttribute('referer');
 
    $system_available = file_get_contents('http://webcomp.modelsmith.com/fmi-test/webcomp2_newFM/abletogetrecord.php?postkey=fjgh15t&em=ping@me.com');
    if($system_available != 'ok'){
      $this->setTemplate('maintenance');
    }

    return sfView::SUCCESS;
  }

  public function executeMaintenance(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeLoginProcess(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $email    = $request->getParameter( 'email' );
    $password = $request->getParameter( 'password' );
    //$redirect = $request->getParameter( 'redirect' );
    $redirect  = $this->getUser()->getAttribute('referer');
    if($redirect == '' || preg_match('/login/i',$redirect)){
      $redirect = 'executivecoach/chooseForm';
    }

    $result = ProfilePeer::FilemakerLogin( $email, $password );
    $result_r = print_r($result, true);
    
    $this->logMessage('********************************************* LoginProcess');
    $this->logMessage('Login result: '.$result_r);
    $this->getUser()->setAttribute('result_r',$result_r);

    if($result['status'] == 'ok'){

      // sign in this user session
      $this->getUser()->setAuthenticated(true);
 
      $this->getUser()->setAttribute('email',$email);
      //$profile = ProfilePeer::retrieveByEmail($email);
      //$this->getUser()->setAttribute('profile_id',$profile->getId());
      $this->redirect($redirect);

    }
   
    $msg = "The email address or password did not match our records. Please try again.";
    $this->redirect('executivecoach/login?msg='.$msg);

  }

  public function executeChooseForm(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeLogout(sfWebRequest $request)
  {
    // sign in this user session
    $this->getContext()->getUser()->signOut();

    //$this->forward('main', 'login');
    return sfView::SUCCESS;
  }


// ==================== For testing purposes only ====================

 public function executeForm1(sfWebRequest $request)
  {
   
    if(!$this->getUser()->isAuthenticated()){
      $this->redirect('executivecoach/login');
    }

    $this->profile = ProfilePeer::GetProfileFromEmail( $this->getUser()->getAttribute( 'email' ) );

    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID, $this->profile->getId() );
    $this->exec = ExeccoachPeer::doSelectOne( $c );
    if(!$this->exec){ // Create leadership scholarship form if none exists
      $this->exec = new Execcoach();
      $this->exec->setProfileId( $this->profile->getId() );
      $this->exec->save();
    }

    

    // get refering url and pass to form
    $this->referer = $this->getRequest()->getReferer();

    return sfView::SUCCESS;
  }



 /**
   * Executes Castep1process action
   * This function will process the form data
   *
   * @param sfRequest $request A request object
   */
  public function executeForm1Process(sfWebRequest $request)
  {
    $this->execcoach = $request->getParameter('execcoach');

    // $adminpid = $request->getParameter('adminpid');

    // if($adminpid > 0){
    //   // adminpid > 0 means that the form is being edited by admin
    //   $profile = ProfilePeer::retrieveByPk( $adminpid );
    // }
    // else if($this->execcoach['email1'] != '' && $adminpid == -2){
    //   // get profile id from email (or create new profile)
    //   $profile = ProfilePeer::getProfileFromEmail( $this->execcoach['email1'] );
    // }
    // else {

      $profile = ProfilePeer::getProfileFromEmail( $this->execcoach['email1'] );

      // $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    // }

    // Set profile items
    if( @$this->execcoach['email1'] ){
      $profile->setFirstName(       $this->execcoach['first_name'] );
      $profile->setLastName(        $this->execcoach['last_name'] );
      $profile->setEmail1(          $this->execcoach['email1'] );

      $profile->setPermAddress1(    $this->execcoach['perm_address1'] );
      $profile->setPermAddress2(    $this->execcoach['perm_address2'] );
      $profile->setPermCity(        $this->execcoach['perm_city'] );
      $profile->setPermStateProv(   $this->execcoach['perm_state_prov'] );
      $profile->setPermZipPostcode( $this->execcoach['perm_zip_postcode'] );
      $profile->setPermCountry(     $this->execcoach['perm_country'] );

      $profile->setTelephone1(      $this->execcoach['telephone1'] );
      $profile->setTelephone2(      $this->execcoach['telephone2'] );

    }
    $profile->save();


    // set leadership items
    $c = new Criteria();
    $c->add(ExeccoachPeer::PROFILE_ID,$profile->getId());
    $exec_coach = ExeccoachPeer::doSelectOne( $c );

    if(!$exec_coach){
      $exec_coach = new Execcoach();
    }

    $exec_coach->setProfileId( $profile->getId() );
    $exec_coach->setPhoneOffice(            $this->execcoach['phone_office'] );
    $exec_coach->setSkype(                  $this->execcoach['skype'] );
    $exec_coach->setHomeCountry(            $this->execcoach['home_country'] );
    $exec_coach->setTimeZone(               $this->execcoach['time_zone'] );
    $exec_coach->setLanguageFluency(        $this->execcoach['language_fluency'] );
    $exec_coach->setEducation(              $this->execcoach['education'] );
    $exec_coach->setCertifications(         $this->execcoach['certifications'] );
    $exec_coach->setAuthorizedToWork(       $this->execcoach['authorized_to_work'] );
    $exec_coach->setYearsCti(               $this->execcoach['years_cti'] );
    $exec_coach->setWhatCapacity(           $this->execcoach['what_capacity'] );
    $exec_coach->setCorporateClients(       $this->execcoach['corporate_clients'] );
    $exec_coach->setTrainingStyle(          $this->execcoach['training_style'] );
    $exec_coach->setPublicationEngagements( $this->execcoach['publication_engagements'] );
    $exec_coach->setExpertise(              $this->execcoach['expertise'] );
    $exec_coach->setIndustries(             $this->execcoach['industries'] );
    $exec_coach->setTypesOfCoaching(        $this->execcoach['types_of_coaching'] );
    $exec_coach->setNumberOfExecutives(     $this->execcoach['number_of_executives'] );
    $exec_coach->setOutcomesTracked(        $this->execcoach['outcomes_tracked'] );
    $exec_coach->setWorkVisa(               $this->execcoach['work_visa'] );
    $exec_coach->setTravelVisa(             $this->execcoach['travel_visa'] );
    $exec_coach->setMediaExposure(          $this->execcoach['media_exposure'] );
    $exec_coach->setSizeOfGroup(            $this->execcoach['size_of_group'] );
    $exec_coach->setEndorsements(           $this->execcoach['endorsements'] );
    $exec_coach->setCritique(           $this->execcoach['critique'] );
    $exec_coach->setUtilizationCorpForl(    @$this->execcoach['utilization_corp_forl']  );
    $exec_coach->setUtilizationCorpCoach(   @$this->execcoach['utilization_corp_coach']  );
    $exec_coach->setUtilizationExecCoach(   @$this->execcoach['utilization_exec_coach']  );
    $exec_coach->setDateSubmitted(   $this->execcoach['date_submitted'] );

    // uploads
    //$exec_coach->setBioResume(              $this->execcoach['bio_resume'] );
    //$exec_coach->setPhoto(                  $this->execcoach['photo'] );

    $index = 0;
    foreach ($request->getFiles() as $uploadedFile) {
      // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //print_r($uploadedFile);
      move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$uploadedFile["name"]);
      if($index == 0){ // first file
        $exec_coach->setBioResume( $uploadedFile["name"] );
        $index++;
      } 
      else {
        $exec_coach->setPhoto( $uploadedFile["name"] );
      }
    }


    $exec_coach->save();


    // Format results for email
    $array    = $profile->getExeccoachArray();
    $text     = commonTools::FormattedTextFromArray( $array );
    $subject  = "Form Results from Executive Coach Form";
    $headers  = "From: webserver@thecoaches.com\r\n";
    $to       = "register@thecoaches.com";
    //$to       = "ping@me.com";

    // prepare email body text
    $body = "Executive Coach Form for ".$profile->getFirstName().". Please keep this information for your records.\n\n";
    $body .= $text;

    // Send email
    //$sent = mail($to, $subject, $body, $headers) ;

    //$this->redirect('executivecoach/thankYou');

    // show form results
    //$this->text = commonTools::FormattedTextFromArray( $array );

    return sfView::SUCCESS;
  }


// ========================= New Password Request =========================


 public function executeRequestNewPassword(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->msg = $request->getParameter( 'msg' );

    return sfView::SUCCESS;
  }

  public function executeRequestNewPasswordProcess(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $email = $request->getParameter( 'email' );

    $msg = ProfilePeer::RequestNewPassword( $email ); // sends email or returns error msg

    $this->msg = $msg;
    return sfView::SUCCESS;
  }

  public function executeNewPassword(sfWebRequest $request){
    $this->msg = '';
    $this->ok  = $request->getParameter('ok');
    if($this->ok == 1){
      return sfView::SUCCESS;
    }

    $this->key = $request->getParameter('k');
    $this->key = preg_replace('/[^A-Z0-9\-]/','',$this->key); // untaint the reset key

    // check for key
    $profile = ProfilePeer::retrieveByKey( $this->key );

    // if not OK, redirect to login
    if(!isset($profile)){
      $this->redirect('executivecoach/login');
    }
  
    $this->email = $profile->getEmail1();

    return sfView::SUCCESS;
  }

 public function executeNewPasswordProcess(sfWebRequest $request){
    $password  = $request->getParameter('password');
    $verify    = $request->getParameter('verify');
    $submitbtn = $request->getParameter('submitbtn');

    $this->key = $request->getParameter('k');
    $this->key = preg_replace('/[^A-Z0-9\-]/','',$this->key); // untaint the reset key

    // check for key
    $profile = ProfilePeer::retrieveByKey( $this->key );


    // if not OK, redirect to login
    if(!isset($profile)){
      $this->redirect('executivecoach/login');
    }

    if($password != $verify){
      $this->redirect('executivecoach/newPassword?k='.$this->key.'&msg=Passwords don\'t match, please try again');
    }

    $profile->setNewPassword( $password );

    $this->redirect('executivecoach/newPassword?k='.$this->key.'&ok=1');
  }


}
