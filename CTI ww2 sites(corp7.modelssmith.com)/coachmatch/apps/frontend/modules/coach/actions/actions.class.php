<?php

/**
 * coach actions.
 *
 * @package    sf_sandbox
 * @subpackage coach
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class coachActions extends sfActions
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

  public function executeSearch(sfWebRequest $request)
  {
    $this->form = new SearchForm();

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeSearchTestBed(sfWebRequest $request)
  {
    $this->form = new SearchForm();

    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeSearchAll(sfWebRequest $request)
  {
    $profile     = $this->getUser()->getProfile();

      $connection = Propel::getConnection();
      $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $countryGroup = $profile->getCountryGroup();
      if($countryGroup == 1){
        $countryGroup = 3;  // country group == 1 is obsolete - it was for pre-synergy students
      }
      $this->cg = $countryGroup;

      $this->words = '(searching all coaches)';

      $query = "select profile.id,value,name,location,niche,expertise from profile, profile_extra  where profile_extra.attribute='Availability' and profile_extra.profile_id=profile.id ORDER BY profile.id DESC";
      $query = sprintf($query);
      $statement = $connection->prepare($query);
      $statement->execute();
      $this->records = array();
      while($record = $statement->fetch(PDO::FETCH_OBJ)){
        // vars are: id, value, name, location, niche, expertise
        //if($record->SCORE >= $min_score && $record->value == 1){
        if($record->value == 1){ // Availability == 1
	  // match the found coaches with CountryGroup attribute in ProfileExtra
	  $c = new Criteria();
	  $c->add(ProfileExtraPeer::PROFILE_ID, $record->id );
	  $c->add(ProfileExtraPeer::ATTRIBUTE, 'CountryGroup' );
	  $coach = ProfileExtraPeer::doSelectOne( $c );
	  if(isset($coach)){
	    if($coach->getValue() == $countryGroup || $profile->getId() == 1460){ // allow all coaches for Elizabeth Martyn (id=1460)
	      array_push($this->records,$record); 
	    }
	  }
	}
      }
    

    $this->form = new SearchForm();
    $this->getResponse()->addCacheControlHttpHeader('no-cache');

    $this->setTemplate('searchResults');
  }

  public function executeSearchResults(sfWebRequest $request)
  {
    // Use the following:
    // ALTER TABLE profile ADD FULLTEXT(location,niche,expertise)
    // REPAIR TABLE profile

    $profile     = $this->getUser()->getProfile();

    if($request->isMethod('post') || $request->isMethod('get')){

      $words       = $request->getParameter('q');
      $words       = preg_replace('/\+/',' ',$words);
      $words       = preg_replace('/[^a-zA-Z0-9 ]/','',$words);
      $this->w           = split(' ',$words,7);
      $this->words = implode(' ', array_slice($this->w,0,6) );
      // TODO: untaint words, strip all nonchars, limit to first six words

      $min_score = sizeof(array_slice($this->w,0,6)); // number of words in query

      $connection = Propel::getConnection();
      $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $countryGroup = $profile->getCountryGroup();
      if($countryGroup == 1){
        $countryGroup = 3;  // country group == 1 is obsolete - it was for pre-synergy students
      }
      $this->cg = $countryGroup;

      // old boolean search did not work well - T .Beutel 5/31/2010
      //$query = "select profile.id,value,name,location,niche,expertise,MATCH (location,niche,expertise) AGAINST ('%s' in boolean mode) AS SCORE from profile, profile_extra  where profile_extra.attribute='Availability' and profile_extra.profile_id=profile.id ORDER BY SCORE DESC";
      //$query = sprintf($query,$this->words);

      $query = "select profile.id,value,name,location,niche,expertise from profile, profile_extra  where (location like '%%%s%%' or niche like '%%%s%%' or expertise like '%%%s%%') and profile_extra.attribute='Availability' and profile_extra.profile_id=profile.id ORDER BY profile.id DESC";
      $query = sprintf($query,$this->words,$this->words,$this->words);
      $statement = $connection->prepare($query);
      $statement->execute();

      $this->records = array();
      $this->data    = '';
      $this->data .= 'My countryGroup: '.$countryGroup."\n";
      while($record = $statement->fetch(PDO::FETCH_OBJ)){
        // vars are: id, value, name, location, niche, expertise
        //if($record->SCORE >= $min_score && $record->value == 1){
        $this->data .= 'name: '.$record->name."\n";
        $this->data .= 'location: '.$record->location."\n";

        if($record->value == 1){ // Availability == 1
	  // match the found coaches with CountryGroup attribute in ProfileExtra
	  $c = new Criteria();
	  $c->add(ProfileExtraPeer::PROFILE_ID, $record->id );
	  $c->add(ProfileExtraPeer::ATTRIBUTE, 'CountryGroup' );
	  $coach = ProfileExtraPeer::doSelectOne( $c );
	  if(isset($coach)){
            $this->data .= 'CountryGroup: '.$coach->getValue()."\n";
	    if($coach->getValue() == $countryGroup || $profile->getId() == 1460){ // allow all coaches for Elizabeth Martyn (id=1460)
	      array_push($this->records,$record); 
	    }
	  }
	}
      }
    }

    $this->form = new SearchForm();
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }


  public function executeSearchResultsTestBed(sfWebRequest $request)
  {
    // Use the following:
    // ALTER TABLE profile ADD FULLTEXT(location,niche,expertise)
    // REPAIR TABLE profile

    $profile     = $this->getUser()->getProfile();

    if($request->isMethod('post') || $request->isMethod('get')){

      $words       = $request->getParameter('q');
      $words       = preg_replace('/\+/',' ',$words);
      $words       = preg_replace('/[^a-zA-Z0-9 ]/','',$words);
      $this->w           = split(' ',$words,7);
      $this->words = implode(' ', array_slice($this->w,0,6) );
      // TODO: untaint words, strip all nonchars, limit to first six words

      $min_score = sizeof(array_slice($this->w,0,6)); // number of words in query

      $connection   = Propel::getConnection();
      $countryGroup = $profile->getCountryGroup();
      $this->cg = $countryGroup;
      $query = "select profile.id,profile_extra.value,name,location,niche,expertise,MATCH (location,niche,expertise) AGAINST ('%s' in boolean mode) AS SCORE from profile, profile_extra  where profile_extra.attribute='Availability' and profile_extra.profile_id=profile.id ORDER BY SCORE DESC";
      $query = sprintf($query,$this->words);
      $statement = $connection->prepare($query);
      $statement->execute();
      $this->records = array();


      while($record = $statement->fetch(PDO::FETCH_OBJ)){
        // vars are: id, value, name, location, niche, expertise, SCORE
        if($record->SCORE >= $min_score && $record->value == 1){
          // match the found coaches with CountryGroup attribute in ProfileExtra
          $c = new Criteria();
          $c->add(ProfileExtraPeer::PROFILE_ID, $record->id );
          $c->add(ProfileExtraPeer::ATTRIBUTE, 'CountryGroup' );
          $coach = ProfileExtraPeer::doSelectOne( $c );
          if(isset($coach)){
            if($coach->getValue() == $countryGroup){
              array_push($this->records,$record); 
            }
          }
        }   
      }

    }

    $this->form = new SearchForm();
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    return sfView::SUCCESS;
  }

  public function executeContact(sfWebRequest $request)
  {
    $client     = $this->getUser()->getProfile();

    // check if N contacts has been already reached, if so redirect
    if( $client->hasReachedContactLimit() ){
      $this->redirect('profile/reachedContactLimit');
    }

    $this->form = new CoachContactForm();

    $this->coach_id = $request->getParameter('id');
    $coach = ProfilePeer::retrieveByPk($this->coach_id);
    $this->forward404Unless(isset($coach));

    $this->from_name = $client->getName();
    $this->to_name   = $coach->getName();

    // check if contact was already made to this coach, if so redirect
    if( $coach->wasAlreadyContactedBy( $client ) ){
      $this->redirect('coach/alreadyContacted');
    }

    if($request->isMethod('post')){

      
      // send email
      $message = 
        "Please respond to the client's communication regarding your availability. You can respond by replying to this email.\n\n";
      $message = $message . "Email address: ".$client->getEmail()."\n\n";
      $message = $message . $request->getParameter('message');
      $emailSent = commonTools::sendSwiftEmail($this,
                                   array(
                                         'mailto'      =>  $coach->getEmail(),
                                         'mailfrom'    =>  $client->getEmail(),
                                         'mailsubject' =>  'CTI Coach Match - I would like to have you coach me',
                                         'mailbody'    =>  $message,
                                         'cc'          =>  '',
                                         'bcc'         =>  ''
                                         )); 
      if($emailSent > 0){
        $coach->setFirstContact( $client );
        $client->incrementContactCount();
      }

      // redirect to messageSent
      $this->redirect('coach/messageSent');
    }

    return sfView::SUCCESS;
  }

  public function executeMessageSent(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }

  public function executeAlreadyContacted(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }


  public function executeTryEmail(sfWebRequest $request)
  {
    $mailBody = 'This is the body of an email sent from Symfony Swift Mailer.';
    $mailFrom = 'ping@me.com';
    $mailTo = 'thomas@modelsmith.com';
    $mailSubject = 'Subject of the email';
    $contentType = 'text/html';
    $port=null;
    $encryption=null;
     $server = '127.0.0.1';
     //   $server = sfConfig::get('app_smtp_server_ip');  // get from app.yml
    // Create the mailer and message objects
    try
    {
      // Establish connection
      $mailer = new Swift(new Swift_Connection_SMTP($server, $port, $encryption));  // SMTP connection
      // Create a message
      $message = new Swift_Message($mailSubject);
      // Add some parts
      $message->attach(new Swift_Message_Part($mailBody, 'text/plain'));
      $message->attach(new Swift_Message_Part($mailBody, 'text/html'));
      // Send
      $nbrSent = $mailer->send($message, $mailTo, $mailFrom);
    // log the email
    $this->logMessage('Number of Emails sent: '.$nbrSent, 'debug');  
    $this->logMessage('Raw Email - MailTo: '.$mailTo.' MailFrom: '.$mailFrom.' MailSubject: '.$mailSubject.' MailBody: '.$mailBody.' ContentType: '.$contentType, 'debug');  
      $mailer->disconnect();
    }
    catch (Exception $e)
    {
      $mailer->disconnect();
      // handle errors here
      $this->logMessage('Action TryEmail, Caught exception: '.$e->getMessage());
    }  
    return sfView::SUCCESS;
  }
}
