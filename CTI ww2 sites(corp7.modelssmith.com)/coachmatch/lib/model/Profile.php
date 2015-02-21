<?php

class Profile extends BaseProfile
{

  public function determineAndSetCountryGroup( ) {
    // see ProfilePeer::addNewProfile()

    // look at courses taken, starting with ITB and working backwards
    // if region matches LON or MAN, set country group to 1, else 0


    // TO DO:
    // - after 9/9, new students will be group 2, and UK group 3
    // - date determined by student.course_fundamentals date > 9/8/11

    $took_after_9_9_11 = 0;
    $student = $this->getStudentRecord();
	//echo $this->getEmail();
    //print_r($student);
	//exit;
    // Determine whenever this student took fundmentals on or after 9/9/2011
     if($student)
	 {
		$fundamentals_date = $student->getFundamentalsDate();
		 
		if($fundamentals_date != ''){
		  $fundamentals_time = strtotime($fundamentals_date);
		  $cutover_time	= strtotime(date('9/8/2011'));
		  if($fundamentals_time > $cutover_time){
			$took_after_9_9_11 = 1;
		  }
		}
	}

    // OVERRIDE: 5/10/2013
    // mark all students now as after 9/9/11
    $took_after_9_9_11 = 1;

    $country_group = $took_after_9_9_11 == 1 ? 2 : 0; // default for US and Canada



    // if LON or MAN, set CountryGroup for UK
    if($student){
      $itb = $this->getCourseInTheBones();
      if(preg_match('/\.(LON|MAN)/i',$itb)){
        $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
      }
      else {
        $pro = $this->getCourseProcess();
        if(preg_match('/\.(LON|MAN)/i',$pro)){
          $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
        }
        else {
          $pro = $this->getCourseBalance();
          if(preg_match('/\.(LON|MAN)/i',$pro)){
            $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
          }
          else {
            $pro = $this->getCourseFulfillment();
            if(preg_match('/\.(LON|MAN)/i',$pro)){
              $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
            }
            else {
              $pro = $this->getCourseFundamentals();
              if(preg_match('/\.(LON|MAN)/i',$pro)){
                $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
              }
              else {
                // use Country instead
                $country = $this->getCountry();
                if(preg_match('/(britain|united kingdom|england|ireland|scotland|uk)/i',$country)){
                  $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
                }
                // Ticket #559:  Checking the country.  If it was set to USA or Canada, then set the 
                // country_group to US.  If it was not set so, then check the location.  If the location
                // was set to US, then set the country_group to US.
                else if (preg_match('/(usa|canada)/i',$country)) {
                    $country_group = $took_after_9_9_11 == 1 ? 2 : 1; // US
                } else {
                  // use Location instead
                  $location = $this->getLocation();
                  if(preg_match('/UK/',$location)){
                    $country_group = $took_after_9_9_11 == 1 ? 3 : 1; // UK
                  } else if (preg_match('/US/',$location)) {
                      $country_group = $took_after_9_9_11 == 1 ? 2 : 1; // US
                  }
                }
              }
            }
          }
        }     
      }
    }

    $this->setCountryGroup( $country_group );
    
    return;

    // OLD CODE...
    // // abstract this into a module...
    // $country_group = 0; // default for US and Canada
    // if(preg_match('/(britain|united kingdom|england)/i',$country)){
    //   $country_group = 1; // UK
    // }
    // $profile->setCountryGroup( $country_group );

  }

  public function updateSynergyStatus(){
    // updates coach's country group if they have finished Synergy or the bridging content
    // if student->getCompletedBridgingContentDate() not null
    // or student->getSynergyDate() is > 9/9
    // then change Country Group

    $student = $this->getStudentRecord();

    if(isset($student)){
      $bridging_content_date = $student->getCompletedBridgingContentDate();
      $synergy_date          = $student->getSynergyDate();
 
      $bridging_content_time = strtotime($bridging_content_date);
      $synergy_time          = strtotime($synergy_date);

      $bc_compare  = strtotime(date('8/22/2011'));
      $syn_compare = strtotime(date('9/8/2011'));

      if($bridging_content_time > $bc_compare || $synergy_time > $syn_compare){
        if($this->getCountryGroup() == 1){ // UK
          $this->setCountryGroup( 3 );
        }
        else if( $this->shouldBeUK() ){ // UK
          $this->setCountryGroup( 3 );
        }
        else {
          $this->setCountryGroup( 2 ); // US and Canada
        }
      }
    }
  }

