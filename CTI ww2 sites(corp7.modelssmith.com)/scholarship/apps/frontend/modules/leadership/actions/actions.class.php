<?php

  /**
   * leadership actions.
   *
   * @package    sf_sandbox
   * @subpackage leadership
   * @author     Your name here
   * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
   */
class leadershipActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('admin/leadership');
  }


  public function executeExportDiet(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $this->tribe_id = $this->profile->getTribeId( );

    $content = commonTools::csvFromAssociativeArray( $this->profile->getDietaryArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Dietary-Requirements-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportLeadership(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvMergeFileFromAssociativeArray( $this->profile->getLeadershipArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Leadership-Scholarship-Application-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportAllLeadership(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    // get list of applicants
    $applicants = ProfilePeer::AllLeadershipApplicants( );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      $array = $profile->getLeadershipArray();
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

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Leadership-Scholarship-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }






  public function executeExportCoachTraining(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvFromAssociativeArray( $this->profile->getCoachTrainingArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Coach-Training-Scholarship-Application-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportAllCoachTraining(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    // get list of applicants
    $applicants = ProfilePeer::AllCoachTrainingApplicants( );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      $array = $profile->getCoachTrainingArray();
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

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Coach-Training-Scholarship-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportLeaderSelection(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvFromAssociativeArray( $this->profile->getLeaderSelectionArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Leader-Selection-Application-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportAllLeaderSelection(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    // get list of applicants
    $applicants = ProfilePeer::AllLeaderSelectionApplicants( );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      $array = $profile->getLeaderSelectionArray();
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
        else if(is_numeric($value) || preg_match('/^\s*\+/',$value)){
          $content .= '="'.$value.'",';
        }
        else {
          $content .= '"'.$value.'",';
        }
      }
      $content = preg_replace('/,$/',"\n",$content);
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Leader-Selection-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }




  public function executeUpdateAssistants(sfWebRequest $request) {

    // combine duplicates
    ProfilePeer::MergeDuplicates();

    $this->redirect('leadership/assistants');
    return sfView::SUCCESS;
  }

  public function executeAddParticipant(sfWebRequest $request)
  {
    $this->profile = new Profile();
    $this->profile->save();
    $this->tribe_id = TribePeer::GetUnassignedTribeId();
    $this->profile->setTribe( $this->tribe_id );

    $this->profile_id = $this->profile->getId();

    
    $this->setTemplate('participant');

    return sfView::SUCCESS;
  }


/* ===================== Applicants ====================== */





  public function executeLeaderSelectionApplicants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchLeaderSelectionApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllLeaderSelectionApplicants( );
    }

    return sfView::SUCCESS;
  }


  public function executeLeadershipApplicants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchLeadershipApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllLeadershipApplicants( $this->days, $this->count );
    }

    return sfView::SUCCESS;
  }

  public function executeCoachTrainingApplicants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchCoachTrainingApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllCoachTrainingApplicants( $this->days, $this->count );
    }

    return sfView::SUCCESS;
  }


  public function executeApplicant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }


  public function executeApplicantUpdate(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );


    $this->profile->setFirstName( $request->getParameter('first_name') );
    $this->profile->setLastName( $request->getParameter('last_name') );
    $this->profile->setEmail1( $request->getParameter('email1') );
    $this->profile->setGender( $request->getParameter('gender') == "Female" ? 'F' : 'M' );
    $this->profile->setAge( $request->getParameter('age') );

    $this->profile->save();

    $this->tribe_id = $this->profile->getTribeId(); 
    $this->setTemplate('participant');


    return sfView::SUCCESS;
  }

  public function executeApplicantDelete(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->profile->delete();

    $redirect = $request->getParameter('r');

    $this->redirect("leadership/$redirect");
    return sfView::SUCCESS;
  }

// CASCADE DOCUMENTATION for above action
// SELECT profile.ID, profile.FULL_NAME, profile.FIRST_NAME, profile.MIDDLE_NAME, profile.LAST_NAME, profile.ADDRESS1, profile.ADDRESS2, profile.CITY, profile.STATE_PROV, profile.ZIP_POSTCODE, profile.COUNTRY, profile.TELEPHONE1, profile.TELEPHONE2, profile.EMAIL1, profile.EMAIL2, profile.GENDER, profile.AGE, profile.SECRET, profile.CREATED_AT, profile.UPDATED_AT, profile.EXTRA1, profile.EXTRA2, profile.EXTRA3, profile.EXTRA4, profile.EXTRA5, profile.EXTRA6, profile.EXTRA7, profile.EXTRA8, profile.EXTRA9, profile.EXTRA10, profile.EXTRA11, profile.EXTRA12, profile.EXTRA13, profile.EXTRA14, profile.EXTRA15, profile.EXTRA16, profile.EXTRA17, profile.EXTRA18, profile.EXTRA19, profile.EXTRA20 FROM `profile` WHERE profile.ID=20

