<?php

/**
 * participant actions.
 *
 * @package    sf_sandbox
 * @subpackage participant
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class participantActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('participant', 'home');
  }


  public function executeHome(sfWebRequest $request)
  {
    // T. Beutel added 12/26/12
    $this->profile = $this->getContext()->getUser()->getProfile();
    if(!$this->profile->isRegistered()){
      $this->redirect('participant/pickCourse');
    }

    // T. Beutel added 1/25/2013
    if($this->profile->getAgreedToTerms() != 'yes'){
      $this->redirect('main/terms');
    }
    return sfView::SUCCESS;
  }

  public function executePickCourse(sfWebRequest $request)
  {
    $this->groups = GroupPeer::futureCourses();
    // T. Beutel added 12/26/12
    return sfView::SUCCESS;
  }

  public function executePickCourseProcess(sfWebRequest $request)
  {
    // T. Beutel added 12/26/12
    $group_id = $request->getParameter('group_id',1);
    $this->profile = $this->getContext()->getUser()->getProfile();

    $homework = HomeworkPeer::register( $this->profile->getId(), $group_id );

    $this->redirect('participant/home');
  }

  public function executeHomework(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->homework = $this->profile->getCurrentHomework();
    return sfView::SUCCESS;
  }

  public function executeHomework2(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->homework = $this->profile->getCurrentHomework();
    return sfView::SUCCESS;
  }
  public function executeHomeworkProcess(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    if( !isset($this->profile) ){
      $this->redirect('participant/home');
    }
    $this->homework = $this->profile->getCurrentHomework();

    $homework_params = $request->getParameter('homework');
    if( @$homework_params['program_goal'] || @$homework_params['purpose'] || @$homework_params['ss_commit'] ){
      $this->profile->setPurpose(           @$homework_params['purpose']);  
      $this->profile->setProgramGoal(       @$homework_params['program_goal']); 
      $this->profile->setShortBio(          substr(@$homework_params['short_bio'],0,75) ); // truncate to 75 chars 
      $this->profile->save();

      // $index = 0;
      // foreach ($request->getFiles() as $uploadedFile) {
      //   // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //   //print_r($uploadedFile);
      //   move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$this->profile->getId().'_'.$uploadedFile["name"]);
      //   if($index == 0){ // first file
      //     $this->profile->setPhoto( $this->profile->getId().'_'.$uploadedFile["name"] );
      //     $index++;
      //   } 
      // }
      


      $this->homework->setSsCommit(         @$homework_params['ss_commit']); 
      $this->homework->setSsCompleted(      @$homework_params['ss_completed']); 
      $this->homework->setClientsCommit(    @$homework_params['clients_commit']); 
      $this->homework->setClientsCompleted( @$homework_params['clients_completed']); 
      $this->homework->setPointsCommit(     @$homework_params['points_commit']); 
      $this->homework->setPointsEarned(     @$homework_params['points_earned']); 
      $this->homework->setTotalClients(     @$homework_params['total_clients']); 
      $this->homework->save();
    }
    $this->redirect('participant/homeworkSaved');
  }

  public function executeHomeworkSaved(sfWebRequest $request)
  {

    return sfView::SUCCESS;
  }

  public function executeAudios(sfWebRequest $request)
  {
    $this->profile  = $this->getContext()->getUser()->getProfile();
    $this->audios = $this->profile->getMyAudios();

    return sfView::SUCCESS;
  }

  public function executeDocuments(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->documents = $this->profile->getMyDocuments();

    return sfView::SUCCESS;
  }

  public function executeProgress(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->homeworks = $this->profile->getMyHomeworks();
    $this->program_goal = $this->profile->getProgramGoal();

    return sfView::SUCCESS;
  }
}
