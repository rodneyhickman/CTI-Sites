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
    $this->forward('default', 'module');
  }

  public function executeTribe(sfWebRequest $request)
  {
    $this->tribe_name = '';

    // get selected tribe from param
    $this->tribe_id = $request->getParameter('tribe_id');

    // get list of tribes
    $this->tribes = TribePeer::CurrentTribes( 'all' );

    // if tribe_id not defined, use first id
    if($this->tribe_id < 1){
      $this->tribe_id = $this->tribes[0]->getId();
    }

    $tribe = TribePeer::retrieveByPk( $this->tribe_id );
    $this->tribe_name = $tribe->getName();


    // get list of participants
    $this->participants = ProfilePeer::ParticipantsInTribe( $this->tribe_id );

    // get list of assistants
    $this->assistants = ProfilePeer::AssistantsInTribe( $this->tribe_id );

    // get list of leaders
    $this->leaders = ProfilePeer::LeadersInTribe( $this->tribe_id );

    return sfView::SUCCESS;
  }


  public function executeLaunchedTribe(sfWebRequest $request)
  {
    $this->tribe_name = '';

    // get selected tribe from param
    $this->tribe_id = $request->getParameter('tribe_id');

    // get list of tribes
    $this->tribes = TribePeer::LaunchedTribes( 'all' );

    // if tribe_id not defined, use first id
    if($this->tribe_id < 1){
      $this->tribe_id = $this->tribes[0]->getId();
    }

    $tribe = TribePeer::retrieveByPk( $this->tribe_id );
    $this->tribe_name = $tribe->getName();


    // get list of participants
    $this->participants = ProfilePeer::ParticipantsInTribe( $this->tribe_id );

    // get list of assistants
    $this->assistants = ProfilePeer::AssistantsInTribe( $this->tribe_id );

    // get list of leaders
    $this->leaders = ProfilePeer::LeadersInTribe( $this->tribe_id );

    return sfView::SUCCESS;
  }



  public function executeTransferParticipant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');
    // get list of tribes
    $this->tribes = TribePeer::CurrentTribes( 'all' );

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeTransferParticipantUpdate(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );
    $this->profile->setTribe( $this->tribe_id, 'keep' );

    $this->redirect('leadership/participant?id='.$this->profile_id.'&tribe_id='.$this->tribe_id);

    return sfView::SUCCESS;
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

  public function executeExportInf(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $this->tribe_id = $this->profile->getTribeId( );

    $content = commonTools::csvFromAssociativeArray( $this->profile->getInfluencerArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Influencer-Report-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportTribeDietary(sfWebRequest $request)
  {
    $tribe_id   = $request->getParameter('id');
    $tribe      = TribePeer::retrieveByPk( $tribe_id );
    $tribe_name = $tribe->getName();
    $tribe_name = preg_replace('/[^A-Za-z0-9]/',"-",$tribe_name);

    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    if(isset($tribe)){
      // get list of participants
      $participants = ProfilePeer::ParticipantsInTribe( $tribe_id );

      foreach($participants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getDietaryArray();
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

      // get list of assistants
      $assistants = ProfilePeer::AssistantsInTribe( $tribe_id );

      foreach($assistants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getDietaryArray();
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


      // get list of leaders
      $leaders = ProfilePeer::LeadersInTribe( $tribe_id );

      foreach($leaders as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getDietaryArray();
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



    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Dietary-Requirements-'.$tribe_name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executeExportTribeInf(sfWebRequest $request)
  {
    $tribe_id   = $request->getParameter('id');
    $tribe      = TribePeer::retrieveByPk( $tribe_id );
    $tribe_name = $tribe->getName();
    $tribe_name = preg_replace('/[^A-Za-z0-9]/',"-",$tribe_name);

    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    if(isset($tribe)){
      // get list of participants
      $participants = ProfilePeer::ParticipantsInTribe( $tribe_id );

      foreach($participants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        //echo "$name<br />";
        $array = $profile->getInfluencerArray();
        if($header == 1){
          foreach($array as $field => $value){
            $content .= '"'.$field.'",';
          }
          $content = preg_replace('/,$/',"\n",$content); // replace last command with return
        }
        $header = 0;
        for($i=0;$i<4;$i++){ // create up to 4 duplicate rows

          $row  = array( '', '', '', '' );  
          $flag = array(  0,  0,  0,  0 );

          foreach($array as $field => $value){
            if(is_object($value)){
              $content .= '"[OBJECT_REF]",';
            }
            else {
              // if field matches "Influenced by" and if value matches "[,;]"
              //     explode the value and store the $ith value
              if(preg_match("/Influenced/",$field) ){
                $influencers = preg_split("/[,;]/",$value);
                //print_r($influencers);
                //echo "... [ $i ]<br />";
                if(isset($influencers[$i]) ){
                  $influencer = preg_replace("/^\s*/","",$influencers[$i]);
                  $row[$i] .= '"'.$influencer.'",';
                  $flag[$i] = 1; 
                }
                else if($i == 0){
                  $row[$i] .=  '"'.$value.'",'; // normal, without comma or semicolon
                }
                else {
                  $row[$i] .= ','; // empty cell
                }
              }
              else {
                $row[$i] .= '"'.$value.'",';
              }
            }
          }
          if($flag[$i] == 1 || $i == 0){ // yes, there was an influencer in this row, or this was the first row
            $content .= $row[$i];
            $content = preg_replace('/,$/',"\n",$content);
          }
        }
      }

    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Influencer-Report-'.$tribe_name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }



  public function executeExportPQ(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $this->tribe_id = $this->profile->getTribeId( );

    $content = commonTools::csvFromAssociativeArray( $this->profile->getProgramQuestionnaireArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Program-Questionnaire-'.$name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }

  public function executePQPDF(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $title = 'Program Questionnaire Form for '.$this->profile->getName();
    $this->pdf = commonTools::FormattedPDFFromArray(  $this->profile->getProgramQuestionnaireArray(), $title );

    return sfView::SUCCESS;
  }



  public function executeExportTribeQuestionnaire(sfWebRequest $request)
  {
    $tribe_id   = $request->getParameter('id');
    $tribe      = TribePeer::retrieveByPk( $tribe_id );
    $tribe_name = $tribe->getName();
    $tribe_name = preg_replace('/[^A-Za-z0-9]/',"-",$tribe_name);

    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    if(isset($tribe)){
      // get list of participants
      $participants = ProfilePeer::ParticipantsInTribe( $tribe_id );

      foreach($participants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getProgramQuestionnaireArray();
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

      // get list of assistants
      // $assistants = ProfilePeer::AssistantsInTribe( $tribe_id );

      // foreach($assistants as $profile){
      //   $name = $profile->getName();
      //   $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      //   $array = $profile->getProgramQuestionnaireArray();
      //   if($header == 1){
      //     foreach($array as $field => $value){
      //       $content .= '"'.$field.'",';
      //     }
      //     $content = preg_replace('/,$/',"\n",$content); 
      //   }
      //   $header = 0;
      //   foreach($array as $field => $value){
      //     if(is_object($value)){
      //       $content .= '"[OBJECT_REF]",';
      //     }
      //     else {
      //       $content .= '"'.$value.'",';
      //     }
      //   }
      //   $content = preg_replace('/,$/',"\n",$content);
      // }


      // get list of leaders
      // $leaders = ProfilePeer::LeadersInTribe( $tribe_id );

      // foreach($leaders as $profile){
      //   $name = $profile->getName();
      //   $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
      //   $array = $profile->getProgramQuestionnaireArray();
      //   if($header == 1){
      //     foreach($array as $field => $value){
      //       $content .= '"'.$field.'",';
      //     }
      //     $content = preg_replace('/,$/',"\n",$content); 
      //   }
      //   $header = 0;
      //   foreach($array as $field => $value){
      //     if(is_object($value)){
      //       $content .= '"[OBJECT_REF]",';
      //     }
      //     else {
      //       $content .= '"'.$value.'",';
      //     }
      //   }
      //   $content = preg_replace('/,$/',"\n",$content);
      // }





    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Program-Questionnaire-'.$tribe_name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


  public function executeExportTribeMedical(sfWebRequest $request)
  {
    $tribe_id   = $request->getParameter('id');
    $tribe      = TribePeer::retrieveByPk( $tribe_id );
    $tribe_name = $tribe->getName();
    $tribe_name = preg_replace('/[^A-Za-z0-9]/',"-",$tribe_name);

    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content

    if(isset($tribe)){
      // get list of participants
      $participants = ProfilePeer::ParticipantsInTribe( $tribe_id );

      foreach($participants as $profile){
        if($profile->getFinishedMedical() == 'Yes'){
          $name = $profile->getName();
          $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
          $array = $profile->getMedicalArray();
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
      }

      // get list of assistants
      $assistants = ProfilePeer::AssistantsInTribe( $tribe_id );

      foreach($assistants as $profile){
        if($profile->getFinishedMedical() == 'Yes'){
          $name = $profile->getName();
          $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
          $array = $profile->getMedicalArray();
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
      }


      // get list of leaders
      $leaders = ProfilePeer::LeadersInTribe( $tribe_id );

      foreach($leaders as $profile){
        if($profile->getFinishedMedical() == 'Yes'){
          $name = $profile->getName();
          $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
          $array = $profile->getMedicalArray();
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
      }




    }

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Medical-'.$tribe_name.'.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


  public function executeExportMedical(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $name = $this->profile->getName();
    $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);

    $this->tribe_id = $this->profile->getTribeId( );

    $content = commonTools::csvFromAssociativeArray( $this->profile->getMedicalArray() );

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Medical-Requirements-'.$name.'.csv', TRUE);
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

  

  public function executeAddDeleteTribes(sfWebRequest $request)
  {
    // get list of all tribes (including unassigned and other)

    $this->current_tribes = TribePeer::CurrentTribes();
    $this->launched_tribes = TribePeer::LaunchedTribes();

    return sfView::SUCCESS;
  }

  public function executeAddTribe(sfWebRequest $request)
  {
    $name     = $request->getParameter('name');
    $location = $request->getParameter('location');
    $r1_date  = $request->getParameter('r1_date');
    $fmid     = $request->getParameter('fmid');

    TribePeer::addTribe($name,$location,$r1_date,$fmid);

    $this->redirect('leadership/addDeleteTribes');
  }

  public function executeDeleteTribe(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $tribe = TribePeer::retrieveByPk($id);
    if(isset($tribe)){
      $tribe->delete();
    }
    $this->redirect('leadership/addDeleteTribes');
  }


  public function executeUpdateTribes(sfWebRequest $request)
  {

    // get "published" leadership dates from CTIDATABASE

    $server   = sfConfig::get('app_ctidatabase_server');  // see apps/frontend/config/app.yml
    $port     = sfConfig::get('app_ctidatabase_port');
    $user     = sfConfig::get('app_ctidatabase_user');
    $password = sfConfig::get('app_ctidatabase_password');

    $rdbh = mysql_connect( $server.':'.$port, $user, $password ); // make sure this server has DB grant

    $this->msg = '';

    if($rdbh){
      $this->msg .= '+connected';

      $query = sprintf( "SELECT event,date,fmid,location FROM CTIDATABASE.event_calendar WHERE course_type_id=11 ");
      $result = mysql_query( $query, $rdbh );
      if($result){ 
        while(1){
          $row = mysql_fetch_row($result);
          if($row){
            $event    = $row[0];
            $date     = $row[1];
            $fmid     = $row[2];
            $location = $row[3];
          
            $c = new Criteria();
            $c->add(TribePeer::EXTRA1, $fmid);
            $tribe = TribePeer::doSelectOne( $c );
            if(!$tribe){
              $tribe = new Tribe();
              $tribe->setName($event);
              $tribe->setRetreat1Date($date);
              $tribe->setExtra1($fmid);
              $tribe->setExtra2('touch'); // touch flag... tribes that are not touched will be cancelled
              $tribe->setLocation($location);
              $tribe->save();
            }
            else {
              $tribe->setExtra2('touch'); // touch flag... tribes that are not touched will be cancelled
              $tribe->save();
            }
          }
          else {
            break;
          }
        }
      }
    }

    // delete any tribes that are greater than 1 month old
    TribePeer::RemoveOldTribes();

    // cancel any tribes that are CXL or not touched
    TribePeer::ProcessCancelledTribes();

    // delete any participants and assistants (not leaders) older than 2 months and not connected to a tribe
    ProfilePeer::RemoveOldParticipants();

    // delete any participants and assistants (not leaders) older than 2 months and not connected to a tribe
    ProfilePeer::RemoveNullParticipants();

    // combine duplicates
    ProfilePeer::MergeDuplicates();


    $this->redirect('leadership/tribe');
    return sfView::SUCCESS;
  }


  public function executeParticipants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    $this->p = $request->getParameter('p');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchParticipants( $this->q );
    }
    else {
      // get list of participants

      $this->pager = ProfilePeer::AllParticipantsPager( $this->p );
    }

    return sfView::SUCCESS;
  }

  public function executeParticipants2(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    $this->p = $request->getParameter('page');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchParticipants( $this->q );
    }
    else {
      // get list of participants
      $this->pager = ProfilePeer::AllParticipantsPager( $this->p );
    }

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

  public function executeParticipant(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeAssistantFormAnswers(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->text = commonTools::FormattedTextFromArray( $this->profile->getLeadershipAssistantArray() );

    return sfView::SUCCESS;
  }


  public function executeAssistantFormAnswersPDF(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $title = 'Leadership Assistant Form for '.$this->profile->getName();
    $this->pdf = commonTools::FormattedPDFFromArray( $this->profile->getLeadershipAssistantArray(), $title );

    return sfView::SUCCESS;
  }


  public function executeParticipantUpdate(sfWebRequest $request)
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

  public function executeParticipantDelete(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->profile->delete();

    $this->redirect('leadership/participants');
    return sfView::SUCCESS;
  }

// CASCADE DOCUMENTATION for above action
// SELECT profile.ID, profile.FULL_NAME, profile.FIRST_NAME, profile.MIDDLE_NAME, profile.LAST_NAME, profile.ADDRESS1, profile.ADDRESS2, profile.CITY, profile.STATE_PROV, profile.ZIP_POSTCODE, profile.COUNTRY, profile.TELEPHONE1, profile.TELEPHONE2, profile.EMAIL1, profile.EMAIL2, profile.GENDER, profile.AGE, profile.SECRET, profile.CREATED_AT, profile.UPDATED_AT, profile.EXTRA1, profile.EXTRA2, profile.EXTRA3, profile.EXTRA4, profile.EXTRA5, profile.EXTRA6, profile.EXTRA7, profile.EXTRA8, profile.EXTRA9, profile.EXTRA10, profile.EXTRA11, profile.EXTRA12, profile.EXTRA13, profile.EXTRA14, profile.EXTRA15, profile.EXTRA16, profile.EXTRA17, profile.EXTRA18, profile.EXTRA19, profile.EXTRA20 FROM `profile` WHERE profile.ID=20

// DELETE FROM tribe_participant WHERE tribe_participant.PROFILE_ID=20

// DELETE FROM medical WHERE medical.PROFILE_ID=20

// DELETE FROM program_questionnaire WHERE program_questionnaire.PROFILE_ID=20

// DELETE FROM dietary WHERE dietary.PROFILE_ID=20

// DELETE FROM profile WHERE profile.ID=20

  public function executeLeaderDelete(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->profile->delete();

    $this->redirect('leadership/leaders');
    return sfView::SUCCESS;
  }

  public function executeLeaderUpdate(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );


    $this->profile->setFirstName( $request->getParameter('first_name') );
    $this->profile->setLastName( $request->getParameter('last_name') );
    $this->profile->setEmail1( $request->getParameter('email1') );
    $this->profile->setGender( $request->getParameter('gender') );
    $this->profile->setAge( $request->getParameter('age') );

    $this->profile->save();

    $this->tribe_id = $this->profile->getTribeId(); 
    $this->setTemplate('leader');


    return sfView::SUCCESS;
  }

  public function executeAddLeader(sfWebRequest $request)
  {
    $this->profile = new Profile();
    $this->profile->save();
    $this->tribe_id = TribePeer::GetUnassignedTribeId();
    $this->profile->setTribe( $this->tribe_id, 'leader' );

    $this->profile_id = $this->profile->getId();

    
    $this->setTemplate('participant');

    return sfView::SUCCESS;
  }


  public function executeLeaders(sfWebRequest $request)
  {

    // get list of leaders
    $this->participants = ProfilePeer::AllLeaders( );


    return sfView::SUCCESS;
  }

  public function executeTransferLeader(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');
    // get list of tribes
    $this->tribes = TribePeer::CurrentTribes();

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }

  public function executeTransferLeaderUpdate(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );
    $this->profile->addToTribe( $this->tribe_id, 'leader' );

    $this->redirect('leadership/leader?id='.$this->profile_id.'&tribe_id='.$this->tribe_id);
 
    return sfView::SUCCESS;

  }

  public function executeLeader(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    return sfView::SUCCESS;
  }



  public function executeAssistants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchAssistants( $this->q );
    }
    else {
      // get list of participants
      $this->participants = ProfilePeer::AllAssistants( );
    }

    return sfView::SUCCESS;
  }


  public function executeAddAssistant(sfWebRequest $request)
  {
    $this->profile = new Profile();
    $this->profile->save();
    $this->tribe_id = TribePeer::GetUnassignedTribeId();
    $this->profile->setTribe( $this->tribe_id, 'assistant' );

    $this->profile_id = $this->profile->getId();

    
    $this->setTemplate('participant');

    return sfView::SUCCESS;
  }


  public function executeDeDupe(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->tribe_id = $request->getParameter('tribe_id');

    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->results = "___\n";

    if(isset($this->profile)){
      $this->results .= $this->profile->deDuplicate();
    }
    
    //$this->redirect('leadership/participant?id='.$this->profile_id.'&tribe_id='.$this->tribe_id);

    return sfView::SUCCESS;
  }







  public function executeAnnualAssistants(sfWebRequest $request)
  {
    $this->q = $request->getParameter('q');
    if($this->q != ''){
      // search participants
      $this->participants = ProfilePeer::SearchAnnualAssistants( $this->q );
    }
    else {
      // get list of participants
      $this->participants = ProfilePeer::AllAnnualAssistants( );
    }

    return sfView::SUCCESS;
  }



// TO DO: T Beutel 11/15/2011
// - find example CSV file from Marsha
// - swap below with exportTribe func


  public function executeExportAnnualAssistantsQuestionnaire(sfWebRequest $request)
  {
    $header   = 1;  // a flag for outputting the header 
    $content  = ''; // the CSV content


      // get list of participants
      $participants = ProfilePeer::AllAnnualAssistants( );

      foreach($participants as $profile){
        $name = $profile->getName();
        $name = preg_replace('/[^A-Za-z0-9]/',"-",$name);
        $array = $profile->getAnnualQuestionnaireArray();
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
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Annual-Assistants-Questionnaire.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;   
  }


  public function executeAnnualAssistantDelete(sfWebRequest $request)
  {
    $this->profile_id = $request->getParameter('id');
    $this->profile = ProfilePeer::retrieveByPk( $this->profile_id );

    $this->profile->delete();

    $this->redirect('leadership/annualAssistants');
    return sfView::SUCCESS;
  }


}