// DELETE FROM tribe_participant WHERE tribe_participant.PROFILE_ID=20

// DELETE FROM medical WHERE medical.PROFILE_ID=20

// DELETE FROM program_questionnaire WHERE program_questionnaire.PROFILE_ID=20

// DELETE FROM dietary WHERE dietary.PROFILE_ID=20

// DELETE FROM profile WHERE profile.ID=20



  public function executeExportLeaderSelectionResume(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = "Error: file not found";
    $resume_filename = 'resume.txt';
    $resume = $this->profile->getLeaderSelectionResume();
    if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
      $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
      $resume_filename = $resume;
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }


  public function executeExportLeaderSelectionRecommendation(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = "Error: file not found";
    $resume_filename = 'recommendation.txt';
    $resume = $this->profile->getLeaderSelectionRecommendation();
    if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
      $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
      $resume_filename = $resume;
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }







  public function executeExportCoachTrainingResume(sfWebRequest $request)
  {
       $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = "Error: file not found";
    $resume_filename = 'resume.txt';
    $resume = $this->profile->getCoachTrainingResume();
    if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
      $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
      $resume_filename = $resume;
    }
    

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }


  public function executeExportLeadershipResume(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = "Error: file not found";
    $resume_filename = 'resume.txt';
    $resume = $this->profile->getLeadershipResume();
    if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
      $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
      $resume_filename = $resume;
    }
    

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



// =================== FORL ===================

  public function executeForlApplicants(sfWebRequest $request)
  {
    $this->mode = 'cpcc';

    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    $this->q    = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchForlApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllForlApplicants( $this->days, $this->count );
    }

    return sfView::SUCCESS;
  }

 public function executeForlApplicant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeExportFORL(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvFromAssociativeArray( $this->profile->getFORLArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=FORL-Audition-Form-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

 public function executeExportAllFORL(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllFORLApplicants(  $this->days );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

      $array = $profile->getFORLArray();

      if($header == 1){
        foreach($array as $field => $value){
          $content .= '"'.$field.'",';
        }
        //$content = preg_replace('/,$/',"\n",$content); // replace last command with return
        $content .= "\"\"\n"; // add blank entry in last column
      }
      $header = 0;

      foreach($array as $field => $value){
        if(is_object($value)){
          $content .= '"[OBJECT_REF]",';
        }
        else {
          $value = preg_replace('/\"/',"''",$value); // change double quotes to two singles
          $content .= '"'.$value.'",';
        }
      }
      $content .= "\"\"\n"; // add blank entry in last column
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Executive-Coaching-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

 public function executeExportAllFORLZIP(sfWebRequest $request)
  {

    $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllForlApplicants(  $this->days );

    $zip = new ZipArchive();

    $filename =  "forl-applications-".date('Y-m-d').".zip";

    if(file_exists(sfConfig::get('sf_upload_dir').'/'.$filename)){
      unlink(sfConfig::get('sf_upload_dir').'/'.$filename); // remove it if it already exists
    }

    if ($zip->open(sfConfig::get('sf_upload_dir').'/'.$filename, ZIPARCHIVE::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }


    

    foreach($applicants as $profile){
      $id = $profile->getId();
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      //$zip->addFromString("$name.txt", $name);

      $resume = $profile->getFORLResume();
      if(preg_match('/\.(doc|docx|pdf|rtf|txt)/i', $resume)){
        if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
          $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$resume, $resume);
        }
        else {
          $zip->addFromString($name.'-resume.txt', "$name has not yet uploaded a resume");
        }
      }
      else {
        $zip->addFromString($name.'-resume.txt', "$name has not yet uploaded a resume (2) ");
      }
    
      $photo = $profile->getFORLPhoto();
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$photo )){
        $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$photo, $photo);
      }
      else {
        $zip->addFromString($name.'-photo.txt', "$name has not yet uploaded a photo");
      }
    
    
      //$zip->addFile($thisdir . "/too.php","/testfromfile.php");
    }

    $zip->close();

    $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$filename );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

 public function executeExportFORLResume(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $resume = $this->profile->getFORLResume();
    commonTools::logMessage( "resume: $resume" );
    $content = $resume; 
    $resume_filename = 'resume.txt';
    if(preg_match('/\.(doc|docx|pdf|rtf|txt)/i', $resume)){
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
        $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
        $resume_filename = preg_replace('/^\d+_/','',$resume); // remove any leading number T. Beutel 1/7/13
      }
    }

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportFORLPhoto(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $photo = $this->profile->getFORLPhoto();
    $content = ''; 
    $photo_filename = 'photo.jpg';
    if(preg_match('/\.(jpg|jpeg|png)/i', $photo)){
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$photo )){
        $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$photo );
        $photo_filename = preg_replace('/^\d+_/','',$photo); // remove any leading number T. Beutel 1/7/13
      }
    }

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    if(preg_match('/\.png/i', $photo)){
      $this->getResponse()->setHttpHeader('Content-Type', 'image/png', TRUE);
    }
    else {
      $this->getResponse()->setHttpHeader('Content-Type', 'image/jpeg', TRUE);
    }
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$photo_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeForlMergeTemplate(sfWebRequest $request)
  {
    $content  = '';
    $flexform = FlexformPeer::getActiveFORL();

    $content .= "<html><head>";
    $content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
    $content .= "</head><body>";
    // example: $content .= "<p><span style='font-size:12.0pt'>My <b>first</b> document";

    $questions = $flexform->getQuestionArray();
    foreach($questions as $question){
      if(preg_match('/^null/i',$question->getLabel())){
        continue;
      }
      $content .= "<p><span style='font-size:12.0pt'><b>".$question->getLabel().": </b>";
      if($question->getType() == 'group' || $question->getType() == 'section' || $question->getType() == 'header'){
        $content .= '</p>';
        continue;
      }
      if($question->getType() == 'textarea'){
        $content .= "<br />";
      }
      $content .= "&laquo;".$question->getParamName()."&raquo;</p>";
    }

    $content .= "</body>";
    $content .= "</html>";

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-word', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=FORL_merge.doc', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }

