<?php

/**
 * main actions.
 *
 * @package    sf_sandbox
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */

require('CALENDAR.class.php'); // No additional js,css or images needed

class mainActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->events = EventPeer::getEventsByDate();

    $this->years = EventPeer::getYears();
    $this->quarters = EventPeer::getQuarters();

    return sfView::SUCCESS;
  }


  public function executeYear(sfWebRequest $request)
  {
    $this->years = EventPeer::getYears();
    $this->quarters = EventPeer::getQuarters();


    $this->year = $request->getParameter( 'y' );
    $baseyear = preg_replace('/-.*/','',$this->year);
    $nowyear = Date('Y');
    if($baseyear == $nowyear){
      $this->year = Date('Y-m');
    }
   
    $events = EventPeer::getEventsByDate();

    $this->cal = new CALENDAR('full',$this->year,'true');
    //$this->cal->weeknumbers = 'right';
    $this->cal->basecolor = '689bbc'; 

    $ambassador = array( '130' => 1, '145' => 1, '148' => 1,  '157' => 1, '159' => 1, '160' => 1 );

    foreach($events as $event){
      // if($event->getCourseTypeId() >156){
      //   commonTools::logMessage( $event->getCourseTypeId().' '.$event->getNameLocation().' '.$event->getStartDate('Y-m-d').' '.$event->getEndDate('Y-m-d') );
      // }
 
      if ($event->getCourseTypeId() == 10000000) {
        $color = "#FBFFA9";
      }
      else if($event->getCourseTypeId() < 15){ // open enrollment events
        $color = "#D6FFD6";
      }
      else if ( isset($ambassador[$event->getCourseTypeId()]) || $event->getCourseTypeId() > 186 ){
        $color = "#FFD6D6";
      } 
      else {
        $color = "#D6D6FF";
      }
      $this->cal->addEvent(
        array(
          "title"=>$event->getNameLocation(),
          "from"=>$event->getStartDate('Y-m-d'),
          "to"=>$event->getEndDate('Y-m-d'),
          "color"=>$color,
          "details"=>$event->getFullDetails()." (".$event->getPublish().")"
          )
        );

    }


    return sfView::SUCCESS;

  }



  public function executeQuarter(sfWebRequest $request)
  {
    $this->years = EventPeer::getYears();
    $this->quarters = EventPeer::getQuarters();


    $this->quarter = $request->getParameter( 'q' );

    $months = EventPeer::getMonthsFromQuarter( $this->quarter );

    $events = EventPeer::getEventsByDate();

    $this->cal1 = new CALENDAR('mini',$months[0],'true');
    $this->cal1->basecolor = '689bbc'; 
    $this->cal2 = new CALENDAR('mini',$months[1],'true');
    $this->cal2->basecolor = '689bbc'; 
    $this->cal3 = new CALENDAR('mini',$months[2],'true');
    $this->cal3->basecolor = '689bbc'; 

    foreach($events as $event){
      $color = "#FFD6D6";
      if ($event->getCourseTypeId() == 10000000) {
        $color = "#FBFFA9";
      }
      $this->cal1->addEvent(
        array(
          "title"=>$event->getName(),
          "from"=>$event->getStartDate('Y-m-d'),
          "to"=>$event->getStartDate('Y-m-d'),
          "color"=>$color,
          //"starttime"=>"6:30pm",
          "details"=>$event->getFullDetails()." (".$event->getPublish().")"
          )
        );
      $this->cal2->addEvent(
        array(
          "title"=>$event->getName(),
          "from"=>$event->getStartDate('Y-m-d'),
          "to"=>$event->getStartDate('Y-m-d'),
          "color"=>$color,
          //"starttime"=>"6:30pm",
          "details"=>$event->getFullDetails()." (".$event->getPublish().")"
          )
        );
      $this->cal3->addEvent(
        array(
          "title"=>$event->getName(),
          "from"=>$event->getStartDate('Y-m-d'),
          "to"=>$event->getStartDate('Y-m-d'),
          "color"=>$color,
          //"starttime"=>"6:30pm",
          "details"=>$event->getFullDetails()." (".$event->getPublish().")"
          )
        );
    }


    return sfView::SUCCESS;

  }


