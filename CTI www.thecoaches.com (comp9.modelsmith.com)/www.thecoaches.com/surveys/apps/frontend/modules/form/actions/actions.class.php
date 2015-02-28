<?php

/**
 * form actions.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class formActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->survey_id = $request->getParameter( 'id', 0 );

    //if($this->survey_id == 0){
    //  $this->redirect('form/selectSurvey');
    //}

    $this->survey = SurveyPeer::retrieveByPk( $this->survey_id );  // survey contains questions, but no answers

    return sfView::SUCCESS;
  }

  public function executeSurveyProcess(sfWebRequest $request)
  {
    // get survey
    $this->survey_id = $request->getParameter( 'id', 0 );
    $this->survey = SurveyPeer::retrieveByPk( $this->survey_id );  

    // get user
    $this->profile = $this->getContext()->getUser()->getProfile();

    // get parameters
    $this->answers = $request->getParameter('question');

    // save using AnswerSet::saveAnswers
    $answer_set = AnswerSetPeer::saveAnswers( $this->profile, $this->survey, $this->answers );

    // redirect to thank you page
    $this->redirect('form/surveyThankYou');
    //return sfView::SUCCESS;
  }
 
  public function executeSurveyThankYou(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

 
}