public function executeForlMergeDoc(sfWebRequest $request)
  {
    $content  = '';
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content .= "<html><head>";
    $content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
    $content .= "</head><body>";
   
    $questions = $this->profile->getFORLArray( 'labels' );

    foreach($questions as $key => $value){
     
      $content .= "<p><span style='font-size:12.0pt'>$key: ";
      if( strlen( $value ) > 40 ){
        $content .= "<br />";
      }
      $content .= "<b>$value</b><br />&nbsp;</p>";
    }

    $content .= "</body>";
    $content .= "</html>";

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-word', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$name.'-FORL-application.doc', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }

  public function executeForlAllMergeDocZIP(sfWebRequest $request)
  {
    $content  = '';


    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    $this->q    = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchForlApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllForlApplicants( $this->days, $this->count );
    }

    $zip = new ZipArchive();

    $filename =  "FORL-audition-applications-".date('Y-m-d').".zip";

    if(file_exists(sfConfig::get('sf_upload_dir').'/'.$filename)){
      unlink(sfConfig::get('sf_upload_dir').'/'.$filename); // remove it if it already exists
    }

    if ($zip->open(sfConfig::get('sf_upload_dir').'/'.$filename, ZIPARCHIVE::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }



    foreach($this->applicants as $profile){

      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

      $content = '';
      $content .= "<html><head>";
      $content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
      $content .= "</head><body>";
    
      $questions = $profile->getFORLArray( 'labels' );
      foreach($questions as $key => $value){
        
        $content .= "<p><span style='font-size:12.0pt'>$key: ";
        if( strlen( $value ) > 40 ){
          $content .= "<br />";
        }
        $content .= "<b>$value</b><br />&nbsp;</p>";
      }
      
      $content .= "</body>";
      $content .= "</html>";
      
      file_put_contents( sfConfig::get('sf_upload_dir').'/'.$name.'-FORL-application.doc',$content);
      $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$name.'-FORL-application.doc',$name.'-FORL-application.doc');

    }

    $zip->close();

    $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$filename );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;  

  
  }


  public function executeExportForlPDF(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();


    commonTools::pdfFromArray( $this->profile->getFORLArray( 'labels' ), 'FORL Audition Application for '.$name ); // exits after emitting PDF

    return sfView::NONE;   
  }





