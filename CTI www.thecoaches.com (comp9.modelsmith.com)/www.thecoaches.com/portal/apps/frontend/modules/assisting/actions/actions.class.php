<?php

/**
 * assisting actions.
 *
 * @package    sf_sandbox
 * @subpackage assisting
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class assistingActions extends sfActions
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

  public function executeRegistration(sfWebRequest $request)
  {
    $student = $this->getContext()->getUser()->getStudent();
    $this->events = $student->getEligibleAssistingEvents();
    return sfView::SUCCESS;
  }

 

  public function executeRegisterStep1(sfWebRequest $request)
  {
    // Note: This step does not require user to be logged in. This step captures the
    // user's registration wishes from the public assisting page (http://www.thecoaches.com/coach-training/be-an-assistant/index-portal.html)
    // and stores them in the session. It then redirects to registerStep2, which does require a login.

    // get parameter holder
    $this->params = $request->getParameterHolder()->getAll();

    foreach($this->params as $key => $value){ // loop through ALL events (event1:ATL, event1:SR, event1:DC, event2:ATL ...)
      // find only those that have numeric IDs
      if(preg_match('/event1/',$key) && preg_match('/\d+:/',$value)){
        $event1 = preg_replace('/:.*/','',$value); // remove everything after and including colon ':'
      }
      else if(preg_match('/event2/',$key) && preg_match('/\d+:/',$value)){
        $event2 = preg_replace('/:.*/','',$value); // remove everything after and including colon ':'
      }
      else if(preg_match('/event3/',$key) && preg_match('/\d+:/',$value)){
        $event3 = preg_replace('/:.*/','',$value); // remove everything after and including colon ':'
      }
    }

    // reporting: show message if frontend_dev
    $register_log = '/tmp/portal_assist.log';
    $info = Date('Y-m-d H:i:s')." registerStep1: event IDs: $event1 $event2 $event3\n";
    file_put_contents($register_log,$info,FILE_APPEND);

    // Ticket# 411:  Disabled the generic 404 error.  Added a contextual 
    // error message "No event is selected.  Please select an event to register to assist."
    if (!($event1 > 0 || $event2 > 0 || $event3 > 0)) {
        $this->redirect('main/noEventSelected');
    }
    //$this->forward404Unless($event1 > 0 || $event2 > 0 || $event3 > 0);

    // store redirect in case we are diverted to login page
    $this->getUser()->setAttribute('redirect', 'assisting/registerStep2');

    // store parameters
    $this->getUser()->setAttribute('event1', $event1);
    $this->getUser()->setAttribute('event2', $event2);
    $this->getUser()->setAttribute('event3', $event3);

   
    // redirect to registerStep2
    $this->redirect('assisting/registerStep2');

    return sfView::SUCCESS;
  }
  
  public function executeNoEventSelected(sfWebRequest $request) {
      return sfView::SUCCESS;
  }
  
  public function executeRegisterStep2(sfWebRequest $request)
  {
    $student = $this->getContext()->getUser()->getStudent();

    $this->getUser()->setAttribute('redirect', '');

    // get stored parameters
    $this->event1 = $this->getUser()->getAttribute('event1');
    $this->event2 = $this->getUser()->getAttribute('event2');
    $this->event3 = $this->getUser()->getAttribute('event3');
    
//    $this->event1 = 19163;  //jan 10, 2014
//    $this->event1 = 19235;  //feb 4, 2014
//      $this->event1 = 19162; //dec 6, 2013
//    $this->event2 = 19232;
//    $this->event3 = 21108;
    
    $this->getUser()->setAttribute('event1', 'continue');
    $this->getUser()->setAttribute('event2', 'continue');
    $this->getUser()->setAttribute('event3', 'continue');

    // assign event1 if available
    if ($this->event1 > 0) {
        $event1_status = '';
        $event1_obj    = EventPeer::retrieveByFmid( $this->event1 );
        if( isset($event1_obj)){
          $event_id = $event1_obj->getId();
          if($student->eventIdIsEligible( $event_id )){
            // register enrollment and redirect
            $result = $student->assist( $event_id );
            $this->msg = $result['msg'];
            $enrollment = $result['enrollment'];
            if(preg_match("/ok/",$this->msg)){
              $this->getUser()->setAttribute('event1_id', $event_id);
              $this->getUser()->setAttribute('event1_enrollment_status', @$enrollment->getDisplayStatus());
              $this->getUser()->setAttribute('event1_startdate', $event1_obj->getStartDate());
              $this->getUser()->setAttribute('event1_name', $event1_obj->getName());
              $this->getUser()->setAttribute('event1_location', $event1_obj->getLocation());
              //$this->redirect('assisting/registerThankYou');
              $event1_status = 'REGISTERED_OR_WAITLISTED';
              if ($this->getUser()->getAttribute('event1_enrollment_status') == 'Registered to assist') {
                  $this->getUser()->setAttribute('event2', 'break');
                  $this->getUser()->setAttribute('event3', 'break');
              }
            }
          }
          else {
            // you are not eligible for this event
            $this->getUser()->setAttribute('event1_fail','not eligible for event1: '.$this->event1.' (event id: '.$event_id.')');
            $event1_status = $student->getEventEligibilityStatusMsg();
          }
        }
        else {
          $this->getUser()->setAttribute('event1_fail','event1 not in system: '.$this->event1);
          // message "An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance."
          $event1_status = 'ERROR_OCCURED';
        }
        $this->getUser()->setAttribute('event1_status', $event1_status);
    } else {
        $this->getUser()->setAttribute('event1', 'break');
    }

    // assign event2 if available
    if ($this->getUser()->getAttribute('event2') == 'continue' && $this->event2 > 0) {
        $event2_status = '';
        $event2_obj    = EventPeer::retrieveByFmid( $this->event2 );
        if( isset($event2_obj)){
          $event_id = $event2_obj->getId();
          if($student->eventIdIsEligible( $event_id )){
            // register enrollment and redirect
            $result = $student->assist( $event_id );
            $this->msg = $result['msg'];
            $enrollment = $result['enrollment'];
            if(preg_match("/ok/",$this->msg)){
              $this->getUser()->setAttribute('event2_id', $event_id);
              $this->getUser()->setAttribute('event2_enrollment_status', @$enrollment->getDisplayStatus());
              $this->getUser()->setAttribute('event2_startdate', $event2_obj->getStartDate());
              $this->getUser()->setAttribute('event2_name', $event2_obj->getName());
              $this->getUser()->setAttribute('event2_location', $event2_obj->getLocation());
              //$this->redirect('assisting/registerThankYou');
              $event2_status = 'REGISTERED_OR_WAITLISTED';
              if ($this->getUser()->getAttribute('event2_enrollment_status') == 'Registered to assist') {
                  $this->getUser()->setAttribute('event3', 'break');
              }
            }
          }
          else {
            // you are not eligible for this event
            $this->getUser()->setAttribute('event2_fail','not eligible for event2: '.$this->event2.' (event id: '.$event_id.')');
            $event2_status = $student->getEventEligibilityStatusMsg();
          }
        }
        else {
          $this->getUser()->setAttribute('event2_fail','event2 not in system: '.$this->event2);
          // message "An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance."
          $event2_status = 'ERROR_OCCURED';
        }
        $this->getUser()->setAttribute('event2_status', $event2_status);
    } else {
        $this->getUser()->setAttribute('event2', 'break');
    }
    
    // assign event3 if available
    if ($this->getUser()->getAttribute('event3') == 'continue' && $this->event3 > 0 ) {
        $event3_status = '';
        $event3_obj    = EventPeer::retrieveByFmid( $this->event3 );
        if( isset($event3_obj)){
          $event_id = $event3_obj->getId();
          if($student->eventIdIsEligible( $event_id )){
            // register enrollment and redirect
            $result = $student->assist( $event_id );
            $this->msg = $result['msg'];
            $enrollment = $result['enrollment'];
            if(preg_match("/ok/",$this->msg)){
              $this->getUser()->setAttribute('event3_id', $event_id);
              $this->getUser()->setAttribute('event3_enrollment_status', @$enrollment->getDisplayStatus());
              $this->getUser()->setAttribute('event3_startdate', $event3_obj->getStartDate());
              $this->getUser()->setAttribute('event3_name', $event3_obj->getName());
              $this->getUser()->setAttribute('event3_location', $event3_obj->getLocation());
              //$this->redirect('assisting/registerThankYou');
              $event3_status = 'REGISTERED_OR_WAITLISTED';
            }
          }
          else {
            // you are not eligible for this event
            $this->getUser()->setAttribute('event3_fail','not eligible for event3: '.$this->event3.' (event id: '.$event_id.')');
            $event3_status = $student->getEventEligibilityStatusMsg();
          }
        }
        else {
          $this->getUser()->setAttribute('event3_fail','event3 not in system: '.$this->event3);
          // message "An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance."
          $event3_status = 'ERROR_OCCURED';
        }
        $this->getUser()->setAttribute('event3_status', $event3_status);
    } else {
        $this->getUser()->setAttribute('event3', 'break');
    }

    // reporting: show message if frontend_dev
    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerStep2: not assigned to course, not redirected\n";
    file_put_contents($register_log,$info,FILE_APPEND);

    // if not assigned, redirect to error
    //$this->redirect('assisting/registerTryAgainLater');
    $this->redirect('assisting/eventsRegistration');
    return sfView::SUCCESS;
  }

 public function executeRegAssist(sfWebRequest $request)
  {
    $student = $this->getContext()->getUser()->getStudent();
    $this->getUser()->setAttribute('redirect', '');

    $event_id_to_register = $request->getParameter('e',0);

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." regAssist: event_id: $event_id_to_register\n";
    file_put_contents($register_log,$info,FILE_APPEND);

    //$nobtn                   = $request->getParameter('nobtn');
    //$yesbtn                  = $request->getParameter('yesbtn');

    $event_id =  preg_replace("/[^0-9]/",'',$event_id_to_register); // strip non-numeric characters
    $this->msg = ''; 
    $result = array( );

    $this->getUser()->setAttribute('event1', 'continue');
    $this->getUser()->setAttribute('event2', 'break');
    $this->getUser()->setAttribute('event3', 'break');
    
    $event = EventPeer::retrieveByPk( $event_id );
    $event1_status = '';
    if(isset($event)){
      if($student->eventIdIsEligible( $event_id )){

        $result = $student->assist( $event_id );
          
        $this->msg = $result['msg'];
        $enrollment = $result['enrollment'];
        if(preg_match("/ok/",$this->msg)){
            
            $this->getUser()->setAttribute('event1_id', $event_id);
            $this->getUser()->setAttribute('event1_enrollment_status', @$enrollment->getDisplayStatus());
            $this->getUser()->setAttribute('event1_startdate', $event->getStartDate());
            $this->getUser()->setAttribute('event1_name', $event->getName());
            $this->getUser()->setAttribute('event1_location', $event->getLocation());
            //$this->redirect('assisting/registerThankYou');
            $event1_status = 'REGISTERED_OR_WAITLISTED';
            //$this->getUser()->setAttribute('event1', 1);
        }
      }
      else {
        // you are not eligible for this event
        $this->getUser()->setAttribute('event1_fail','not eligible for event id: '.$event_id);        
        $event1_status = $student->getEventEligibilityStatusMsg();
      }
    }
    else {
      $this->getUser()->setAttribute('event1_fail','event not in system: '.$event_id);
      //The template registerTryAgainLater_1 contains a 
      // message "An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance."
      $event1_status = 'ERROR_OCCURED';
    }
    $this->getUser()->setAttribute('event1_status', $event1_status);

    // reporting: show message if frontend_dev
  
    $info = Date('Y-m-d H:i:s')." regAssist: not assigned to course, not redirected\n";
    file_put_contents($register_log,$info,FILE_APPEND);

    // if not assigned, redirect to error
    $this->redirect('assisting/eventsRegistration');

    return sfView::SUCCESS;
  }


  public function executeRegisterThankYou(sfWebRequest $request)
  {
    $event_id = $this->getUser()->getAttribute('registered_event_id');
    $this->event = EventPeer::retrieveByPk( $event_id );

    $this->reg_action = strtolower( $this->getUser()->getAttribute('reg_action') );

    return sfView::SUCCESS;
  }

  public function executeRegisterTryAgainLater(sfWebRequest $request)
  {
    $this->diagnostics = $this->getUser()->getAttribute('event1_fail').' '. $this->getUser()->getAttribute('event2_fail').' '. $this->getUser()->getAttribute('event3_fail');

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerTryAgainLater diagnostics: ".$this->diagnostics."\n";
    file_put_contents($register_log,$info,FILE_APPEND);
    
    return sfView::SUCCESS;
  }
  
  public function executeRegisterTryAgainLater_1(sfWebRequest $request)
  {
    $this->diagnostics = $this->getUser()->getAttribute('event1_fail').' '. $this->getUser()->getAttribute('event2_fail').' '. $this->getUser()->getAttribute('event3_fail');

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerTryAgainLater_1 diagnostics: ".$this->diagnostics."\n";
    file_put_contents($register_log,$info,FILE_APPEND);
    
    return sfView::SUCCESS;
  }

  public function executeRegisterTryAgainLater_2(sfWebRequest $request)
  {
    $this->diagnostics = $this->getUser()->getAttribute('event1_fail').' '. $this->getUser()->getAttribute('event2_fail').' '. $this->getUser()->getAttribute('event3_fail');

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerTryAgainLater_2 diagnostics: ".$this->diagnostics."\n";
    file_put_contents($register_log,$info,FILE_APPEND);
    
    return sfView::SUCCESS;
  }
  
  public function executeRegisterTryAgainLater_3(sfWebRequest $request)
  {
    $this->diagnostics = $this->getUser()->getAttribute('event1_fail').' '. $this->getUser()->getAttribute('event2_fail').' '. $this->getUser()->getAttribute('event3_fail');

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerTryAgainLater_3 diagnostics: ".$this->diagnostics."\n";
    file_put_contents($register_log,$info,FILE_APPEND);
    
    return sfView::SUCCESS;
  }
  
  public function executeEventsRegistration(sfWebRequest $request)
  {
    $this->diagnostics = $this->getUser()->getAttribute('event1_fail').' '. $this->getUser()->getAttribute('event2_fail').' '. $this->getUser()->getAttribute('event3_fail');

    $register_log = '/tmp/portal_register.log';
    $info = Date('Y-m-d H:i:s')." registerTryAgainLater_3 diagnostics: ".$this->diagnostics."\n";
    file_put_contents($register_log,$info,FILE_APPEND);
    
    return sfView::SUCCESS;
  }
  
  public function executeWaitlistInfo(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeRegisterInfo(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

}
