<?php

class Profile extends BaseProfile
{

  public function determineAndSetCountryGroup() {
    // look at courses taken, starting with ITB and working backwards
    // if region matches LON or MAN, set country group to 1, else 0

    $student = $this->getStudentRecord();
    $country_group = 0; // default for US and Canada

    // if LON or MAN, set CountryGroup for UK
    if($student){
      $itb = $this->getCourseInTheBones();
      if(preg_match('/\.(LON|MAN)/i',$itb)){
        $country_group = 1; // UK
      }
      else {
        $pro = $this->getCourseProcess();
        if(preg_match('/\.(LON|MAN)/i',$pro)){
          $country_group = 1; // UK
        }
        else {
          $pro = $this->getCourseBalance();
          if(preg_match('/\.(LON|MAN)/i',$pro)){
            $country_group = 1; // UK
          }
          else {
            $pro = $this->getCourseFulfillment();
            if(preg_match('/\.(LON|MAN)/i',$pro)){
              $country_group = 1; // UK
            }
            else {
              $pro = $this->getCourseFundamentals();
              if(preg_match('/\.(LON|MAN)/i',$pro)){
                $country_group = 1; // UK
              }
              else {
                // use Country instead
                $country = $this->getCountry();
                if(preg_match('/(britain|united kingdom|england|ireland|scotland)/i',$country)){
                  $country_group = 1; // UK
                }
                else {
                  // use Location instead
                  $location = $this->getLocation();
                  if(preg_match('/UK/',$location)){
                    $country_group = 1; // UK
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
    if( $cg == 1 ) {
      return 'UK';
    }
    
  }

  public function getFirstName(){
      $c = new Criteria();
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId() );
      $c->add(ProfileExtraPeer::ATTRIBUTE, 'FirstName' );
      $PE = ProfileExtraPeer::doSelectOne( $c );
      if(isset($PE)){
        return $PE->getValue();
      }
      // try splitting getName()
      $array = Profile::parse_name($this->getName());
      if($array['first']!=''){
        return $array['first'];
      }

      return '';
  }

  public function getLastName(){
      $c = new Criteria();
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId() );
      $c->add(ProfileExtraPeer::ATTRIBUTE, 'LastName' );
      $PE = ProfileExtraPeer::doSelectOne( $c );
      if(isset($PE)){
        return $PE->getValue();
      }
      // try splitting getName()
      $array = Profile::parse_name($this->getName());
      if($array['last']!=''){
        return $array['last'];
      }

      return '';
  }

  public function getMiddleInitial(){
      $c = new Criteria();
      $c->add(ProfileExtraPeer::PROFILE_ID, $this->getId() );
      $c->add(ProfileExtraPeer::ATTRIBUTE, 'MiddleInitial' );
      $PE = ProfileExtraPeer::doSelectOne( $c );
      if(isset($PE)){
        return $PE->getValue();
      }
      // try splitting getName()
      $array = Profile::parse_name($this->getName());
      if($array['middle']!=''){
        return $array['middle'];
      }

      return '';
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
    return 'Student'; 
    //return 'Client';
  }

  public function getLevel() {
    $c = new Criteria();
    $c->add(StudentPeer::EMAIL, $this->getEmail() );
    $student = StudentPeer::doSelectOne( $c );
    if(isset($student)){
      return $student->getLevel();
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
    //$c = new Criteria();
    //$c->add(StudentPeer::PROFILE_ID, $this->getId() );
    //$c->add(StudentPeer::IN_THE_BONES_DATE, null, Criteria::ISNOTNULL);
    //$student = StudentPeer::doSelectOne( $c );
    //return isset($student);
    if($this->getLevel() > 4){
      return true;
    }
    return false;
  }

  public function hasFinishedCertification() {
    // get student record by profile id
    $c = new Criteria();
    $c->add(StudentPeer::PROFILE_ID, $this->getId() );
    $student = StudentPeer::doSelectOne( $c );
    if(!isset($student)){
      // try getting student record by email address
      $c = new Criteria();
      $c->add(StudentPeer::EMAIL, $this->getEmail() );
      $student = StudentPeer::doSelectOne( $c );
    }
    if(isset($student)){
      return $student->isCpccCoach(); // will return true if cert date set or CPCC in name
    }
    return false;
  } 

  public function isFacultyCoach() {
    // get student record by profile id
    $c = new Criteria();
    $c->add(StudentPeer::PROFILE_ID, $this->getId() );
    $student = StudentPeer::doSelectOne( $c );
    if(!isset($student)){
      // try getting student record by email address
      $c = new Criteria();
      $c->add(StudentPeer::EMAIL, $this->getEmail() );
      $student = StudentPeer::doSelectOne( $c );
    }
    if(isset($student)){
      return $student->isFacultyCoach(); // 
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

  
/*
Name:	nameparse.php
Version: 0.2a
Date:	030507
First:	030407
License:	GNU General Public License v2
Bugs:	If one of the words in the middle name is Ben (or St., for that matter),
		or any other possible last-name prefix, the name MUST be entered in
		last-name-first format. If the last-name parsing routines get ahold
		of any prefix, they tie up the rest of the name up to the suffix. i.e.:
		
		William Ben Carey	would yield 'Ben Carey' as the last name, while,
		Carey, William Ben	would yield 'Carey' as last and 'Ben' as middle.

		This is a problem inherent in the prefix-parsing routines algorithm,
		and probably will not be fixed. It's not my fault that there's some
		odd overlap between various languages. Just don't name your kids
		'Something Ben Something', and you should be alright.

*/

public static function	norm_str($string) {
	return	trim(strtolower(
		str_replace('.','',$string)));
	}

public static function	in_array_norm($needle,$haystack) {
	return	in_array(Profile::norm_str($needle),$haystack);
	}

public static function	parse_name($fullname) {
	$titles			=	array('dr','miss','mr','mrs','ms','judge');
	$prefices		=	array('ben','bin','da','dal','de','del','der','de','e',
							'la','le','san','st','ste','van','vel','von');
	$suffices		=	array('esq','esquire','jr','sr','2','ii','iii','iv','cpcc','mcc','mfa','pcc','acc','phd','lcsw','mph','ma','ms');

	$pieces			=	explode(',',preg_replace('/\s+/',' ',trim($fullname)));
	$n_pieces		=	count($pieces);
        $out = array('first'=>'','last'=>'','suffix'=>'','middle'=>'','title'=>'');
	switch($n_pieces) {
		case	1:	// array(title first middles last suffix)
			$subp	=	explode(' ',trim($pieces[0]));
			$n_subp	=	count($subp);
			for($i = 0; $i < $n_subp; $i++) {
				$curr				=	trim($subp[$i]);
				if(isset($subp[$i+1])){$next				=	trim($subp[$i+1]);}
                               

				if($i == 0 && Profile::in_array_norm($curr,$titles)) {
					$out['title']	=	$curr;
					continue;
					}

				if(!$out['first']) {
					$out['first']	=	$curr;
					continue;
					}

				if($i == $n_subp-2 && $next && Profile::in_array_norm($next,$suffices)) {
					if($out['last']) {
						$out['last']	.=	" $curr";
						}
					else {
						$out['last']	=	$curr;
						}
					$out['suffix']		=	$next;
					break;
					}

				if($i == $n_subp-1) {
					if($out['last']) {
						$out['last']	.=	" $curr";
						}
					else {
						$out['last']	=	$curr;
						}
					continue;
					}

				if(Profile::in_array_norm($curr,$prefices)) {
					if($out['last']) {
						$out['last']	.=	" $curr";
						}
					else {
						$out['last']	=	$curr;
						}
					continue;
					}

				if($next == 'y' || $next == 'Y') {
					if($out['last']) {
						$out['last']	.=	" $curr";
						}
					else {
						$out['last']	=	$curr;
						}
					continue;
					}

				if($out['last']) {
					$out['last']	.=	" $curr";
					continue;
					}

				if($out['middle']) {
					$out['middle']		.=	" $curr";
					}
				else {
					$out['middle']		=	$curr;
					}
				}
			break;
		case	2:
				switch(Profile::in_array_norm($pieces[1],$suffices)) {
					case	TRUE: // array(title first middles last,suffix)
						$subp	=	explode(' ',trim($pieces[0]));
						$n_subp	=	count($subp);
						for($i = 0; $i < $n_subp; $i++) {
							$curr				=	trim($subp[$i]);
							$next				=	trim($subp[$i+1]);

							if($i == 0 && Profile::in_array_norm($curr,$titles)) {
								$out['title']	=	$curr;
								continue;
								}

							if(!$out['first']) {
								$out['first']	=	$curr;
								continue;
								}

							if($i == $n_subp-1) {
								if($out['last']) {
									$out['last']	.=	" $curr";
									}
								else {
									$out['last']	=	$curr;
									}
								continue;
								}

							if(Profile::in_array_norm($curr,$prefices)) {
								if($out['last']) {
									$out['last']	.=	" $curr";
									}
								else {
									$out['last']	=	$curr;
									}
								continue;
								}

							if($next == 'y' || $next == 'Y') {
								if($out['last']) {
									$out['last']	.=	" $curr";
									}
								else {
									$out['last']	=	$curr;
									}
								continue;
								}
	
							if($out['last']) {
								$out['last']	.=	" $curr";
								continue;
								}

							if($out['middle']) {
								$out['middle']		.=	" $curr";
								}
							else {
								$out['middle']		=	$curr;
								}
							}						
						$out['suffix']	=	trim($pieces[1]);
						break;
					case	FALSE: // array(last,title first middles suffix)
						$subp	=	explode(' ',trim($pieces[1]));
						$n_subp	=	count($subp);
						for($i = 0; $i < $n_subp; $i++) {
							$curr				=	trim($subp[$i]);
							$next				=	trim($subp[$i+1]);

							if($i == 0 && Profile::in_array_norm($curr,$titles)) {
								$out['title']	=	$curr;
								continue;
								}

							if(!$out['first']) {
								$out['first']	=	$curr;
								continue;
								}

						if($i == $n_subp-2 && $next &&
							Profile::in_array_norm($next,$suffices)) {
							if($out['middle']) {
								$out['middle']	.=	" $curr";
								}
							else {
								$out['middle']	=	$curr;
								}
							$out['suffix']		=	$next;
							break;
							}

						if($i == $n_subp-1 && Profile::in_array_norm($curr,$suffices)) {
							$out['suffix']		=	$curr;
							continue;
							}

						if($out['middle']) {
							$out['middle']		.=	" $curr";
							}
						else {
							$out['middle']		=	$curr;
							}
						}
						$out['last']	=	$pieces[0];
						break;
					}
			unset($pieces);
			break;
		case	3:	// array(last,title first middles,suffix)
			$subp	=	explode(' ',trim($pieces[1]));
			$n_subp	=	count($subp);
			for($i = 0; $i < $n_subp; $i++) {
				$curr				=	trim($subp[$i]);
				$next				=	trim($subp[$i+1]);
				if($i == 0 && Profile::in_array_norm($curr,$titles)) {
					$out['title']	=	$curr;
					continue;
					}

				if(!$out['first']) {
					$out['first']	=	$curr;
					continue;
					}

				if($out['middle']) {
					$out['middle']		.=	" $curr";
					}
				else {
					$out['middle']		=	$curr;
					}
				}

			$out['last']				=	trim($pieces[0]);
			$out['suffix']				=	trim($pieces[2]);
			break;
		default:	// unparseable
			unset($pieces);
			break;
		}

	return $out;
	}

}
