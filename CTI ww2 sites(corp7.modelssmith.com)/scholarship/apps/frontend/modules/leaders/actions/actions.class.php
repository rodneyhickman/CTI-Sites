<?php

/**
 * leaders actions.
 *
 * @package    sf_sandbox
 * @subpackage leaders
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class leadersActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('leaders/selection');
  }

  public function executeSelection(sfWebRequest $request)
  {
    $profile_id = $request->getParameter('profile_id');
    $adminedit = $request->getParameter('adminedit');

    $this->adminpid = 0;
    
    if($profile_id > 0 && $adminedit == -1 && $this->getUser()->isAuthenticated() ){
      // get form values if this is admin edit
      $this->profile = ProfilePeer::retrieveByPk( $profile_id );

      // get all form values
      $c = new Criteria();
      $c->add(LeadersPeer::PROFILE_ID, $profile_id );
      $this->leaders = LeadersPeer::doSelectOne( $c );
      if(!$this->leaders){ // Create leadership scholarship form if none exists
        $this->leaders = new Leadership();
        $this->leaders->setProfileId( $this->profile->getId() );
        $this->leaders->save();
      }

      // adminpid becomes profile_id
      $this->adminpid = $profile_id;
    }

    $this->referer = '';
    return sfView::SUCCESS;
  }

  public function executeSelectionThankYou(sfWebRequest $request)
  {
    $this->referer = '';
    return sfView::SUCCESS;
  }



 public function executeSelectionProcess(sfWebRequest $request)
  {
    $this->leaders = $request->getParameter('leaders');
    $this->files   = $request->getParameter('files');

    $profile = ProfilePeer::getProfileFromEmail( $this->leaders['email1'] );

    // Set profile items
    if( @$this->leaders['email1'] ){
      $profile->setFirstName(       $this->leaders['first_name'] );
      $profile->setLastName(        $this->leaders['last_name'] );
      $profile->setEmail1(          $this->leaders['email1'] );
      $profile->setPermAddress1(    $this->leaders['perm_address1'] );
      $profile->setPermAddress2(    $this->leaders['perm_address2'] );
      $profile->setPermCity(        $this->leaders['perm_city'] );
      $profile->setPermStateProv(   $this->leaders['perm_state_prov'] );
      $profile->setPermZipPostcode( $this->leaders['perm_zip_postcode'] );
      $profile->setPermCountry(     $this->leaders['perm_country'] );
      $profile->setTelephone1(      $this->leaders['telephone1'] );
      $profile->setTelephone2(      $this->leaders['telephone2'] );
    }
    $profile->save();


    // set leaders items
    $c = new Criteria();
    $c->add(LeadersPeer::PROFILE_ID,$profile->getId());
    $leaders = LeadersPeer::doSelectOne( $c );

    if(!$leaders){
      $leaders = new Leaders();
    }

    $leaders->setProfileId( $profile->getId() );
    $leaders->save();

    $leaders->setPhoneOffice(          $this->leaders['phone_office'] );
    $leaders->setTimeZone(             $this->leaders['time_zone'] );

    $leaders->setSkype(                $this->leaders['skype'] );

    $leaders->setCredentials(          $this->leaders['credentials'] );
    //$leaders->setResume(               $this->leaders['resume'] );
    //$leaders->setPhoto(                $this->leaders['photo'] );
    $leaders->setLanguageFluency(      $this->leaders['language_fluency'] );
    $leaders->setLeadershipTribe(      $this->leaders['leadership_tribe'] );
    $leaders->setAssistedInTribe(      $this->leaders['assisted_in_tribe'] );
    $leaders->setTribeName(            $this->leaders['tribe_name'] );

    //$leaders->setLeaderRecommendation( $this->leaders['leader_recommendation'] );

    $leaders->setInitials(             $this->leaders['initials'] );

    $leaders->setEducationHistory(  $this->leaders['education_history'] );
    $leaders->setLeadingExperience( $this->leaders['leading_experience'] );
    $leaders->setEnrollmentExperience(  $this->leaders['enrollment_experience'] );
    
    $leaders->setWhyWantToLead(  $this->leaders['why_want_to_lead'] );
    $leaders->setLifePurpose(  $this->leaders['life_purpose'] );
    $leaders->setQuest(  $this->leaders['quest'] );
    


    // file uploads


    foreach ($request->getFiles() as $uploadedFileArray) { // assumes only one array
       // Example: $uploadedFileArray = Array ( [resume] => Array ( [error] => 0 [name] => Test Resume.doc [type] => application/msword [tmp_name] => /tmp/phpuSH7QW [size] => 19456 ) [photo] => Array ( [error] => 0 [name] => h.png [type] => image/png [tmp_name] => /tmp/phpRW5IVQ [size] => 27074 ) [leader_recommendation] => Array ( [error] => 0 [name] => Leader Recommendation.doc [type] => application/msword [tmp_name] => /tmp/phpwA5gYM [size] => 19456 ) )
      foreach($uploadedFileArray as $index => $uploadedFile) {
        $uploadedFile["name"] = preg_replace('/[^A-Za-z0-9\-\.\_]/','-',$uploadedFile["name"]); // replace non-char with dash
        move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$profile->getIdentifier().'-'.$uploadedFile["name"]);
        
        if($index == 'resume'){ // first file
          $leaders->setResume( $profile->getIdentifier().'-'.$uploadedFile["name"] );
        } 
        else if($index == 'photo') {
          $leaders->setPhoto( $profile->getIdentifier().'-'.$uploadedFile["name"] );
        }
        else if($index == 'leader_recommendation') {
          $leaders->setLeaderRecommendation( $profile->getIdentifier().'-'.$uploadedFile["name"] );
        }
        $index++;
      }
    }

    // Save field data
    $leaders->save();


    // Format results for email
    $array    = $profile->getLeaderSelectionArray();
    $text     = commonTools::FormattedTextFromArray( $array );
    $subject  = "Form Results from Leaders Form";
    $headers  = "From: webserver@thecoaches.com\r\n";
    $to       = "register@thecoaches.com";
    //$to       = "ping@me.com";

    // prepare email body text
    $body = "Form for ".$profile->getFirstName().". Please keep this information for your records.\n\n";
    $body .= $text;

    // Send email
    $sent = mail($to, $subject, $body, $headers) ;

    //$this->redirect('executivecoach/thankYou');  // if form results not needed below

    // show form results
    $this->referer = 'selectionThankYou';
    $this->text = commonTools::FormattedTextFromArray( $array );
    return sfView::SUCCESS;
  }


}
