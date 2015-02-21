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

    $this->redirectIf($this->getUser()->hasCredential('can_administrate'),
                         'admin/home');

    $profile = $this->getUser()->getProfile();

    if( ! isset($profile) ){
      // if there is no profile, most likely this is an administrator that
      // was previously logged in as a user. So destroy the session
      // by signing out
      $this->getUser()->signOut();
      $this->redirect('main/index'); // force login 
    }


    // update user credentials if user finished ITB but cannot coach clients
    if($profile->hasTakenInTheBones() && ! $this->getUser()->hasCredential('can_coach_clients') ){
      $profile->setCoachCredential();
      // perform a logout so that credentials will be updated on next login
      $this->redirect('profile/homeUpdated');
    }

    $this->redirectUnless($this->getUser()->hasCredential('can_coach_clients'),
                         'profile/homeClient');

    // update this coach if they have taken synergy or has finished the bridging content
    $profile->updateSynergyStatus();

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeHomeUpdated(sfWebRequest $request) 
  {
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
      $message = $request->getParameter('feedback') . "\n\nThis email was sent by ".$profile->getName().", ".$profile->getEmail()."\n";
 
      $emailSent = commonTools::sendSwiftEmail($this,
         array(
           'mailto'      =>  'registration@thecoaches.com',
           //'mailto'      =>  'ping@me.com',
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

}
