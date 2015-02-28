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
    $this->forward('default', 'module');
  }

  public function executeUpdateEvents(sfWebRequest $request)
  {
    $this->params = $request->getParameterHolder()->getAll();

    $this->results = EventPeer::updateEvents( $this->params );

    return sfView::SUCCESS;
  }

  public function executeUpdateSites(sfWebRequest $request)
  {
    $this->params = $request->getParameterHolder()->getAll();

    $this->results = SiteDataPeer::updateSites( $this->params );

    return sfView::SUCCESS;
  }
  
}