// =========================================================

  public function executeEvent(sfWebRequest $request)
  {
    $this->event_id = $request->getParameter( 'id' );
    $this->event = EventPeer::retrieveByPk( $this->event_id );

    return sfView::SUCCESS;

  }

  public function executeHelp(sfWebRequest $request)
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

  public function executeLogin(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->msg = $request->getParameter( 'msg' );
    $this->logMessage('********************************************* Login');
    return sfView::SUCCESS;
  }

  public function executeLoginProcess(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $email    = $request->getParameter( 'email' );
    $password = $request->getParameter( 'password' );
    
    // Ticket #347: Adding functionality for Jill, Nick and Janaki to add new events through website.  
    // Note: These events are not stored in the FileMaker.
    // Marketing Calendar was not designed to store user profile.  Due to this, we are 
    // processing hardcoded emailid and passwords here.
    // When we require functionalities like Change password, we need to redesign the mktcal database 
    // to have profile related databases.  Referring coachmatch application will help to have the
    // Change password functionality.
    
    // Ticket #645:  Removed the janaki@coactive.com.  Added djosephson@coactive.com and susan@coactive.com		//ticket #839: Can you give Suzan and Debby administrator rights too suzanacker@gmail.com djosephson@coactive.com And remove Janaki
    if ($email == 'jschichter@coactive.com' || $email == 'nkettles@coactive.com' || $email == 'djosephson@coactive.com' || $email == 'susan@coactive.com' || $email == 'suzanacker@gmail.com' || $email == 'ping@me.com') {
        if ($password == 'event123') {
            $this->logMessage('********************************************* LoginProcess');
            $this->logMessage('Logged in user: '.$email);
            $this->getUser()->setAttribute("user", $email);
            $this->getUser()->setAuthenticated(true);
            $this->redirect('main/manageEvents');
        }
    }

    $msg = "The email address or password did not match our records. Please try again.";
    $this->redirect('main/login?msg='.$msg);
  }

  public function executeProblem(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->result = $this->getUser()->getAttribute('result');

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

  // Ticket #347: Adding functionality for Jill, Nick and Janaki to add new events through website.  
  // Note: These events are not stored in the FileMaker.

  public function executeNewEvent(sfWebRequest $request) {
    if($this->getUser()->isAuthenticated()){
        if($request->isMethod('post')){
            $this->logMessage('executing NewEvent');
            $this->params = $request->getParameterHolder()->getAll();
            $this->results = EventPeer::saveNewEvent( $this->params, $this->getUser()->getAttribute("user"));
            $this->logMessage('New Event Saved successfully');
            $this->message = 'New Event Saved successfully';
        }
    } else {
        $this->redirect('main/login');
    }
    return sfView::SUCCESS;
  }
  
  // Ticket #645: Enhancing the functionality provided for ticket #347.  
  // The enhancement is editing and deleting the events.
  public function executeManageEvents(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated()){
        $this->logMessage('executing ManageEvents');
        $page  = $request->getParameter( 'page', 1 );
        $query = $request->getParameter( 'q' );
        $msg = $request->getParameter( 'msg' );
        if ($msg != '') {
            $this->message = $msg;
        }
        $this->logMessage('Parameter page = '.$page.'; Parameter q = '.$q);
        $this->logMessage('Searching Events');
        $this->pager = EventPeer::SearchEventPager( $query, $page );
    } else {
        $this->redirect('main/login');
    }
    return sfView::SUCCESS;
  }

  public function executeEditEvent(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated()){
        $this->logMessage('executing EditEvent');
        $id = $request->getParameter('id');      
        $this->logMessage('Event id = '.$id);
        if($id > 0){
          $this->logMessage('Retrieving Event');
          $this->event = EventPeer::retrieveById($id);

          $this->forward404Unless( isset($this->event) );
          $this->logMessage('Event retrieved');
          if($request->isMethod('post')){
            $this->logMessage('Post method');
            $this->logMessage('Updating Event');
            $updatedEvent = EventPeer::updateEvent( $request->getParameterHolder()->getAll(), $this->getUser()->getAttribute("user") );
            if (isset($updatedEvent)) {
                $this->logMessage('Event updated');
                $this->message = 'Changes have been updated';
            } else {
                $this->logMessage('Event update failed');
                $this->message = 'Changes not updated, try again';
            }
          } else {
            $this->logMessage('Not post method');
          }
        }
        else {
          $this->forward404();
        }
    } else {
        $this->redirect('main/login');
    }
    return sfView::SUCCESS;
  }

  public function executeDeleteEvent(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated()){
        $this->logMessage('executing DeleteEvent');
        $id = $request->getParameter('id');
        $this->logMessage('Event id : '.$id);
        if($id > 0){  
          $this->logMessage('Retrieving Event');
          $event = EventPeer::retrieveById($id);
          if (isset($event)) {
            $this->logMessage('Event retrieved');
            $this->logMessage('Deleting Event');
            $event->delete();
            $this->message = 'Event has been deleted';
            $this->logMessage('Event deleted');
          } else {
            $this->logMessage('Event not retrieved');
            $this->forward404();  
          }
        } else {
          $this->forward404();
        }
        $this->redirect('main/manageEvents?msg='.$this->message);
    } else {
        $this->redirect('main/login');
    }
  }
}