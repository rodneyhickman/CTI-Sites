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
    $this->forward('default', 'module');
  }

  public function executeHelp(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }



 public function executeTerms(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeTermsProcess(sfWebRequest $request)
  {
    $agree = $request->getParameter('agree');
    $profile = $this->getContext()->getUser()->getProfile( );

    // if yes, redirect to home
    if($agree == 'yes'){
      $profile->setAgreedToTerms('yes');
      $profile->save();
      $this->redirect('main/home');
    }

    // otherwise
    $this->redirect('main/logout');
  }

  public function executeLogout(sfWebRequest $request)
  {
    // sign in this user session
    $this->getContext()->getUser()->signOut();

    //$this->forward('main', 'login');
    return sfView::SUCCESS;
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->msg = $request->getParameter( 'msg' );
    $this->logMessage('********************************************* Login');

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


  public function executeLoginAgain(sfWebRequest $request)
  { // this action must be listed as is_secure: false in security.yml
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->msg = 'The email address or password did not match our records. Please try again.';
    $this->setTemplate('login');
  }

  public function executeLoginProcess(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $email    = $request->getParameter( 'email' );
    $password = $request->getParameter( 'password' );
    
    $result = ProfilePeer::login( $email, $password );
    $result_r = print_r($result, true);
    
    $this->logMessage('********************************************* LoginProcess');
    $this->logMessage('Login result: '.$result_r);
    if($result['status'] == 'ok' || $email == 'vesterling@earthlink.net' ){  // exception for vesterling@earthlink.net
      // get the local profile record
      $profile = ProfilePeer::retrieveByEmail( $email );

      if(!isset($profile)){
        $profile = ProfilePeer::newProfile( $email );
        if($profile->getFmid() < 1){

        }
      }

      // identify the profile to the user session
      $this->getContext()->getUser()->setProfile( $profile );

      // sign in this user session
      $this->getContext()->getUser()->signIn();


      $this->getUser()->setAttribute('result',$result);

      if( $profile->isAdmin() ){
        $this->redirect('admin/index');
      }
      $this->redirect('participant/home');
    }
   
    $msg = "The email address or password did not match our records. Please try again.";
    $this->redirect('main/loginAgain');
    //$this->redirect('main/login');
  }

  public function executeHome(sfWebRequest $request)
  {
    $profile = $this->getContext()->getUser()->getProfile( );
    if( $profile->isAdmin() ){
      $this->redirect('admin/index');
    }
    $this->redirect('participant/home');
  }

  public function executeProblem(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->result  = $this->getUser()->getAttribute('result');

    return sfView::SUCCESS;
  }

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
    $email = preg_replace("/[^A-Za-z0-9\.\-\_\@]/","",$email); // untaint

    $msg = '';

    // check whether email address exists in database
    // curl to webcomp (timeout 10 secs)
    $ch = curl_init();

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey');
    $endpoint = sfConfig::get('app_webcomp_recordexists');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$email;

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

    //execute post
    $response = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    if($httpCode == 200){
      // $result is JSON
      // if result = ok, then update transaction status in org record 
      
      if(preg_match('/ok/i',$response)){
        // find profile in local DB
        $profile = ProfilePeer::retrieveByEmail( $email );

        if(!isset($profile)){
          // create record
          $profile = ProfilePeer::newProfile( $email );
        }

        // send email with resetkey
        $resetKey = $profile->newResetKey();
        $subject = 'CTI Password Reset Request';
        $url = 'http://www.thecoaches.com' . $this->getController()->genUrl('main/newPassword?k='.$resetKey);
        $message = <<<EOM
We have received your request for a password reset. Please click the
following link to continue. If you did not make this request, please
disregard and delete this email.

$url

The Coaches Training Institute
1-800-691-6008
EOM;
        $profile->sendPortalEmail( $subject, $message );

        $msg = 'Your request has been sent. Please check your email.';

      }
      else {
        $msg = 'Your email is not on file. Please contact Customer Service at 1-800-691-6008.';
      }
    }
    else {
      // try local database here?
      $msg = 'Your email is not on file. Please contact Customer Service at 1-800-691-6008.';
    }
    
    $this->msg = $msg;
    return sfView::SUCCESS;
    //$this->redirect('main/requestNewPassword?msg='.$msg);
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
      $this->redirect('main/login');
    }
  
    $this->email = $profile->getEmail();

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
      $this->redirect('main/login');
    }

    if($password != $verify){
      $this->redirect('main/newPassword?k='.$this->key.'&msg=Passwords don\'t match, please try again');
    }

    $profile->setNewPassword( $password );
    $profile->setResetKey(''); // key is only allowed to be used once, so erase it
    $profile->save();

    $this->redirect('main/newPassword?k='.$this->key.'&ok=1');
  }



}
