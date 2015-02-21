<?php

/**
 * profile actions.
 *
 * @package    sf_sandbox
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class profileActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('profile', 'home');
  }


  public function executeChangePassword(sfWebRequest $request)
  {
    $profile    = $this->getUser()->getProfile();
    $this->form = new ChangePasswordForm();

    if($request->isMethod('post')){
      $this->form->bind($request->getParameter('register'));
      if ($this->form->isValid()){
        $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
        $user->setPassword( $request->getParameter('register[password]') );
        $user->save();                           
        $this->redirect('profile/passwordChanged');
      }
    }
    return sfView::SUCCESS;
  }

  public function executePasswordChanged(sfWebRequest $request)
  {
    return sfView::SUCCESS;    
  }


  public function executeRequestEmailChange(sfWebRequest $request)
  {
    $profile    = $this->getUser()->getProfile();
    $this->form = new RequestEmailChangeForm();

    if($request->isMethod('post')){
      $this->form->bind($request->getParameter('register'));
      if ($this->form->isValid()){
        $email = $request->getParameter('register[emailaddress]');
        $profile->setNewEmailAddress($email);

        // create random key
        $rk = commonTools::randomKey();
        $profile->setResetKey($rk);

        // create email 
        $domain  = sfConfig::get('app_base_domain');
        $subject = 'Change Email Address Request for CTI Coach Mentor Program';                                                      
        $body    = "
You have requested a new email address for your account at CTI. Use the link below to verify this email address. Access to this link is only valid for 30 minutes.

http://$domain/main/changeEmail/rk/$rk


If you have not requested to change to new email address, please ignore this message.

Thank you,
The Coaches Training Institute\n
";

        if( preg_match("/thecoaches/",$email) ){
            $mailfrom = 'thomas@modelsmith.com';
          } else {
            $mailfrom = 'registration@thecoaches.com';
          }
        $number_sent = commonTools::sendSwiftEmail($this,
          array('mailto'      =>  $email,
                'mailfrom'    =>  $mailfrom,
                'mailsubject' =>  $subject,
                'mailbody'    =>  $body,
                'cc'          =>  '',
                'bcc'         =>  '',
                )); 
        
        $this->redirect('profile/emailChangeRequestSent');
      }
    }


    return sfView::SUCCESS;
  }


  public function executeEmailChangeRequestSent(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeChangeEmail(sfWebRequest $request)
  {
    $profile    = $this->getUser()->getProfile();

    $new_email_address = $profile->getNewEmailAddress();
    $result = $profile->changeEmailAddress( $new_email_address );
   
    if($result == true){
      $this->redirect('profile/emailChanged');
    } 
    else {
      $this->redirect('profile/emailAlreadyUsed');
    }

    return sfView::SUCCESS;
  }


  public function executeEmailChanged(sfWebRequest $request)
  {
    return sfView::SUCCESS;    
  }

  public function executeEmailAlreadyUsed(sfWebRequest $request)
  {
    return sfView::SUCCESS;    
  }


  public function executeHome(sfWebRequest $request)
  { // do not add credentials to this page in security.yml
    // credentials are handled here
    
    $profile = $this->getUser()->getProfile();


    $this->redirectIf($this->getUser()->hasCredential('can_administrate'),
                         'admin/home');

    // update user credentials if user finished certification but cannot yet coach clients
    // [NOTE: this test is also performed in admin/executeSignInAs() - the evils of duplicate code!] 
    if($profile->hasFinishedCertification() && ! $this->getUser()->hasCredential('can_coach_clients') ){
      $profile->setCoachCredential();
      // perform a logout so that credentials will be updated on next login
      $this->redirect('profile/homeUpdated');
    }

    // redirect students to homeClient page
    $this->redirectUnless($this->getUser()->hasCredential('can_coach_clients'),
                         'profile/homeClient');

    // show coach home page
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeHomeUpdated(sfWebRequest $request) 
  {
    $profile = $this->getUser()->getProfile();

    $this->has_finished = $profile->hasFinishedCertification() ? 'Yes' : 'No';
    $this->is_faculty   = $profile->isFacultyCoach() ? 'Yes' : 'No';

    return sfView::SUCCESS;    
  }


  public function executeHomeClient(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;    
  }

  public function executeHomeAdmin(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;    
  }


  public function executeEdit(sfWebRequest $request)
  {
    $profile     = $this->getUser()->getProfile();
    $this->email = $profile->getEmail();

    if($request->isMethod('post')){
      $profile->fromArray($request->getParameterHolder()->getAll(), BasePeer::TYPE_FIELDNAME);
      $profile->setTimeZone($request->getParameter('time_zone'));
      $profile->save();
      $this->message = 'Changes have been saved';
    }

    if($this->getUser()->hasCredential('can_administrate')){
      $this->form = new CoachProfileEditForm(array(
         'name'      => $profile->getName(),
         'phone'     => $profile->getPhone(),
      ));
    } 
    else if($this->getUser()->hasCredential('can_coach_clients')){
      $this->form = new CoachProfileEditForm(array(
         'name'      => $profile->getName(),
         'location'  => $profile->getLocation(),
         'time_zone' => $profile->getTimeZone(),
         'phone'     => $profile->getPhone(),
         'niche'     => $profile->getNiche(),
         'expertise' => $profile->getExpertise(),
      ));
    } 
    else {
      $this->form = new ClientProfileEditForm(array(
         'name'      => $profile->getName(),
         'location'  => $profile->getLocation(),
         'time_zone' => $profile->getTimeZone(),
         'phone'     => $profile->getPhone(),
      ));
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }


  public function executeEditClient(sfWebRequest $request)
  {
    $this->form = new ClientProfileEditForm();
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }


  public function executeAvailability(sfWebRequest $request)
  {
    $profile     = $this->getUser()->getProfile();

    if($request->isMethod('post')){
      $profile->setAvailability($request->getParameter('availability'));
      $this->message = 'Changes have been saved';
    }

    // Note:  1 = available, 0 = not available
    $this->form = new AvailabilityForm(array(
      'availability' => $profile->getAvailability()
    ));

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }


  public function executeAddClient(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $profile     = $this->getUser()->getProfile();
    $this->profile = $profile;

    $contact_ids = $request->getParameter('contact_id');
    if($request->isMethod('post')){
      foreach($contact_ids as $contact_id){
        $profile->setAddClient( $contact_id );
      }
    }

    // get clients who have contacted
    $this->contacts = $profile->getContacts();

    // get clients already coaching
    $this->clients = $profile->getClients();

    return sfView::SUCCESS;
  }


  public function executeFeedback(sfWebRequest $request)
  {
    $profile     = $this->getUser()->getProfile();

    if($request->isMethod('post')){
      $profile->addFeedbackComment($request->getParameter('feedback'));

      // send email
      $message = $request->getParameter('feedback');
      $emailSent = commonTools::sendSwiftEmail($this,
         array(
               'mailto'      =>  'registration@thecoaches.com',
               'mailfrom'    =>  $profile->getEmail(),
               'mailsubject' =>  'FEEDBACK from CTI Coach Match Program',
               'mailbody'    =>  $message,
               'cc'          =>  '',
               'bcc'         =>  ''
               )); 

      $this->redirect('profile/feedbackSent');
    }

    $this->form = new FeedbackForm();

    $c = new Criteria();
    $c->add(FeedbackPeer::PROFILE_ID, $profile->getId() );
    $c->add(FeedbackPeer::ATTRIBUTE, 'comment' );
    $c->addDescendingOrderByColumn(FeedbackPeer::FEEDBACK_DATE);
    $this->feedbacks = FeedbackPeer::doSelect( $c );
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeFeedbackSent(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeReachedContactLimit(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }


  public function executeSeeMyProfile(sfWebRequest $request)
  {
    $profile = $this->getUser()->getProfile();
    $id      = $profile->getId();

    $connection = Propel::getConnection();
    $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $countryGroup = $profile->getCountryGroup();
    $this->cg = $countryGroup;

    $this->words = '(see my profile)';

    $query = "SELECT profile.id,name,location,niche,expertise FROM profile WHERE profile.id=$id ORDER BY profile.id DESC";
    $query = sprintf($query);
    $statement = $connection->prepare($query);
    $statement->execute();
    $this->records = array();
    while($record = $statement->fetch(PDO::FETCH_OBJ)){
      // vars are: id, name, location, niche, expertise
        
      array_push($this->records,$record); 
	    
    }

    $this->form = new SearchForm();
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    //$this->setTemplate('searchResults');

    return sfView::SUCCESS;
  }

  public function executeEditBio(sfWebRequest $request)
  {
    $profile     = $this->getUser()->getProfile();
    $this->email = $profile->getEmail();

    if($request->isMethod('post')){
      $profile->fromArray($request->getParameterHolder()->getAll(), BasePeer::TYPE_FIELDNAME);
      $profile->setFirstName($request->getParameter('first_name'));
      $profile->setLastName($request->getParameter('last_name'));
      $profile->setMiddleInitial($request->getParameter('middle_initial'));
      $profile->setCoachingCredential($request->getParameter('coaching_credential'));
      $profile->setStreetAddress($request->getParameter('street_address'));
      $profile->setCity($request->getParameter('city'));
      $profile->setProvState($request->getParameter('prov_state'));
      $profile->setCountry($request->getParameter('country'));
      $profile->setCompanyName($request->getParameter('company_name'));
      $profile->setBusinessPhone($request->getParameter('business_phone'));
      $profile->setWebsite($request->getParameter('website'));
      $profile->setNiche1($request->getParameter('niche1'));
      $profile->setNiche2($request->getParameter('niche2'));
      $profile->setNiche3($request->getParameter('niche3'));
      $profile->setCertificationPodName($request->getParameter('cert_pod_name'));
      $profile->setLeadershipGroupName($request->getParameter('cti_leadership_group'));
      $profile->setProfExperiences($request->getParameter('professional_life_exp'));
      $profile->setBio($request->getParameter('bio'));
      $profile->setMemberships($request->getParameter('memberships'));
      $profile->setTimeZone($request->getParameter('time_zone'));
      $profile->save();
      $this->message = 'Changes have been saved';
    }

    if($this->getUser()->hasCredential('can_administrate')){
      $this->form = new CoachBioEditForm(array(
         'first_name'          => $profile->getFirstName(),
         'last_name'           => $profile->getLastName(),
         'middle_initial'      => $profile->getMiddleInitial(),
         'coaching_credential' => $profile->getCoachingCredential(),
         'street_address'      => $profile->getStreetAddress(),
         'city'                => $profile->getCity(),
         'prov_state'          => $profile->getProvState(),
         'country'             => $profile->getCountry(),
         'company_name'        => $profile->getCompanyName(),
         'business_phone'      => $profile->getBusinessPhone(),
         'website'             => $profile->getWebsite(),
         'niche1'              => $profile->getNiche1(),
         'niche2'              => $profile->getNiche2(),
         'niche3'              => $profile->getNiche3(),
         'cert_pod_name'       => $profile->getCertificationPodName(),
         'cti_leadership_group'  => $profile->getLeadershipGroupName(),
         'professional_life_exp' => $profile->getProfExperiences(),
         'bio'                 => $profile->getBio(),
         'memberships'         => $profile->getMemberships(),
         'time_zone'           => $profile->getTimeZone()
      ));
    } 
    else if($this->getUser()->hasCredential('can_coach_clients')){
      $this->form = new CoachBioEditForm(array(
         'first_name'          => $profile->getFirstName(),
         'last_name'           => $profile->getLastName(),
         'middle_initial'      => $profile->getMiddleInitial(),
         'coaching_credential' => $profile->getCoachingCredential(),
         'street_address'      => $profile->getStreetAddress(),
         'city'                => $profile->getCity(),
         'prov_state'          => $profile->getProvState(),
         'country'             => $profile->getCountry(),
         'company_name'        => $profile->getCompanyName(),
         'business_phone'      => $profile->getBusinessPhone(),
         'website'             => $profile->getWebsite(),
         'niche1'              => $profile->getNiche1(),
         'niche2'              => $profile->getNiche2(),
         'niche3'              => $profile->getNiche3(),
         'cert_pod_name'       => $profile->getCertificationPodName(),
         'cti_leadership_group'  => $profile->getLeadershipGroupName(),
         'professional_life_exp' => $profile->getProfExperiences(),
         'bio'                 => $profile->getBio(),
         'memberships'         => $profile->getMemberships(),
         'time_zone'           => $profile->getTimeZone()
      ));
    } 
    else {
      $this->form = new ClientProfileEditForm(array(
         'name'      => $profile->getName(),
         'location'  => $profile->getLocation(),
         'time_zone' => $profile->getTimeZone(),
         'phone'     => $profile->getPhone(),
      ));
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }




}