  public function shouldBeUK() {
    $result = 0; // 0 == not UK

    $itb = $this->getCourseInTheBones();
    if(preg_match('/\.(LON|MAN)/i',$itb)){
      $result = 1; // 1 == UK
    }
    else {
      $pro = $this->getCourseProcess();
      if(preg_match('/\.(LON|MAN)/i',$pro)){
        $result = 1;
      }
      else {
        $pro = $this->getCourseBalance();
        if(preg_match('/\.(LON|MAN)/i',$pro)){
          $result = 1;
        }
        else {
          $pro = $this->getCourseFulfillment();
          if(preg_match('/\.(LON|MAN)/i',$pro)){
            $result = 1;
          }
          else {
            $pro = $this->getCourseFundamentals();
            if(preg_match('/\.(LON|MAN)/i',$pro)){
              $result = 1;
            }
            else {
              // use Country instead
              $country = $this->getCountry();
              if(preg_match('/(britain|united kingdom|england|ireland|scotland)/i',$country)){
                $result = 1;
              }
              else {
                // use Location instead
                $location = $this->getLocation();
                if(preg_match('/lon|UK/i',$location)){
                  $result = 1;
                }
              }
            }
          }
        }
      }     
    }

    return $result;
  }

  public function getStudentRecord() {
    $c = new Criteria();
    $c->add(StudentPeer::EMAIL, $this->getEmail() );
    $student = StudentPeer::doSelectOne( $c );
    return $student;
  }

  public function getCountryGroupName() {
    $cg = $this->getCountryGroup();
    if( $cg == 0 ) {
      return 'US/Canada';
    }
    else if( $cg == 1 ) {
      return 'UK';
    }
    else if( $cg == 2 ) {
      return 'US/Canada (Synergy)';
    }
    else if( $cg == 3 ) {
      return 'UK (Synergy)';
    }
    
  }

  public function setPasswordToWelcome() {
    $sf_guard_user = sfGuardUserPeer::retrieveByPk( $this->getSfGuardUserId() );
    $sf_guard_user->setPassword( 'welcome' );
    $sf_guard_user->save();               
  }

  public function addFeedbackComment( $text ) {
    $feedback = new Feedback();
    $feedback->setProfileId( $this->getId() );
    $feedback->setAttribute( 'comment' );
    $feedback->setValue( $text );
    $feedback->setFeedbackDate( date('Y-M-d H:i:s') );
    $feedback->save();
  }



  public function changeEmailAddress( $email ) {
    // check for duplicate email address in sfGuard
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, $email);
    $sf_guard_user = sfGuardUserPeer::doSelectOne( $c );
    if(isset($sf_guard_user)){
      return false;
    }
    
    // if OK
    
    $this->setEmail($email);
    $this->save();

    // get related sfGuard
    $sf_guard_user = sfGuardUserPeer::retrieveByPk( $this->getSfGuardUserId() );
    
    $sf_guard_user->setUsername( $email );
    $sf_guard_user->save();

