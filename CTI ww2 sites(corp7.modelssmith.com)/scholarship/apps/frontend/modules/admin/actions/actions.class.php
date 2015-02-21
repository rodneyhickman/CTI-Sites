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



/* NEXT STEPS
   - for applicants, add excel download (show leadership or coach training download or both if they exist)
   - add applicant delete
   - for leadership applicants, add group excel download 
   - for coach training applicants, add admin page
   - for coach training applicanats, add group excel download
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
        $c->add(ProfilePeer::EMAIL1, $email);
        $profile = ProfilePeer::doSelectOne( $c );
        if(isset($profile)){

          // create random key
          //$rk = CommonTools::randomKey();
          $rk = $profile->newResetKey();

          // create email
          $domain  = sfConfig::get('app_base_domain');
          $subject = 'New Password Request for CTI Coach Mentor Program';                                 

          $body    = "
You have requested a new password for your account at CTI. Use the link below to access the new password page. Access to this link is only valid for 30 minutes.

http://$domain/admin/changePassword/rk/$rk

If you have not requested a new password, please ignore this message.

Thank you,
The Coaches Training Institute\n
";

         $number_sent = commonTools::sendSwiftEmail($this,
            array('mailto'      =>  $profile->getEmail1(),
                  'mailfrom'    =>  'registration@thecoaches.com',
                  'mailsubject' =>  $subject,
                  'mailbody'    =>  $body,
                  'cc'          =>  '',
                  'bcc'         =>  '',
                  ));
        }
        $this->redirect('admin/forgotThankYou');
      }
    }
    return sfView::SUCCESS;
  }


  public function executeChangePassword(sfWebRequest $request)
  {
    $rk = $request->getParameter('rk');
    if($rk != ''){
      $c = new Criteria();
      $c->add(ProfilePeer::SECRET,$rk);
      //$c->add  ... 30 minute limit
      $profile = ProfilePeer::doSelectOne( $c );

      if(isset($profile)){
        // login
        $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
        $this->getContext()->getUser()->signIn( $user );
        $this->redirect('profile/changePassword');
      }
    }
    $this->redirect('admin/index');

    //return sfView::SUCCESS;
  }


  public function executeForgotThankYou(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }





 /* ============== Leadership Admin Actions ==================== */

  public function executeLeadership(sfWebRequest $request){
    // admin logged in here are listed in the sf_guard_user table

/* TO DO:
 * get username from sf_guard_user
 * Create a profile for this sf_guard_user, if not already there
 * $user = $this->getUser();
 * $email = $user->getGuardUser()->getUsername();
 */


    $user = $this->getUser();
    $guard_user = $user->getGuardUser();
    if(! isset($guard_user) ){ // in case user was logged in using Filemaker and not sfguarduser
      $this->getUser()->signOut();
      $this->redirect('admin/index');
    }
    $email = $user->getGuardUser()->getUsername();
    $profile = ProfilePeer::GetProfileFromEmail($email);

    $this->key =  $profile->newResetKey( );

    //$this->key = 0;
    return sfView::SUCCESS;
  }

  public function executeVerifyKey(sfWebRequest $request){
    $key    = $request->getParameter('key');
    $secret = $request->getParameter('secret');
    $profile = ProfilePeer::retrieveByKey($key);

    if(isset($profile) && $secret == 'fjgh15t'){
      $profile->newResetKey( ); // change the key
      $result = array('status'=> 'ok','email'=> $profile->getEmail1(), 'id'=>$profile->getId() );
    }
    else {
      $result = array('status'=>'fail','email'=>'');
    }
    echo json_encode($result);
    return sfView::NONE;
  }

 /* ============== Certification Admin Actions ==================== */

  public function executeCertification(sfWebRequest $request){

 

    return sfView::SUCCESS;
  }


  /* ===== tests ===== */

  public function executeFlexformReader(sfWebRequest $request){
    $this->formtext = $request->getParameter('formtext');
    if( $this->formtext != ''){
      $this->sections = FlexformReader::importFromText(  $this->formtext );
    }
    return sfView::SUCCESS;
  }

  public function executeFlexformImport(sfWebRequest $request){
    $this->formtext = $request->getParameter('formtext', $this->getUser()->getAttribute('formtext') );
    $import         = $request->getParameter('import');
    $this->formname = $request->getParameter('formname', $this->getUser()->getAttribute('formname') );
    $this->msg      = '';

    if( $this->formname != ''){
      $this->getUser()->setAttribute('formname',$this->formname);
    }

    if( $this->formtext != ''){
      $this->sections = FlexformReader::importFromText(  $this->formtext );
      $this->getUser()->setAttribute('formtext',$this->formtext);
    }

    if( $this->formtext != '' && $import == 1){
      $flexform = FlexformPeer::newFormFromSections( $this->formname, $this->sections);
      if(is_object($flexform)){
        $this->msg = 'Imported';
      }
      else {
        $this->msg = $flexform;
      }
    }
    return sfView::SUCCESS;
  }

 public function executeParam(sfWebRequest $request){
    $this->string = $request->getParameter('string');
    $this->new_string = '';
    if( $this->string != ''){
      $this->new_string = commonTools::createParamName(  $this->string );
    }
    return sfView::SUCCESS;
  }

}
