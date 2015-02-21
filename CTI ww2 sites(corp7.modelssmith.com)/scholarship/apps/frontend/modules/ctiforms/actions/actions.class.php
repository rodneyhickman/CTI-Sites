<?php

/* NEXT STEPS (Thomas) Mar 7, 2012
   (DONE) - add getProfileFromEmail to Profile.php
   - Copy an existing form to be basis of leadership form
   - add array functions to Leadership.php (?)
   - test data into DB
   - test email results
 */

  // see /Users/thomas/00-CTI/73-Scholarship-Forms/iterate-fields.pl for generating forms and Profile->getFooArray()


/**
 * ctiforms actions.
 *
 * @package    sf_sandbox
 * @subpackage ctiforms
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ctiformsActions extends sfActions
{


 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     return sfView::SUCCESS;
  }



 /**
  * Executes BackToReferrer action 
  * This function handles the Cancel button on all forms.  It simply 
  * redirects back to the referring page.
  *
  * @param sfRequest $request A request object
  */
  public function executeBackToReferrer(sfWebRequest $request)
  {
    $this->referer = $request->getParameter('referer');  // get from form
    $this->redirect($this->referer);
  }





  public function executeCoachTraining(sfWebRequest $request)
  {
    $profile_id = $request->getParameter('profile_id');
    $adminedit = $request->getParameter('adminedit');
    $loc = $request->getParameter('loc','all_sans_other');
    $this->adminpid = 0;
    
    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){
      // get form values if this is admin edit
      $this->profile = ProfilePeer::retrieveByPk( $profile_id );
      // get all form values
      $c = new Criteria();
      $c->add(CoachtrainingPeer::PROFILE_ID, $profile_id );
      $this->coach = CoachtrainingPeer::doSelectOne( $c );
      if(!$this->coach){ // Create leadership scholarship form if none exists
        $this->coach = new Coachtraining();
        $this->coach->setProfileId( $this->profile->getId() );
        $this->coach->save();
      }

      // adminpid becomes profile_id
      $this->adminpid = $profile_id;
    }
    else {
      // otherwise get profile from user session
      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    }

    // get refering url and pass to form
    $this->referer = $this->getRequest()->getReferer();

    return sfView::SUCCESS;
  }



  public function executeCoachTrainingThankYou(sfWebRequest $request)
  {
return sfView::SUCCESS;
  }

  public function executeCoachTrainingProcess(sfWebRequest $request)
  {
    $this->coachtraining = $request->getParameter('coachtraining');

    $adminpid = $request->getParameter('adminpid');

    if($adminpid > 0){
      // adminpid > 0 means that the form is being edited by admin
      $profile = ProfilePeer::retrieveByPk( $adminpid );
    }
    else if($this->coachtraining['email1'] != '' && $adminpid == -2){
      // get profile id from email (or create new profile)
      $profile = ProfilePeer::getProfileFromEmail( $this->coachtraining['email1'] );
    }
    else {
      $profile = ProfilePeer::getProfileFromEmail( $this->coachtraining['email1'] );
      // $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    }
  



    // Set profile items
    if( @$this->coachtraining['email1'] ){
      $profile->setFirstName( $this->coachtraining['first_name'] );
      $profile->setLastName( $this->coachtraining['last_name'] );
      $profile->setEmail1( $this->coachtraining['email1'] );

      $profile->setPermAddress1( $this->coachtraining['perm_address1'] );
      $profile->setPermAddress2( $this->coachtraining['perm_address2'] );
      $profile->setPermCity( $this->coachtraining['perm_city'] );
      $profile->setPermStateProv( $this->coachtraining['perm_state_prov'] );
      $profile->setPermZipPostcode( $this->coachtraining['perm_zip_postcode'] );
      $profile->setPermCountry( $this->coachtraining['perm_country'] );

      $profile->setOtherAddress1( $this->coachtraining['other_address1'] );
      $profile->setOtherAddress2( $this->coachtraining['other_address2'] );
      $profile->setOtherCity( $this->coachtraining['other_city'] );
      $profile->setOtherStateProv( $this->coachtraining['other_state_prov'] );
      $profile->setOtherZipPostcode( $this->coachtraining['other_zip_postcode'] );
      $profile->setOtherCountry( $this->coachtraining['perm_country'] );

      $profile->setTelephone1( $this->coachtraining['telephone1'] );
      $profile->setTelephone2( $this->coachtraining['telephone2'] );
      $profile->setReferredBy( $this->coachtraining['referred_by'] );

    }
    $profile->save();


    // set leadership items
    $c = new Criteria();
    $c->add(CoachtrainingPeer::PROFILE_ID,$profile->getId());
    $coach = CoachtrainingPeer::doSelectOne( $c );

    if(!$coach){
      $coach = new Coachtraining();
    }

    $coach->setProfileId( $profile->getId() );

    $coach->setProgramPreference( $this->coachtraining['program_preference'] );
    $coach->setCorePreferredDate1( $this->coachtraining['core_preferred_date1'] );
    $coach->setCorePreferredDate2( $this->coachtraining['core_preferred_date2'] );
    $coach->setCorePreferredDate3( $this->coachtraining['core_preferred_date3'] );
    $coach->setCertPreferredDate1( $this->coachtraining['cert_preferred_date1'] );
    $coach->setCertPreferredDate2( $this->coachtraining['cert_preferred_date2'] );
    $coach->setCertPreferredDate3( $this->coachtraining['cert_preferred_date3'] );

    $coach->setWhatChoose( $this->coachtraining['what_choose'] );
    $coach->setFundamentalsExp( $this->coachtraining['fundamentals_exp'] );
    $coach->setYourVision( $this->coachtraining['your_vision'] );
    $coach->setHowSupport( $this->coachtraining['how_support'] );
    $coach->setWhyApplying( $this->coachtraining['why_applying'] );
    $coach->setWhatSize( $this->coachtraining['what_size'] );
    $coach->setAnythingElse( $this->coachtraining['anything_else'] );
   


    $coach->setBackground( $this->coachtraining['background'] );
    $coach->setUnderstoodAgreements( $this->coachtraining['understood_agreements'] );

  // uploads
    
    $index = 0;
    $fullname = $profile->getName();
   
    foreach ($request->getFiles() as $uploadedFile) {
      // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //print_r($uploadedFile);
      $filename = $fullname.'-'.$uploadedFile["name"];
      $filename = preg_replace('/[^A-Za-z0-9\.]/','-',$filename);
      move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$filename);
      if($index == 0){ // first file
        $coach->setBioResume( $filename );
        $index++;
      } 
    }

    $coach->save();


    // Format results for email
    $array    = $profile->getCoachTrainingArray();
    $text     = commonTools::FormattedTextFromArray( $array );
    $subject  = "Form Results from Coach Training Scholarship Application Form";
    $headers  = "From: webserver@thecoaches.com\r\n";
    $to       = "scholarships@thecoaches.com";

    // prepare email body text
    $body = "Coach Training Scholarship Application Form for ".$profile->getFirstName().". Please keep this information for your records.\n\n";
    $body .= $text;

    // Send email
    $sent = mail($to, $subject, $body, $headers) ;

    $this->referer = $request->getParameter('referer');
    //if($this->referer != ''){
    //  $this->redirect($referer);
    //}

    // show form results
    $this->text = $text;

    return sfView::SUCCESS;
  }







 /**
  * Executes Castep1form action
  * This function will diplay the form
  *
  * @param sfRequest $request A request object
  */
  public function executeLeadership(sfWebRequest $request)
  {
    $profile_id = $request->getParameter('profile_id');
    $adminedit = $request->getParameter('adminedit');
    $loc = $request->getParameter('loc','all_sans_other');
    $this->adminpid = 0;
    
    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){
      // get form values if this is admin edit
      $this->profile = ProfilePeer::retrieveByPk( $profile_id );
      // get all form values
      $c = new Criteria();
      $c->add(LeadershipPeer::PROFILE_ID, $profile_id );
      $this->lead = LeadershipPeer::doSelectOne( $c );
      if(!$this->lead){ // Create leadership scholarship form if none exists
        $this->lead = new Leadership();
        $this->lead->setProfileId( $this->profile->getId() );
        $this->lead->save();
      }

      // adminpid becomes profile_id
      $this->adminpid = $profile_id;
    }
    else {
      // otherwise get profile from user session
      $this->profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    }

    // get refering url and pass to form
    $this->referer = $this->getRequest()->getReferer();

    return sfView::SUCCESS;
  }

  public function executeLeadershipThankYou(sfWebRequest $request)
  {
return sfView::SUCCESS;
  }

   /**
  * Executes Castep1process action
  * This function will process the form data
  *
  * @param sfRequest $request A request object
  */
  public function executeLeadershipProcess(sfWebRequest $request)
  {
    $this->leadership = $request->getParameter('leadership');

    $adminpid = $request->getParameter('adminpid');

    if($adminpid > 0){
      // adminpid > 0 means that the form is being edited by admin
      $profile = ProfilePeer::retrieveByPk( $adminpid );
    }
    else if($this->leadership['email1'] != '' && $adminpid == -2){
      // get profile id from email (or create new profile)
      $profile = ProfilePeer::getProfileFromEmail( $this->leadership['email1'] );
    }
    else {
      $profile = ProfilePeer::getProfileFromEmail( $this->leadership['email1'] );
      // $profile = ProfilePeer::retrieveByPk( $this->getUser()->getProfileId() );
    }
  



    // Set profile items
    if( @$this->leadership['email1'] ){
      $profile->setFirstName( $this->leadership['first_name'] );
      $profile->setLastName( $this->leadership['last_name'] );
      $profile->setEmail1( $this->leadership['email1'] );

      $profile->setPermAddress1( $this->leadership['perm_address1'] );
      $profile->setPermAddress2( $this->leadership['perm_address2'] );
      $profile->setPermCity( $this->leadership['perm_city'] );
      $profile->setPermStateProv( $this->leadership['perm_state_prov'] );
      $profile->setPermZipPostcode( $this->leadership['perm_zip_postcode'] );
      $profile->setPermCountry( $this->leadership['perm_country'] );

      $profile->setOtherAddress1( $this->leadership['other_address1'] );
      $profile->setOtherAddress2( $this->leadership['other_address2'] );
      $profile->setOtherCity( $this->leadership['other_city'] );
      $profile->setOtherStateProv( $this->leadership['other_state_prov'] );
      $profile->setOtherZipPostcode( $this->leadership['other_zip_postcode'] );
      $profile->setOtherCountry( $this->leadership['perm_country'] );

      $profile->setTelephone1( $this->leadership['telephone1'] );
      $profile->setTelephone2( $this->leadership['telephone2'] );
      $profile->setReferredBy( $this->leadership['referred_by'] );
    }
    $profile->save();


    // set leadership items
    $c = new Criteria();
    $c->add(LeadershipPeer::PROFILE_ID,$profile->getId());
    $lead = LeadershipPeer::doSelectOne( $c );

    if(!$lead){
      $lead = new Leadership();
    }

    $lead->setProfileId( $profile->getId() );

    $lead->setProgramPreference( $this->leadership['program_preference'] );
    $lead->setPreferredDate1( $this->leadership['preferred_date1'] );
    $lead->setPreferredDate2( $this->leadership['preferred_date2'] );
    $lead->setPreferredDate3( $this->leadership['preferred_date3'] );
    $lead->setHowStarted( $this->leadership['how_started'] );
    $lead->setWhatImpact( $this->leadership['what_impact'] );
    $lead->setWhyTake( $this->leadership['why_take'] );
    $lead->setDesiredImpact( $this->leadership['desired_impact'] );


    $lead->setHowAccountable( $this->leadership['how_accountable'] );
    $lead->setWhatBring( $this->leadership['what_bring'] );
    $lead->setWhyApplying( $this->leadership['why_applying'] );
    $lead->setWhatSize( $this->leadership['what_size'] );
    $lead->setBackground( $this->leadership['background'] );
    $lead->setUnderstoodAgreements( $this->leadership['understood_agreement'] );

  // uploads
    
    $index = 0;
    $fullname = $profile->getName();
   
    foreach ($request->getFiles() as $uploadedFile) {
      // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //print_r($uploadedFile);
      $filename = $fullname.'-'.$uploadedFile["name"];
      $filename = preg_replace('/[^A-Za-z0-9\.]/','-',$filename);
      move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$filename);
      if($index == 0){ // first file
        $lead->setBioResume( $filename );
        $index++;
      } 
    }


    $lead->save();


    // Format results for email
    $array    = $profile->getLeadershipArray();
    $text     = commonTools::FormattedTextFromArray( $array );
    $subject  = "Form Results from Leadership Scholarship Application Form";
    $headers  = "From: webserver@thecoaches.com\r\n";
    $to       = "scholarships@thecoaches.com";

    // prepare email body text
    $body = "Leadership Scholarship Application Form for ".$profile->getFirstName().". Please keep this information for your records.\n\n";
    $body .= $text;

    // Send email
    $sent = mail($to, $subject, $body, $headers) ;

    $this->referer = $request->getParameter('referer');
    //if($this->referer != ''){
    //  $this->redirect($referer);
    //}

    // show form results
    $this->text = commonTools::FormattedTextFromArray( $array );

    return sfView::SUCCESS;
  }



}