    return true;
  }


  // ==================================
  // Contact related functions

  public function incrementContactCount() {
    $count = $this->getContactCount();
    if($count == '' || !isset($count)){
      $count = 0;
    }
    $count = $count + 1;
    $this->setContactCount( $count );
  }

  public function hasReachedContactLimit( $limit = 2 ) {
    $count =  $this->getContactCount();
    return $count >= $limit;
  }

  public function wasAlreadyContactedBy( $client ) {
    $c = new Criteria();
    $c->add(ActivityPeer::CLIENT_ID, $client->getId() );
    $c->add(ActivityPeer::COACH_ID, $this->getId() );
    $c->add(ActivityPeer::DECRIPTION, 'first_contact' );
    $activity = ActivityPeer::doSelectOne( $c );
    return isset($activity);
  }

  public function setFirstContact ( $client ) {
      // set coach's first contact for this client
      $activity = new Activity();
      $activity->setClientId( $client->getId() );
      $activity->setCoachId( $this->getId() );
      $activity->setDecription( 'first_contact' ); // decription misspelled in schema
      $activity->setActivityDate( date('Y-m-d H:i:s') );
      $activity->save();
  }

  public function setAddClient ( $client_id ) {
      // set coach's first contact for this client
      $activity = new Activity();
      $activity->setClientId( $client_id );
      $activity->setCoachId( $this->getId() );
      $activity->setDecription( 'added_client' ); // decription misspelled in schema
      $activity->setActivityDate( date('Y-m-d H:i:s') );
      $activity->save();
  }
  
  public function removeClient( $client_id ) {
    // find the Activity and remove it
    $c = new Criteria();
    $c->add(ActivityPeer::CLIENT_ID, $client_id);
    $c->add(ActivityPeer::COACH_ID, $this->getId() );
    $c->add(ActivityPeer::DECRIPTION, 'added_client' );
    $activity = ActivityPeer::doSelectOne( $c );
    $activity->setDecription( 'admin_removed_client' );
    $activity->setActivityDate( date('Y-m-d H:i:s') );
    $activity->save();
  }

  public function getContacts() {
    // profiles that have contacted but are not yet clients
    $c = new Criteria();
    $c->add(ActivityPeer::COACH_ID, $this->getId() );
    $c->add(ActivityPeer::DECRIPTION, 'first_contact' );
    
    $activities = ActivityPeer::doSelect( $c );

    $contacts = array( );
    foreach($activities as $a){
      $c = new Criteria();
      $c->add(ActivityPeer::COACH_ID, $this->getId() );
      $c->add(ActivityPeer::CLIENT_ID, $a->getClientId() );
      $c->add(ActivityPeer::DECRIPTION, 'added_client' );
      $activity = ActivityPeer::doSelectOne( $c );

      // make sure client was not already added
      if(!isset($activity)){
        $contact = ProfilePeer::retrieveByPk( $a->getClientId() );
        $contacts[] = $contact;
      }
    }

    return $contacts;
  }

  public function getClients() {
    // profiles that are clients
    $c = new Criteria();
    $c->add(ActivityPeer::COACH_ID, $this->getId() );
    $c->add(ActivityPeer::DECRIPTION, 'added_client');
    $activities = ActivityPeer::doSelect( $c );

    $clients = array( );
    foreach($activities as $a){
      $client = ProfilePeer::retrieveByPk( $a->getClientId() );
      $clients[] = $client;
    }

    return $clients;
  }

  public function numberOfClients( ) {
    $clients = $this->getClients();
    return count($clients);
  }

  public function reachedMaxClients( ) {
    $clients = $this->getClients();
    if(count($clients) >= 5){
      return true;
    } else {
      return false;
    }
  }


  // ==================================
  // Credential related functions

  public function getRole() {
    $c = new Criteria();
    $c->add(sfGuardUserGroupPeer::USER_ID, $this->getSfGuardUserId() );
    $user_group = sfGuardUserGroupPeer::doSelectOne( $c );
    if(isset($user_group)){
      if($user_group->getGroupId() == 2){
        return 'Coach';
      }
    }
    if($this->getLevel() > 4){
      return 'Coach';
    }
    return 'Student'; 
    //return 'Client';
  }

  public function getLevel() {
    $c = new Criteria();
    $c->add(StudentPeer::EMAIL, $this->getEmail() );
    $student = StudentPeer::doSelectOne( $c );
    if(isset($student)){
      $level = $student->getLevel();
      $synergy_date = $student->getSynergyDate();
      if($synergy_date != ''){
        $now = time();
        $synergy_time = strtotime($synergy_date);
        if($now > $synergy_time){
          return 5;
        }
      }
      if($level == -1){ // level is overridden
        return 4;
      }
      else {
        return $level;
      }
    }
    return 0;
  }

  public function setCoachCredential() {
    // add coach credential to this profile
    $c = new Criteria();
    $c->add(sfGuardGroupPeer::NAME,'coaches');
    $group = sfGuardGroupPeer::doSelectOne( $c );
    
    $sf_user_id = $this->getSfGuardUserId();
    
    // does group exist? (it should, if not, there is something really wrong)
    if(isset($group)){
      $c = new Criteria();
      $c->add(sfGuardUserGroupPeer::USER_ID, $this->getSfGuardUserId() );
      $user_group = sfGuardUserGroupPeer::doSelectOne( $c );

      if(isset($user_group)){
        $user_group->delete();
      }

      // does user_group exist? if not create it

      $user_group = new sfGuardUserGroup();
      $user_group->setUserId( $this->getSfGuardUserId() );
      $user_group->setGroupId( $group->getId() );
      $user_group->save();
      
      $c = new Criteria();
      $c->add(ProfileExtraPeer::ATTRIBUTE, 'CredentialUpdated');
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId());
      $attribute = ProfileExtraPeer::doSelectOne( $c );

      if(!isset($attribute)){
        $attribute = new ProfileExtra();
        $attribute->setAttribute('CredentialUpdated');
      }
      $attribute->setProfileId( $this->getId() );
      $attribute->setValue( date('D M j, Y') . ' ' . $sf_user_id . ' ' . $group->getId()  );
      $attribute->save();

      // this person now belongs to 'coaches' group
    }
    else {
      exit("Error in setting 'coaches' credential - please contact CTI administrator");
    }
  }


  public function setCredentialGroup( $group_name ) {

    // add credential to this profile
    $c = new Criteria();
    $c->add(sfGuardGroupPeer::NAME, $group_name );
    $group = sfGuardGroupPeer::doSelectOne( $c );
    
    // does group exist? (it should, if not, there is something really wrong)
    if(isset($group)){
      $c = new Criteria();
      $c->add(sfGuardUserGroupPeer::USER_ID, $this->getSfGuardUserId() );
      $user_group = sfGuardUserGroupPeer::doSelectOne( $c );

      // does user_group exist? if not create it
      if(!isset($user_group)){
        $user_group = new sfGuardUserGroup();
        $user_group->setUserId( $this->getSfGuardUserId() );
      }
      $user_group->setGroupId( $group->getId() );
      $user_group->save();
      // this person now belongs to group
    }
    else {
      exit("Error in setting '$group_name' credential - please contact CTI administrator");
    }
  }

  public function hasTakenInTheBones() {
    if($this->getLevel() > 4){ // $this->getLevel is a proxy for $student->getLevel
      return true;
    }

    //file_put_contents('/tmp/hasTakenInTheBones.log',"email: ".$this->getEmail(), FILE_APPEND );

    // check FileMaker
    $c = new Criteria();
    $c->add(StudentPeer::EMAIL, $this->getEmail() );
    $student = StudentPeer::doSelectOne( $c );
    if(isset($student) && $student->getLevel() != -1){ // getLevel() of -1 means override
      $fmid = $student->getFmId();
      //file_put_contents('/tmp/hasTakenInTheBones.log',"fmid: $fmid", FILE_APPEND);
      //$this->setFmid( $fmid );
      //$this->save();

      // check level in database
      // curl to webcomp (timeout 10 secs)
      $ch = curl_init();

      $baseurl  = sfConfig::get('app_webcomp_baseurl');
      $postkey  = sfConfig::get('app_webcomp_postkey');
      $endpoint = sfConfig::get('app_webcomp_getlevel');

      $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&fmid='.$fmid;

      //set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

      //execute post
      $response = curl_exec($ch);    
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
      //echo "httpCode - $response";
      if($httpCode == 200){
        if(preg_match('/^\d+$/i',$response)){
          $student->setLevel( $response );
          $student->save();
          $this->setLevel( $response );
          $this->save();
        }
      }

      //file_put_contents('/tmp/hasTakenInTheBones.log',"level: $level", FILE_APPEND);
      if($this->getLevel() > 4){
        return true;
      }
    }
    return false;
  }

  public function hasAccepted() {
    if( $this->getAgreeClicked() != ''){
      return 'Yes';
    }
    return 'No';
  }


  // FutureContacts
  // FutureContacts = 2 - ContactCount
  // Setting FutureContacts: ContactCount = 2 - FutureContacts
  public function getFutureContacts() {
    $futureContacts = (2 - $this->getContactCount() );
    return $futureContacts;
  }

  public function setFutureContacts( $count ){
    $this->setContactCount(2 - $count);
  }

  // ==================================
  // ProfileExtra get and set functions
  public function __call($name, $arguments) {
    // Note: value of $name is case sensitive.

    // ProfileExtra get___ function
    if( preg_match('/^get(.*)/', $name, $matches) ){
      $attribute = $matches[1];
      $c = new Criteria();
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId() );
      $c->add(ProfileExtraPeer::ATTRIBUTE, $attribute );
      $PE = ProfileExtraPeer::doSelectOne( $c );
      if(isset($PE)){
        return $PE->getValue();
      }
      return '';
    }

    // ProfileExtra set___ function
    else if( preg_match('/^set(.*)/', $name, $matches) ){
      $attribute = $matches[1];
      $value     = $arguments[0];
      // get ProfileExtra or create new one
      $c = new Criteria();
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId() );
      $c->add(ProfileExtraPeer::ATTRIBUTE, $attribute );
      $PE = ProfileExtraPeer::doSelectOne( $c );
      if(!isset($PE)){
        $PE = new ProfileExtra();
        $PE->setAttribute($attribute);
        $PE->setProfileId( $this->getId() );
      }
      $PE->setValue($value);
      $PE->save();
    }

    else {
      exit("lib/model/Profile.php error: $name function not found");
    }
  }

  

}