// =================== Executive Coaching ===================


  public function executeExecApplicant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeExecutiveApplicants(sfWebRequest $request)
  {
    $this->mode = 'cpcc';

    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    $this->q    = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchExecutiveApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllExecutiveApplicants( $this->days, $this->count );
    }

    return sfView::SUCCESS;
  }

  public function executeExecMergeDoc(sfWebRequest $request)
  {
    $content  = '';
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content .= "<html><head>";
    $content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
    $content .= "</head><body>";
   
    $questions = $this->profile->getExeccoachArray();
    foreach($questions as $key => $value){
     
      $content .= "<p><span style='font-size:12.0pt'><b>$key: </b>";
      if( strlen( $value ) > 40 ){
        $content .= "<br />";
      }
      $content .= "$value<br />&nbsp;</p>";
    }

    $content .= "</body>";
    $content .= "</html>";

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-word', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$name.'-exec-coaching.doc', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE; 
  }

  public function executeExecAllMergeDocZIP(sfWebRequest $request)
  {
    $content  = '';
    $this->mode = 'cpcc';

    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    $this->q    = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchExecutiveApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllExecutiveApplicants( $this->days, $this->count );
    }

    $zip = new ZipArchive();

    $filename =  "exec-coaching-applications-".date('Y-m-d').".zip";

    if(file_exists(sfConfig::get('sf_upload_dir').'/'.$filename)){
      unlink(sfConfig::get('sf_upload_dir').'/'.$filename); // remove it if it already exists
    }

    if ($zip->open(sfConfig::get('sf_upload_dir').'/'.$filename, ZIPARCHIVE::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }



    foreach($this->applicants as $profile){

      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

      $content = '';
      $content .= "<html><head>";
      $content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
      $content .= "</head><body>";
    
      $questions = $profile->getExeccoachArray();
      foreach($questions as $key => $value){
        
        $content .= "<p><span style='font-size:12.0pt'><b>$key: </b>";
        if( strlen( $value ) > 40 ){
          $content .= "<br />";
        }
        $content .= "$value<br />&nbsp;</p>";
      }
      
      $content .= "</body>";
      $content .= "</html>";
      
      file_put_contents( sfConfig::get('sf_upload_dir').'/'.$name.'-exec-coaching-application.doc',$content);
      $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$name.'-exec-coaching-application.doc',$name.'-exec-coaching-application.doc');

    }

    $zip->close();

    $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$filename );

   $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;  

  
  }





  public function executeFacultyApplicants(sfWebRequest $request)
  {
    $this->mode = 'faculty';

    $this->days = $request->getParameter('days',1000);
    $this->count = $request->getParameter('count',0);
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->applicants = ProfilePeer::SearchFacultyApplicants( $this->q );
    }
    else {
      // get list of participants
      $this->applicants = ProfilePeer::AllFacultyApplicants( $this->days, $this->count );
    }
    $this->setTemplate('executiveApplicants');
  }



  public function executeExportResume(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $resume = $this->profile->getResume();
    $content = $resume; 
    $resume_filename = 'resume.txt';
    if(preg_match('/\.(doc|docx|pdf|rtf|txt)/i', $resume)){
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
        $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$resume );
        $resume_filename = preg_replace('/^\d+_/','',$resume); // remove any leading number T. Beutel 1/7/13
      }
    }

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$resume_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportPhoto(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $photo = $this->profile->getExecPhoto();
    $content = ''; 
    $photo_filename = 'photo.jpg';
    if(preg_match('/\.(jpg|jpeg)/i', $photo)){
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$photo )){
        $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$photo );
        $photo_filename = preg_replace('/^\d+_/','',$photo); // remove any leading number T. Beutel 1/7/13
      }
    }

    
    
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'image/jpeg', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$photo_filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


  public function executeExportExecCoaching(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );



    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvFromAssociativeArray( $this->profile->getExeccoachArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Executive-Coaching-Form-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


  public function executeExportExecutive(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $content = commonTools::csvFromAssociativeArray( $this->profile->getExeccoachArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Executive-Coaching-Form-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportExecutivePDF(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();


    commonTools::pdfFromArray( $this->profile->getExeccoachArray(), 'Executive Coaching Application for '.$name ); // exits after emitting PDF

    return sfView::NONE;   
  }


  public function executeExportAllExecCoachingZIP(sfWebRequest $request)
  {

    $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllExecutiveApplicants(  $this->days );

    $zip = new ZipArchive();

    $filename =  "execcoach-cpcc-".date('Y-m-d').".zip";

    if(file_exists(sfConfig::get('sf_upload_dir').'/'.$filename)){
      unlink(sfConfig::get('sf_upload_dir').'/'.$filename); // remove it if it already exists
    }

    if ($zip->open(sfConfig::get('sf_upload_dir').'/'.$filename, ZIPARCHIVE::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }


    

    foreach($applicants as $profile){
      $id = $profile->getId();
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      //$zip->addFromString("$name.txt", $name);

      $resume = $profile->getResume();
      if(preg_match('/\.(doc|docx|pdf|rtf|txt)/i', $resume)){
        if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
          $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$resume, $resume);
        }
        else {
          $zip->addFromString($id.'-'.$name.'-resume.txt', "$name has not yet uploaded a resume");
        }
      }
      else {
        $zip->addFromString($id.'-'.$name.'-resume.txt', "$name has not yet uploaded a resume");
      }
    
      $photo = $profile->getExecPhoto();
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$photo )){
        $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$photo, $photo);
      }
      else {
        $zip->addFromString($id.'-'.$name.'-photo.txt', "$name has not yet uploaded a photo");
      }
    
    
      //$zip->addFile($thisdir . "/too.php","/testfromfile.php");
    }

    $zip->close();

    $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$filename );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportAllExecCoaching(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllExecutiveApplicants(  $this->days );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      $array = $profile->getExeccoachArray();
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
          $value = preg_replace('/\"/',"'",$value); // change double quotes to single
          $content .= '"'.$value.'",';
        }
      }
      //$content = preg_replace('/,$/',"\n",$content);
       $content .= "\"\"\n";
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Executive-Coaching-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportAllExecFaculty(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

  $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllFacultyApplicants(  $this->days  );

    foreach($applicants as $profile){
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      $array = $profile->getExeccoachArray();
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
          $value = preg_replace('/\"/',"'",$value); // change double quotes to single
          $content .= '"'.$value.'",';
        }
      }
      //$content = preg_replace('/,$/',"\n",$content);
      $content .= "\"\"\n";
    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Executive-Coaching-Faculty-Applications-'.date('Y-m-d').'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportAllExecFacultyZIP(sfWebRequest $request)
  {

    $this->days = $request->getParameter('days',1000);

    // get list of applicants
    $applicants = ProfilePeer::AllFacultyApplicants(  $this->days );

    $zip = new ZipArchive();

    $filename =  "execcoach-faculty-".date('Y-m-d').".zip";

    if(file_exists(sfConfig::get('sf_upload_dir').'/'.$filename)){
      unlink(sfConfig::get('sf_upload_dir').'/'.$filename); // remove it if it already exists
    }

    if ($zip->open(sfConfig::get('sf_upload_dir').'/'.$filename, ZIPARCHIVE::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }


    

    foreach($applicants as $profile){
      $id = $profile->getId();
      $name = $profile->getName();
      $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      //$zip->addFromString("$name.txt", $name);

      $resume = $profile->getResume();
      if(preg_match('/\.(doc|docx|pdf|rtf|txt)/i', $resume)){
        if(file_exists( sfConfig::get('sf_upload_dir').'/'.$resume )){
          $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$resume, $resume);
        }
        else {
          $zip->addFromString($id.'-'.$name.'-resume.txt', "$name has not yet uploaded a resume");
        }
      }
      else {
        $zip->addFromString($id.'-'.$name.'-resume.txt', "$name has not yet uploaded a resume");
      }
    
      $photo = $profile->getExecPhoto();
      if(file_exists( sfConfig::get('sf_upload_dir').'/'.$photo )){
        $zip->addFile( sfConfig::get('sf_upload_dir').'/'.$photo, $photo);
      }
      else {
        $zip->addFromString($id.'-'.$name.'-photo.txt', "$name has not yet uploaded a photo");
      }
    
    
      //$zip->addFile($thisdir . "/too.php","/testfromfile.php");
    }

    $zip->close();

    $content = file_get_contents( sfConfig::get('sf_upload_dir').'/'.$filename );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$filename, TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }




  public function executeCoreApplication(sfWebRequest $request)
  {  
    $profile_id    = $request->getParameter('profile_id');

    $this->profile = ProfilePeer::retrieveByPk( $profile_id );
    $this->app     = $this->profile->getCoachTrainingApp();

    return sfView::SUCCESS;
  }

  public function executeLeadershipApplication(sfWebRequest $request)
  {  
    $profile_id    = $request->getParameter('profile_id');

    $this->profile = ProfilePeer::retrieveByPk( $profile_id );
    $this->app     = $this->profile->getLeadershipApp();

    return sfView::SUCCESS;
  }

}


