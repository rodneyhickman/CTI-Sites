<?php

/**
 * flexform actions.
 *
 * @package    sf_sandbox
 * @subpackage flexform
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class flexformActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('flexform', 'chooseForm');

  }

  public function executeShow( sfWebRequest $request)
  {
    // require logged-in user
    if(!$this->getUser()->isAuthenticated()){
      $this->redirect('flexform/login');
    }

    $this->user = $this->getUser();
    $this->profile_id = $this->getUser()->getProfileIdFromEmail();
    $this->flexform_id = $request->getParameter('id', 0);
    $this->flexform = FlexformPeer::retrieveByPk( $this->flexform_id );

    $this->flexform_submission = FlexformSubmissionPeer::getSubmission( $this->user, $this->flexform );
    $this->answers = $this->flexform_submission->getAnswerArray();
    
    $this->msg = '';
    $this->redirect = '';
    $this->admin = 0;

    return sfView::SUCCESS;
  }

  public function executeShowProcess( sfWebRequest $request)
  {
    // require logged-in user
    if(!$this->getUser()->isAuthenticated()){
      $this->redirect('flexform/login');
    }

    $this->user                = $this->getUser();
    $this->flexform_id         = $request->getParameter('id', 0);
    $this->flexform            = FlexformPeer::retrieveByPk( $this->flexform_id );
    $this->flexform_submission = FlexformSubmissionPeer::getSubmission( $this->user, $this->flexform );
    $this->msg                 = $this->flexform_submission->saveAnswers( $request );

    if($this->msg != ''){
      $this->answers = $this->flexform_submission->getAnswerArray();
      return $this->setTemplate('show');
    }


    $this->redirect('flexform/thankYou');
  }

  // http://ww2.thecoaches.com/scholarship/index.php/flexform/chooseForm

  public function executeChooseForm( sfWebRequest $request)
  {

    $flexform = FlexformPeer::getActiveFORL();
    $this->redirect('flexform/show?id='.$flexform->getId());


    // require logged-in user
    if(!$this->getUser()->isAuthenticated()){
      $this->redirect('flexform/login');
    }

    $this->flexforms = FlexformPeer::getActiveForms();


    return sfView::SUCCESS;
  }

  public function executeThankYou( sfWebRequest $request)
  {
    $this->getContext()->getUser()->signOut();
    return sfView::SUCCESS;
  }


  // ============= Admin edit =============

  public function executeEdit( sfWebRequest $request)
  {
    // require logged-in user
    $admin_user = $this->getUser();
    $guard_user = $admin_user->getGuardUser();
    if(!$admin_user->isAuthenticated() || ! isset($guard_user) ){ // all guard users are admins (this may change)
      $this->redirect('admin/leadership');
    }


    $this->profile_id = $request->getParameter('profile_id', 0);
    $this->user     = ProfilePeer::retrieveByPk($this->profile_id);
    
    $this->flexform_submission = FlexformSubmissionPeer::getMostRecentFORL( $this->profile_id );
    $this->flexform =  $this->flexform_submission->getFlexform();
    $this->flexform_id = $this->flexform->getId();

    $this->answers = $this->flexform_submission->getAnswerArray();
    
    $this->msg = '';
    $this->redirect = '';
    $this->admin = 1;

    $this->setTemplate('show');
    return sfView::SUCCESS;
  }

  public function executeEditProcess( sfWebRequest $request)
  {
    // require logged-in user
    $admin_user = $this->getUser();
    $guard_user = $admin_user->getGuardUser();
    if(!$admin_user->isAuthenticated() || ! isset($guard_user) ){ // all guard users are admins (this may change)
      $this->redirect('admin/leadership');
    }

    $this->profile_id = $request->getParameter('profile_id', 0);
    $this->user     = ProfilePeer::retrieveByPk($this->profile_id);
    
    $this->flexform_id         = $request->getParameter('id', 0);
    $this->flexform            = FlexformPeer::retrieveByPk( $this->flexform_id );
    $this->flexform_submission = FlexformSubmissionPeer::getSubmission( $this->user, $this->flexform );
    $this->msg                 = $this->flexform_submission->saveAnswers( $request );

    if($this->msg != ''){
      $this->answers = $this->flexform_submission->getAnswerArray();
      return $this->setTemplate('show');
    }

    $this->redirect('leadership/forlApplicant?id='.$this->profile_id);
  }


  // ============= LOGIN / LOGOUT =============

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
      $redirect = 'flexform/chooseForm';
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
    $this->redirect('flexform/login?msg='.$msg);

  }

  public function executeLogout(sfWebRequest $request)
  {
    // sign in this user session
    $this->getContext()->getUser()->signOut();

    //$this->forward('main', 'login');
    $this->redirect('flexform/index');
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

    $msg = ProfilePeer::RequestNewPassword( $email, 'flexform' ); // sends email or returns error msg

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
      $this->redirect('flexform/login');
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
      $this->redirect('flexform/login');
    }

    if($password != $verify){
      $this->redirect('flexform/newPassword?k='.$this->key.'&msg=Passwords don\'t match, please try again');
    }

    $profile->setNewPassword( $password );

    $this->redirect('flexform/newPassword?k='.$this->key.'&ok=1');
  }

}
