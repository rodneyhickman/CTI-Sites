<?php

  // TO DO, July 23, 2011:
  // - make sure that certification profiles are not auto-deleted in launchpad
  // - 


/**
 * certification actions.
 *
 * @package    sf_sandbox
 * @subpackage certification
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class certificationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    $this->getUser()->setHomePreference('certification');

    // if user logged in, redirect
    if($this->getUser()->isAuthenticated()){
        $this->redirect('admin/certification');
    }

    // otherwise show forms
    $this->form    = new sfGuardFormSignin();

    // login and register forms
    return sfView::SUCCESS;
  }


  // ==================== PODs ====================

  public function executePodsUpdate(sfWebRequest $request)
  {
    $this->redirect('certification/pod');
    return sfView::SUCCESS;
  }

  public function executePod(sfWebRequest $request)
  {
    // show the selected pod, or the first pod if not specified

    $this->pod_name = '';

    // get selected pod from param
    $this->pod_id = $request->getParameter('pod_id');

    // get list of pods
    $this->pods = PodPeer::CurrentPods( 'all' );

    // if pod_id not defined, use first id
    if($this->pod_id < 1){
      $this->pod_id = $this->pods[0]->getId();
    }

    $pod = PodPeer::retrieveByPk( $this->pod_id );
    $this->pod_name = $pod->getName();


    // get list of participants
    $this->participants = ProfilePeer::ParticipantsInPod( $this->pod_id );


    return sfView::SUCCESS;
  }


  // ==================== Manage by Dates ====================

  public function executeManageByDate(sfWebRequest $request)
  {

    $this->date_list = CertificationPeer::getDates();

    $first_date = $this->date_list[0];

    // get selected date from param
    $this->date = $request->getParameter('date', $first_date);
    $this->date1 = preg_replace("/ /","-",$this->date);

    // get list of participants
    $this->participants = ProfilePeer::ParticipantsByDate( $this->date );

    return sfView::SUCCESS;
  }


  // ==================== Participants ====================

  public function executeParticipants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchPodParticipants( $this->q ); // search non-start-month participants
    }
    else {
      // get list of participants
      $this->participants = ProfilePeer::AllPodParticipants( ); // non-start-month participants
    }

    $this->test =  $this->getUser()->getTestString();

    return sfView::SUCCESS;
  }

  public function executeDeclareMonthParticipants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchDeclareMonthParticipants( $this->q ); // start-month participants
    }
    else {
      // get list of participants
      $this->participants = ProfilePeer::AllDeclareMonthParticipants( ); // start-month participants
    }

    $this->test =  $this->getUser()->getTestString();

    return sfView::SUCCESS;
  }


 // ==================== Participant edit and so forth ====================


  public function executeAddParticipant(sfWebRequest $request)
  {
    $this->profile = new Profile();
    $this->profile->save();
    $this->pod_id = PodPeer::GetUnassignedPodId();
    $this->profile->setPod( $this->pod_id );

    $this->profile_id = $this->profile->getId();

    
    $this->setTemplate('participant');

    return sfView::SUCCESS;
  }

  public function executeParticipant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->pod_id = $request->getParameter('pod_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeViewParticipantApplication(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->pod_id = $request->getParameter('pod_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    if(isset($this->profile)){
      $array = $this->profile->getCertificationArray();
    }
    $this->application_text = commonTools::FormattedTextFromArray( $array );

    return sfView::SUCCESS;
  }

  public function executeParticipantUpdate(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );


    $this->profile->setFirstName( $request->getParameter('first_name') );
    $this->profile->setLastName( $request->getParameter('last_name') );
    $this->profile->setEmail1( $request->getParameter('email1') );

    $this->profile->save();

    $this->pod_id = $this->profile->getPodId(); 
    $this->setTemplate('participant');


    return sfView::SUCCESS;
  }

  public function executeParticipantDelete(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->profile->delete();

    $this->redirect('certification/participants');
    return sfView::SUCCESS;
  }



  public function executeExportMonthApplications(sfWebRequest $request)
  {
    $date       = $request->getParameter('date');

    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content


      // get list of participants
      // get list of participants
      $participants = ProfilePeer::ParticipantsByDate( $date );

      foreach($participants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getCertificationArray();
        if($header == 1){
          foreach($array as $field => $value){
            $content .= '"'.$field.'",';
          }
          $content = preg_replace('/,$/',"\n",$content); // replace last command with return
        }
        $header = 0;
        foreach($array as $field => $value){
          if(is_object($value)){
            $content .= '"[OBJECT_REF]",';
          }
          else {
            $content .= '"'.$value.'",';
          }
        }
        $content = preg_replace('/,$/',"\n",$content);
      }



    $date1 = preg_replace("/ /","-",$date);

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Certification-Applications-'.$date1.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


}
