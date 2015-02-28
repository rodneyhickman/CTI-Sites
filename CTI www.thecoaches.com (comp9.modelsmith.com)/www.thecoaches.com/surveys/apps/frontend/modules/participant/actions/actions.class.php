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
       return sfView::SUCCESS;
  }

  public function executeHomework(sfWebRequest $request)
  {
       return sfView::SUCCESS;
  }

  public function executeHomeworkProcess(sfWebRequest $request)
  {
    $this->redirect('participant/homeworkSaved');
  }

  public function executeHomeworkSaved(sfWebRequest $request)
  {
       return sfView::SUCCESS;
  }

  public function executeAudios(sfWebRequest $request)
  {
       return sfView::SUCCESS;
  }

  public function executeProgramForms(sfWebRequest $request)
  {
       return sfView::SUCCESS;
  }


}
