<?php

/**
 * main actions.
 *
 * @package    sf_sandbox
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mainActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    // if user logged in, redirect
    if($this->getUser()->isAuthenticated()){
      $this->redirect('profile/home');
    }

    // otherwise show forms
    $this->form    = new sfGuardFormSignin();
    $this->regform = new RegisterForm();

    // login and register forms
    return sfView::SUCCESS;
  }

  public function executeIndex2(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    // if user logged in, redirect
    if($this->getUser()->isAuthenticated()){
      $this->redirect('profile/home');
    }

    // otherwise show forms
    $this->form    = new sfGuardFormSignin();
    $this->regform = new RegisterForm();

    // login and register forms
    return sfView::SUCCESS;
  }

  public function executeRegisterStepOne(sfWebRequest $request)
  {
    $this->regform = new RegisterForm();

    if($request->isMethod('post')){
      
      $this->regform->bind($request->getParameter('register'));
      if ($this->regform->isValid())
        {

          $email = $request->getParameter('register[email]');

          $c = new Criteria();
          $c->add(StudentPeer::EMAIL, $email );
          $student = StudentPeer::doSelectOne( $c );
      
          if(isset($student)){

            // create profile and sfGuardUser here
            try {
              $profile = ProfilePeer::addNewProfile(
                 $request->getParameter('register[name]'),
                 $email,
                 $request->getParameter('register[password]'),
                 $student
              );

              // signin
              $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
              $this->getContext()->getUser()->signIn( $user );

              // have user read policy
              $this->redirect('main/policy');
            }
            catch (Exception $e) {
              $this->redirect('main/alreadyRegistered?msg='.$e->getMessage());
            }

          }
          else {
            $this->redirect('main/emailNotFound');
          }
        }
    }    
    //$this->redirect('main/index');
  }

  public function executePolicy(sfWebRequest $request)
  { // is_secure: on  (profile is created in executeRegisterStepOne() )

    $profile     = $this->getUser()->getProfile();

    if($request->isMethod('post')){
      if($request->getParameter('accept') != ''){
        $profile->setAgreeClicked( date("Y-m-d h:m:s") );
        $profile->save();
        $this->redirect('profile/index');
      }
      else{
        $this->getUser()->setAuthenticated(false);
        $this->redirect('main/index');
      }
    }

    $countryGroup = $profile->getCountryGroup();
    if($countryGroup > 1){
      $this->synergy = 'Synergy';
    }
    else {
      $this->synergy = '"In The Bones"';
    }

    return sfView::SUCCESS;
  }

  public function executeEmailNotFound(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeAlreadyRegistered(sfWebRequest $request)
  {
    $this->msg = $request->getParameter('msg');
    return sfView::SUCCESS;
  }

  public function executeForgotPassword(sfWebRequest $request)
  {
    $this->form = new ForgotPasswordForm();
    if($request->isMethod('post')){
      $email = $request->getParameter('email');
      if($email != ''){
        $c = new Criteria();
        $c->add(ProfilePeer::EMAIL, $email);
        $profile = ProfilePeer::doSelectOne( $c );
        if(isset($profile)){

          // create random key
          $rk = $this->randomKey();
          $profile->setResetKey($rk);

          // create email 
          $domain  = sfConfig::get('app_base_domain');
          $subject = 'New Password Request for CTI Coach Mentor Program';                                                      
          $body    = "
You have requested a new password for your account at CTI. Use the link below to access the new password page. Access to this link is only valid for 30 minutes.

http://$domain/main/changePassword/rk/$rk

If you have not requested a new password, please ignore this message.

Thank you,
The Coaches Training Institute\n
";

         $number_sent = commonTools::sendSwiftEmail($this,
            array('mailto'      =>  $profile->getEmail(),
                  'mailfrom'    =>  'registration@thecoaches.com',
                  'mailsubject' =>  $subject,
                  'mailbody'    =>  $body,
                  'cc'          =>  '',
                  'bcc'         =>  '',
                  )); 
        }
        $this->redirect('main/forgotThankYou');
      }
    }
    return sfView::SUCCESS;
  }

  public function executeChangePassword(sfWebRequest $request)
  {
    $rk = $request->getParameter('rk');
    if($rk != ''){
      $c = new Criteria();
      $c->add(ProfileExtraPeer::VALUE,$rk);
      //$c->add  ... 30 minute limit
      $extra = ProfileExtraPeer::doSelectOne( $c );
      if(isset($extra)){

        // get profile
        $c = new Criteria();
        $c->add(ProfilePeer::ID, $extra->getProfileId() );
        $profile = ProfilePeer::doSelectOne( $c );

        if(isset($profile)){
          // login
          $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
          $this->getContext()->getUser()->signIn( $user );
          $this->redirect('profile/changePassword');
        }
      }
    }
    $this->redirect('main/index');

    //return sfView::SUCCESS;
  }

  public function executeChangeEmail(sfWebRequest $request)
  {
    $rk = $request->getParameter('rk');
    if($rk != ''){
      $c = new Criteria();
      $c->add(ProfileExtraPeer::VALUE,$rk);
      //$c->add  ... 30 minute limit
      $extra = ProfileExtraPeer::doSelectOne( $c );
      if(isset($extra)){

        // get profile
        $c = new Criteria();
        $c->add(ProfilePeer::ID, $extra->getProfileId() );
        $profile = ProfilePeer::doSelectOne( $c );

        if(isset($profile)){
          // login
          $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
          $this->getContext()->getUser()->signIn( $user );
          $this->redirect('profile/changeEmail');
        }
      }
    }
    $this->redirect('main/index');

    //return sfView::SUCCESS;
  }

  public function executeForgotThankYou(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeThankYou(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeTestUnreg(sfWebRequest $request)
  {
    $this->form = new UnregForm();

    if($request->isMethod('post')){
      if($request->getParameter('key') == 'up844'){
        ProfilePeer::UnregisterProfile( $request->getParameter('email') );
        $this->redirect('main/index');
      }
    }
    return sfView::SUCCESS;
  }

  private function randomKey()
  {
    $text = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789A";
    $length = 16;
    $x = 0;
    $key = "";
    while ($x<$length) {
      $ranNo = rand(1,strlen($text))+1;
      $a = substr($text, $ranNo, 1);
      $key = $key . $a; 
      if($x == 3 || $x == 7 || $x == 11){
        $key = $key . '-';
      }
      $x = $x + 1;
    }
    return $key;
  }

}
