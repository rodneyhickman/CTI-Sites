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
    $this->forward('admin', 'surveys');
  }

/* NEXT STEPS
 * (DONE) Add "admin" to profile
 * Authorize profile if email matches and is admin
 * Scholarship:
 ** get profile from logged in user, add to actions
 ** att getOneTimeKey() and setOneTimeKey() to user
 ** in verifyKey action, get profile from email address
 * /admin/respondents
 ** add code as in scholarship/leadership/leaderSelectionApplicants
 * /admin/respondent
 ** add code as in scholarship/leadership/applicant
 * survey->collateByName( $name ) -> collate survey results by leader name
 ** foreach answer for this name
 *** text answers, create array of answers (randomize order?)
 *** range answers, create array of counts and percents
 */


  public function executeAutologin(sfWebRequest $request)
  {
    // get key
    $key = $request->getParameter('key');

    // retrieve email from scholarship with key and secret
    $json = file_get_contents("http://ww2.thecoaches.com/scholarship/index.php/admin/verifyKey?key=$key&secret=fjgh15t");

    // 
    echo "<p>$json</p>";

    $results = json_decode($json,true);
    $email = $results['email'];

    echo "<p>$email</p>";

    // login and redirect
    if($results['status'] == 'ok' && $results['email'] != ''){
      // get the local profile record
      $profile = ProfilePeer::retrieveByEmail( $email );

      if(!isset($profile)){
        $profile = ProfilePeer::newProfile( $email );
      }

      // identify the profile to the user session
      $this->getContext()->getUser()->setProfile( $profile );

      // sign in this user session
      $this->getContext()->getUser()->signIn();

      if( $profile->isAdmin() ){
        $this->redirect('admin/index');
      }
      $this->redirect('participant/home');
    }

    return sfView::NONE;
  }

  // show list of surveys
  public function executeSurveys(sfWebRequest $request)
  {
    $c = new Criteria();
    $this->surveys = SurveyPeer::doSelect( $c );
    return sfView::SUCCESS;
  }

 // #819 show list of Archive respondents
  public function executeArchive(sfWebRequest $request)
  {
    $this->survey_id = $request->getParameter('survey_id');
    $this->alpha_sort = $request->getParameter('alpha_sort',0);
    $this->survey    = SurveyPeer::retrieveByPk( $this->survey_id );
    $this->leaders   = AnswerSetPeer::retrieveArchiveBySurvey( $this->survey_id, $this->alpha_sort );

    return sfView::SUCCESS;
  }
  
  
  public function executeLeaderarchive(sfWebRequest $request)
  {
    
	 
	$this->survey_id        = $request->getParameter('survey_id');
    $this->key              = $request->getParameter('key');
	
    $leader = LeaderPeer::retrieveByKey( $this->key, $this->survey_id );
	
    if(isset($leader)){
      $this->leader_name = $leader->getName();
	  
      $this->collated_answers = AnswerSetPeer::collateArchiveByLeader( $this->leader_name, $this->survey_id );  
      return sfView::SUCCESS;
    }
    $this->redirect('admin/leaderError');
  }
// #819 End



  // show list of respondents
  public function executeLeaders(sfWebRequest $request)
  {
    $this->survey_id = $request->getParameter('survey_id');
    $this->alpha_sort = $request->getParameter('alpha_sort',0);
    $this->survey    = SurveyPeer::retrieveByPk( $this->survey_id );
    $this->leaders   = AnswerSetPeer::retrieveLeadersBySurvey( $this->survey_id, $this->alpha_sort );

    return sfView::SUCCESS;
  }

  public function executeLeader(sfWebRequest $request)
  {
    $this->survey_id        = $request->getParameter('survey_id');
    $this->key              = $request->getParameter('key');

    $leader = LeaderPeer::retrieveByKey( $this->key, $this->survey_id );

    if(isset($leader)){
      $this->leader_name = $leader->getName();
      $this->collated_answers = AnswerSetPeer::collateAnswersByLeader( $this->leader_name, $this->survey_id ); // also merges dups, see AnswerSetPeer::retrieveLeadersBySurvey
      return sfView::SUCCESS;
    }
    $this->redirect('admin/leaderError');
  }


  // show individual respondent
  public function executeRespondent(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeLeaderError(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }


}
