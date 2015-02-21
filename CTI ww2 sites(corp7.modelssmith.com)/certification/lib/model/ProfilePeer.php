<?php

class ProfilePeer extends BaseProfilePeer
{

  public static function clientLoadPager( $page ) {

    // select *,count(profile.id) from profile,activity 
    // where activity.coach_id=profile.id AND activity.decription='added_client' group by profile.id;

    // Note: This pager emits stdClass objects, not Propel objects. This means that instead of $p->getName(), use $p['name']
    //
    // Example object from this pager:
    // 
//    stdClass Object
//     (
//     [id] => 37
//     [name] => Meisha Rouser
//     [email] => meisha@watermarknw.com
//     [location] => Seattle, WA
//     [niche] => I am very passionate about coaching and especially co-active coaching.  I feel our world is in need of more coaches right now.  My niche is working with individuals going through change and/or growth.  In addition I find that the majority of my clients right now are independent business owners.  My strong background in sales, marketing as an entrepreneur tends to attract other entrepreneurs.  I look forward to the opportunity of mentoring and coaching you as you navigate through this experience.   Its a wonderful ride.

// For more information visit my website at http://www.BeyondLeft.com
//     [expertise] => The majority of my career has had some type of focus around mentoring, teaching and coaching.  I have worked for large corporations, start-up companies and have created many of my own businesses.  My focus now is mainly my coaching practice.  You can learn more about who I am and my background by visiting http://www.BeyondLeft.com
//     [sf_guard_user_id] => 64
//     [agree_clicked] => 2009-08-25 05:08:59
//     [number_of_contacts_made] => 0
//     [phone] => 
//     [created_at] => 2009-10-09 10:07:06
//     [updated_at] => 2009-10-09 10:07:06
//     [client_id] => 150
//     [coach_id] => 65
//     [activity_date] => 2009-10-09 10:07:06
//     [decription] => added_client
//     [count(profile.id)] => 5
//     )
   
    $connection = Propel::getConnection();
    $query = "select *,count(profile.id) as num_clients from profile,activity where activity.coach_id=profile.id AND activity.decription='added_client' group by profile.id order by num_clients desc";

    $statement = $connection->prepare($query);

    $pager = new statementPager(null, 10);
    $pager->setStatement($statement);
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

  

  public static function addNewProfile($name,$email,$password,$student){

    // throw exception if not a cert student or not a coach
    if( ! $student->isEligibleForProgram() ){
      throw new Exception('Not eligible for Certification Coach Match Program');
    }

    // if sfGuardUser exists, check for profile
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, $email);
    $user = sfGuardUserPeer::doSelectOne( $c );
    if(isset($user)){
      $c = new Criteria();
      $c->add(ProfilePeer::EMAIL, $email);
      $profile = ProfilePeer::doSelectOne( $c );
      if(isset($profile)){
        throw new Exception('Profile exists');
      }
    }
    else {
      // create new sfGuardUser
      $user = new sfGuardUser();
      $user->setUsername( $email );
    }            
    $user->setPassword( $password );
    $user->save();               



    // add profile
    $profile = new Profile();
    $profile->setName( $name );
    $profile->setEmail( $email );
    $profile->setSfGuardUserId( $user->getId() );
    $profile->setAgreeClicked( null );
    $profile->setNumberOfContactsMade( 0 );
    $profile->save();
    
    // save profile id in student
    $student->setProfileId($profile->getId());
    $student->save();

    // decide whether user is client or coach
    if($student->isFacultyCoach()){
      $profile->setCredentialGroup('coaches');
      $profile->setAvailability(1);
      $profile->setCoachType('faculty');
    }
    else if($student->isCpccCoach()){
      $profile->setCredentialGroup('coaches');
      $profile->setAvailability(1);
      $profile->setCoachType('cpcc');
    }
    else {
      $profile->setCredentialGroup('clients');
    }

    // get country from FileMaker
    $response = implode('', file('http://webcomp.modelsmith.com/fmi-test/webcomp/getcountry.php?postkey=fjgh15t&em='.$email));
    preg_match('/country: (.*)/',$response,$matches);
    $country = $matches[1];
    $profile->setCountry($country);

    //Country Group not used in cert coach match
    //$profile->determineAndSetCountryGroup();
    $profile->setCountryGroup( 0 );
    
    // Business rule: if student is in GB country group and has not yet taken Fulfillment, unregister
    //if($profile->getCountryGroup == 1 && $student->getLevel() < 2){
    //  ProfilePeer::RemoveProfile( $email );
    //  throw new Exception('UK Coach Match is open to students after they finish Fulfillment.');
    // }


    $profile->save();
    return $profile;
  }

  public static function RemoveProfile( $email )
  {
    $c = new Criteria();
    $c->add(ProfilePeer::EMAIL, $email );
    $profile = ProfilePeer::doSelectOne( $c );
    if(isset($profile)){
      $profile->delete();
    }
  }

  public static function UnregisterProfile( $email )
  {
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, $email );
    $user = sfGuardUserPeer::doSelectOne( $c );
    if(isset($user)){
      $user->delete();
    }

    $c = new Criteria();
    $c->add(ProfilePeer::EMAIL, $email );
    $profile = ProfilePeer::doSelectOne( $c );
    if(isset($profile)){
      $profile->delete();
    }
  }

  public static function SearchPager( $query, $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();

    if($query != ''){
      $c->add(ProfilePeer::NAME, '%'.$query.'%', Criteria::LIKE);
      // $c->add(ProfilePeer::NAME, $query, Criteria::LIKE);
    }
    else {
      $c->add(ProfilePeer::ID, 0, Criteria::GREATER_THAN);
    }
  
    $pager = new sfPropelPager( 'Profile', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }

  public static function AcceptPager( $query, $page )
  { // see: http://www.symfony-project.org/cookbook/1_2/en/pager

    $c = new Criteria();
    $c->addDescendingOrderByColumn(ProfilePeer::CREATED_AT);

    $pager = new sfPropelPager( 'Profile', sfConfig::get('app_pager_recs_max') );
    $pager->setCriteria( $c );
    $pager->setPage( $page );
    $pager->init();
    return $pager;
  }

}



