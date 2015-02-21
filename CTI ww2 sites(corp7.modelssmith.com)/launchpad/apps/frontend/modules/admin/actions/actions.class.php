<?php

/**
 * admin actions.
 *
 * @package    sf_sandbox
 * @subpackage admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */



/* TODO T. Beutel 4/19/2011
 * getUser()->homePreferenceIs() method
 */

  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    $referer = $this->getRequest()->getReferer();
    if(preg_match("/(certification|leadership)/",$referer)){
      $this->getUser()->setReferer_($referer);
    }
    
    // if user logged in, redirect
    if($this->getUser()->isAuthenticated()){
      $this->redirect($this->getUser()->getReferer_());
    }

    // otherwise show forms
    $this->form    = new sfGuardFormSignin();

    // login and register forms
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
          $rk = CommonTools::randomKey();
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
                  'mailfrom'    =>  'registration@coactive.com',
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


  public function executeForgotThankYou(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }





 /* ============== Leadership Admin Actions ==================== */

  public function executeLeadership(sfWebRequest $request){

 

    return sfView::SUCCESS;
  }


 /* ============== Certification Admin Actions ==================== */

  public function executeCertification(sfWebRequest $request){

 

    return sfView::SUCCESS;
  }



}