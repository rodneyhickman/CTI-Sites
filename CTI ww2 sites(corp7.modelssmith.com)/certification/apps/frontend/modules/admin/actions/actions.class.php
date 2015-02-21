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

  public function executeSignInAs(sfWebRequest $request)
  {
    // get sfGuardUser and sign in as that user
    $id = $request->getParameter( 'id' );
    $profile = ProfilePeer::retrieveByPk( $id );
    if(isset($profile)){
        $user = sfGuardUserPeer::retrieveByPk( $profile->getSfGuardUserId() );
        $this->getContext()->getUser()->signIn( $user );

        // update user credentials if user finished ITB but cannot coach clients
        if($profile->hasFinishedCertification() && ! $this->getUser()->hasCredential('can_coach_clients') ){
          $profile->setCoachCredential();
          // perform a logout so that credentials will be updated on next login
          $this->redirect('profile/homeUpdated');
        }


        $this->redirect('profile/home');
    }
    $this->redirect('admin/index');
  }
  

  public function executeHome(sfWebRequest $request)
  {
  //  This function will ... 
    return sfView::SUCCESS;
  }

  public function executeManageUsers(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );
    $query = $request->getParameter( 'q' );

    $this->pager = ProfilePeer::SearchPager( $query, $page );

    return sfView::SUCCESS;
  }

  public function executeEditUser(sfWebRequest $request)
  {
    $id = $request->getParameter('post_id') > 0 ?
      $request->getParameter('post_id') :      
      $request->getParameter('id');
    $this->post_id = $id;

    //$profile->getNumberOfContactsMade();
    //

    if($id > 0){
      $profile = ProfilePeer::retrieveByPk( $id );
      $this->forward404Unless( isset($profile) );

      if(isset($profile)){
        $this->email = $profile->getEmail();
        if($request->isMethod('post')){
          $profile->fromArray($request->getParameterHolder()->getAll(), BasePeer::TYPE_FIELDNAME);
          $profile->setTimeZone($request->getParameter('time_zone'));
          $profile->setFutureContacts($request->getParameter('future_contacts'));
          $profile->save();
          $this->message = 'Changes have been saved';
        } 
      }

      $future_contacts  = $profile->getFutureContacts();
      //$level            = $profile->getLevel();
      //$this->has_taken  = $level > 4 ? 'Yes' : 'No';

      $this->clients     = $profile->getClients();
      $this->num_clients = count( $this->clients );
      $this->coach       = $id;

      $this->has_finished = $profile->hasFinishedCertification() ? 'Yes' : 'No';
      $this->is_faculty   = $profile->isFacultyCoach() ? 'Yes' : 'No';

      //$this->countryGroup = $profile->getCountryGroupName();


      $this->form = new AdminProfileEditForm(array(
         'name'      => $profile->getName(),
         'location'  => $profile->getLocation(),
         'time_zone' => $profile->getTimeZone(),
         'phone'     => $profile->getPhone(),
         'niche'     => $profile->getNiche(),
         'expertise' => $profile->getExpertise(),
         'future_contacts' => $future_contacts,
      ));
    

    }
    else {
      $this->forward404();
    }

    return sfView::SUCCESS;
  }

  public function executeRemoveStudent(sfWebRequest $request)
  { // the terms "student" and "client" are equivalent

    $coach_id   = $request->getParameter('coach');
    $client_id = $request->getParameter('client');

    if($coach_id > 0 and $client_id > 0){
      $coach_profile = ProfilePeer::retrieveByPk( $coach_id );
      $this->forward404Unless( isset($coach_profile) );

      $coach_profile->removeClient( $client_id );
    }

    $this->redirect('admin/editUser?id='.$coach_id.'&changed=1');
  }

  public function executeDeleteUser(sfWebRequest $request)
  {
    $id = $request->getParameter('id');

    if($id > 0){
      $profile = ProfilePeer::retrieveByPk($id);
      $profile->delete();
    }

    $this->redirect('admin/manageUsers');
  }

  public function executeContactCoaches(sfWebRequest $request)
  {
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    $profile = $this->getUser()->getProfile();

    $this->form = new ContactCoachesForm(
      array(
            'from' => $profile->getEmail(),                                     
            ));


      $this->total_emails = 0;

    if($request->isMethod('post')){

      // send email
      $from    = $request->getParameter('from');
      $message = $request->getParameter('message');
      $subject = $request->getParameter('subject');
      $test    = $request->getParameter('test');


      if($test == 'on'){
        $coaches[] = $profile;
      }
      else {
        $c = new Criteria();
        $c->add(StudentPeer::LEVEL, 5, Criteria::GREATER_EQUAL);
        $c->addJoin(StudentPeer::EMAIL, ProfilePeer::EMAIL);
        //$coaches = ProfilePeer::doSelect( $c );
      }

      foreach($coaches as $coach){
         $emailSent = commonTools::sendSwiftEmail($this,
                                   array(
                                         'mailto'      =>  $coach->getEmail(),
                                         'mailfrom'    =>  $from,
                                         'mailsubject' =>  $subject,
                                         'mailbody'    =>  $message,
                                         'cc'          =>  '',
                                         'bcc'         =>  ''
                                         )); 
         if($emailSent > 0){
           $this->total_emails++;
         }
      }
    }


    return sfView::SUCCESS;
  }

  public function executeActivityReports(sfWebRequest $request)
  {

    return sfView::SUCCESS;
  }

  public function executeReport(sfWebRequest $request)
  {
  //  This function will ... 
    return sfView::SUCCESS;
  }

  public function executeLengthOfEngagements(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );

    $this->pager = ActivityPeer::EngagementPager( $page );
    
    return sfView::SUCCESS;
  }

  public function executeWhoHadContacts(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );
    $query = $request->getParameter( 'q' );

    $this->pager = ActivityPeer::ContactSearchPager( $query, $page );

    return sfView::SUCCESS;
  }

  public function executeCoachClientLoad(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );
    $query = $request->getParameter( 'q' );

    $this->pager = ProfilePeer::ClientLoadPager( $page );

    return sfView::SUCCESS;
  }

  public function executeAcceptsAndNonAccepts(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );
    $query = $request->getParameter( 'q' );

    $this->pager = ProfilePeer::AcceptPager( $query, $page );

    return sfView::SUCCESS;
  }

  public function executeWhoHadEngagements(sfWebRequest $request)
  {
  //  This function will ... 
    return sfView::SUCCESS;
  }

  public function executeViewFeedback(sfWebRequest $request)
  {
    $page  = $request->getParameter( 'page', 1 );
    $query = $request->getParameter( 'q' );

    $this->pager = FeedbackPeer::SearchPager( $query, $page );
    
    return sfView::SUCCESS;
  }

  public function executeListOfUsers(sfWebRequest $request)
  {
    return sfView::SUCCESS;    
  }

  public function executeDoListOfUsers(sfWebRequest $request)
  {


    $c = new Criteria();
    $profiles = ProfilePeer::doSelect( $c );

    $content = "name,email,location,agree_clicked,group_id\n";

    foreach($profiles as $p){
      $name          = $p->getName();
      $email         = $p->getEmail();
      $location      = $p->getLocation();
      $agree_clicked = $p->getAgreeClicked();
      $c = new Criteria();
      $c->add(sfGuardUserGroupPeer::USER_ID, $p->getsfGuardUserId());
      $usergroup = sfGuardUserGroupPeer::doSelectOne( $c );
      $group_id      = $usergroup->getGroupId();
$content = $content . <<<CSV
"$name","$email","$location","$agree_clicked",$group_id

CSV;
    }
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename=Coach-Match-User-List.csv', TRUE);
    $this->getResponse()->setHttpHeader('Content-Length', (string) strlen($content), true);
    $this->getResponse()->sendHttpHeaders();

    echo $content;
    return sfView::NONE;    
  }


// =================== Manual Admin Functions - use URL to execute =====================



  public function executeUpdateCountryGroups(sfWebRequest $request)
  {
    $c = new Criteria();
    $profiles = ProfilePeer::doSelect( $c );
    foreach($profiles as $p){
      $p->determineAndSetCountryGroup();
    }

    $this->redirect('admin/manageUsers');
  }


}

?>
