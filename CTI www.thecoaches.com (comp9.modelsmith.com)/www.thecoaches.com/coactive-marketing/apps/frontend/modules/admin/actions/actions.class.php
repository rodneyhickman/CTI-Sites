<?php

/**
 * admin actions.
 *
 * @package    sf_sandbox
 * @subpackage admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class adminActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        return sfView::SUCCESS;
  }

  public function executeReports(sfWebRequest $request)
  {
    $this->groups  = GroupPeer::doSelect( new Criteria() );
    $current_group = GroupPeer::currentGroup();

    $this->group_id = $this->request->getParameter( 'group_id' );
    if($this->group_id > 0){
      $this->group = GroupPeer::retrieveByPk( $this->group_id );
    }
    else {
      $this->group = $current_group;
    }

    $this->group_homework = $this->group->getHomework();  // array of homework results ordered by students

    $this->getUser()->setAttribute('group_id',$this->group_id);
 
    return sfView::SUCCESS;
  }

  public function executeHomeworkCsv(sfWebRequest $request)
  {
    $this->groups  = GroupPeer::doSelect( new Criteria() );
    $current_group = GroupPeer::currentGroup();

    $group_id = $this->getUser()->getAttribute('group_id');
    if($group_id > 0){
      $this->group = GroupPeer::retrieveByPk( $group_id );
    }
    else {
      $this->group = $current_group;
    }
    $group_name = preg_replace('/ /','-',$this->group->getName());

    $this->csv = $this->group->getHomeworkCSV();  // array of homework results ordered by students
    $this->csv = commonTools::csvFromArrayOfArrays($this->csv);

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Coactive-Selling-'.$group_name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $this->csv;
    return sfView::NONE;  
  }

  public function executeAudios(sfWebRequest $request)
  {
    $this->profile  = $this->getContext()->getUser()->getProfile();
    $this->audios = $this->profile->getMyAudios();
    $this->msg = $request->getParameter('msg');
    return sfView::SUCCESS;
  }

  public function executeAudioUpload(sfWebRequest $request)
  {
    $description = $request->getParameter('description');
    $audio_url   = $request->getParameter('audio_url');

    if($description == ''){
      $this->redirect('admin/audios?msg=Please provide a description');
    }

    $audio = new Audio();
    $audio->setDescription( $description );
    
    if($audio_url != ''){
      $audio->setUrl( $audio_url );
      $audio->save();
      $this->redirect('admin/audios?msg=Audio URL saved');
    }
    else {
      foreach ($request->getFiles() as $uploadedFile) {
        // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
        //print_r($uploadedFile);
        $filename = 'audio-'.$uploadedFile["name"];
        $filename = preg_replace('/[^A-Za-z0-9\.]/','-',$filename);
        move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$filename);
        if($index == 0){ // first file
          $audio->setUrl( 'http://www.thecoaches.com/coactive-marketing-class/uploads/'.$filename );
          $index++;
        } 
      }
      $audio->save();
      $this->redirect('admin/audios?msg=Audio saved');
    }

  }

  public function executeAudioDelete(sfWebRequest $request)
  {
    $audio_id = $request->getParameter('audio_id');
    $audio = AudioPeer::retrieveByPk( $audio_id );
    $this->forward404Unless($audio);

    $audio->delete();
    $this->redirect('admin/audios?msg=Audio deleted');
  }

  public function executeDocuments(sfWebRequest $request)
  {
    $this->profile = $this->getContext()->getUser()->getProfile();
    $this->documents = $this->profile->getMyDocuments();
    $this->msg = $request->getParameter('msg');
    return sfView::SUCCESS;
  }

  public function executeDocumentUpload(sfWebRequest $request)
  {
    $description = $request->getParameter('description');
    $document_url   = $request->getParameter('document_url');

    if($description == ''){
      $this->redirect('admin/documents?msg=Please provide a description');
    }

    $document = new Document();
    $document->setDescription( $description );
    
    // if($document_url != ''){
    //   $document->setUrl( $document_url );
    //   $document->save();
    //   $this->redirect('admin/documents?msg=Document URL saved');
    // }
    // else {
    foreach ($request->getFiles() as $uploadedFile) {
      // Example: $uploadedFile = Array ( [name] => 339.JPG [type] => image/jpeg [tmp_name] => /tmp/phpsuS7Lq [error] => 0 [size] => 53145 ) 
      //print_r($uploadedFile);
      $filename = $uploadedFile["name"];
      $filename = preg_replace('/[^A-Za-z0-9\.]/','-',$filename);
      move_uploaded_file($uploadedFile["tmp_name"], sfConfig::get('sf_upload_dir').'/'.$filename);
      if($index == 0){ // first file
        $document->setUrl( 'http://www.thecoaches.com/coactive-marketing-class/uploads/'.$filename );
        $index++;
      } 
    }
    $document->save();
    $this->redirect('admin/documents?msg=Document saved');
    // }

  }

  public function executeDocumentDelete(sfWebRequest $request)
  {
    $document_id = $request->getParameter('document_id');
    $document = DocumentPeer::retrieveByPk( $document_id );
    $this->forward404Unless($document);

    $document->delete();
    $this->redirect('admin/documents?msg=Document deleted');
  }




  public function executeGroupDate(sfWebRequest $request)
  {
    $this->groups = GroupPeer::doSelect( new Criteria() );

    return sfView::SUCCESS;
  }

  public function executeGroupDateProcess(sfWebRequest $request)
  {
    $new_date = $request->getParameter('date');

    if(strtotime($new_date) !== false){
      GroupPeer::newGroupFromDate( $new_date );
    }

    $this->redirect('admin/groupDate');
  }


  public function executeAddHomework(sfWebRequest $request)
  {
    $group_id   = $request->getParameter('gid');
    $profile_id = $request->getParameter('pid');
    $week       = $request->getParameter('w');

    $this->homework = HomeworkPeer::retrieveByProfile( $profile_id, $group_id, $week );

    $this->profile = ProfilePeer::retrieveByPk( $profile_id );

    $this->setTemplate('homework');
  }

  

  public function executeHomework(sfWebRequest $request)
  {
    $this->homework = null;
    return sfView::SUCCESS;
  }

  public function executeHomeworkProcess(sfWebRequest $request)
  {
    $profile_id  = $request->getParameter('profile_id');
    $homework_id = $request->getParameter('homework_id');

    $this->profile  = ProfilePeer::retrieveByPk( $profile_id );
    $this->homework = HomeworkPeer::retrieveByPk( $homework_id );

    $homework_params = $request->getParameter('homework');

    if( isset($this->profile) && isset($this->homework) ){
      if( @$homework_params['program_goal'] || @$homework_params['purpose'] || @$homework_params['ss_commit'] ){
        $this->profile->setPurpose(           @$homework_params['purpose']);  
        $this->profile->setProgramGoal(       @$homework_params['program_goal']); 
        $this->profile->setShortBio(          substr(@$homework_params['short_bio'],0,75) ); // truncate to 75 chars 
        $this->profile->save();

        $this->homework->setSsCommit(         @$homework_params['ss_commit']); 
        $this->homework->setSsCompleted(      @$homework_params['ss_completed']); 
        $this->homework->setClientsCommit(    @$homework_params['clients_commit']); 
        $this->homework->setClientsCompleted( @$homework_params['clients_completed']); 
        $this->homework->setPointsCommit(     @$homework_params['points_commit']); 
        $this->homework->setPointsEarned(     @$homework_params['points_earned']); 
        $this->homework->setTotalClients(     @$homework_params['total_clients']); 
        $this->homework->save();
      }
    }
    $this->redirect('admin/reports');
  }
}
