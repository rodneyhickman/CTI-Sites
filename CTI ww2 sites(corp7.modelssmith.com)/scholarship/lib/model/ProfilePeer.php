<?php

require 'lib/model/om/BaseProfilePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'profile' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Mar  7 23:14:52 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ProfilePeer extends BaseProfilePeer {

  public static function GetProfileFromEmail( $email ){
    if($email == ''){
       return null;
    }
    $c = new Criteria();
    $c->add(ProfilePeer::EMAIL1, $email);
    $profile = ProfilePeer::doSelectOne( $c );
    if(!isset($profile)){ // create this user
      $profile = new Profile();
      $profile->setEmail1( $email );
      $profile->save();
    }
    return $profile;
  }

  public static function retrieveByEmail( $email ){
    if($email == ''){
       return null;
    }
    $c = new Criteria();
    $c->add(ProfilePeer::EMAIL1, $email);
    $profile = ProfilePeer::doSelectOne( $c );
    return $profile;
  }

 

  public static function retrieveByKey( $key ){
    $c = new Criteria();
    $c->add(ProfilePeer::SECRET, $key);
    $profile = ProfilePeer::doSelectOne( $c );
    return $profile;
  }

  public static function RequestNewPassword( $email, $module = 'executivecoach' ){

    $email = preg_replace("/[^A-Za-z0-9\.\-\_\@]/","",$email); // untaint

    // check whether email address exists in database
    // curl to webcomp (timeout 10 secs)
    $ch = curl_init();

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey');
    $endpoint = sfConfig::get('app_webcomp_recordexists');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$email;

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

    //execute post
    $response = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    if($httpCode == 200){
      // $result is JSON
      // if result = ok, then update transaction status in org record 
      
      if(preg_match('/ok/i',$response)){
        $profile = ProfilePeer::GetProfileFromEmail( $email );

        // send email with resetkey
        $resetKey = $profile->newResetKey();
        $subject = 'CTI Password Reset Request';
        $url = 'http://ww2.thecoaches.com' . sfContext::getInstance()->getController()->genUrl($module.'/newPassword?k='.$resetKey);
        $message = <<<EOM
We have received your request for a password reset. Please click the
following link to continue. If you did not make this request, please
disregard and delete this email.

$url

The Coaches Training Institute
1-800-691-6008
EOM;
        // send email here
     
   
        $to       = $email;
        $headers  = "From: webserver@thecoaches.com\r\n";

        // Send email
        $sent = mail($to, $subject, $message, $headers) ;

        $msg = 'Your request has been sent. Please check your email. It may take several minutes for your email to arrive';

      }
      else {
        $msg = 'Your email is not on file. Please contact Customer Service at 1-800-691-6008.';
      }
    }
    else {
      // try local database here?
      $msg = 'Your email is not on file. Please contact Customer Service at 1-800-691-6008.';
    }

    return $msg;
  }


  public static function AllLeaderSelectionApplicants( ) {
    $c = new Criteria();

    $c->addJoin(ProfilePeer::ID,LeadersPeer::PROFILE_ID);
    $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function AllLeadershipApplicants( $days = 0, $count = 0 ) {
    $c = new Criteria();

    $c->addJoin(ProfilePeer::ID,LeadershipPeer::PROFILE_ID);
    $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    if($days > 0 && $days < 1000){
      $c->addDescendingOrderByColumn(ProfilePeer::UPDATED_AT);
      $c->add(LeadershipPeer::UPDATED_AT, date('Y-m-d',strtotime('-'.$days.' day')), Criteria::GREATER_THAN);
    }
    else if($count > 0){
      $c->addDescendingOrderByColumn(ProfilePeer::UPDATED_AT);
      $c->setLimit( $count );
    }
    else {
      $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    }

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function SearchLeadershipApplicants( $q ) {
    $c = new Criteria();

    $cton3 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%$q%", Criteria::LIKE);
    $cton4 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%$q%", Criteria::LIKE);
    // combine them
    $cton3->addOr($cton4);
    $c->add($cton3);

    
    $c->addJoin(ProfilePeer::ID,LeadershipPeer::PROFILE_ID);
    $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }


  public static function AllCoachTrainingApplicants( $days = 0, $count = 0 ) {
    $c = new Criteria();

    $c->addJoin(ProfilePeer::ID,CoachtrainingPeer::PROFILE_ID);
    if($days > 0 && $days < 1000){
      $c->addDescendingOrderByColumn(ProfilePeer::UPDATED_AT);
      $c->add(CoachtrainingPeer::UPDATED_AT, date('Y-m-d',strtotime('-'.$days.' day')), Criteria::GREATER_THAN);
    }
    else if($count > 0){
      $c->addDescendingOrderByColumn(ProfilePeer::UPDATED_AT);
      $c->setLimit( $count );
    }
    else {
      $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    }

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function SearchCoachTrainingApplicants( $q ) {
    $c = new Criteria();

    $cton3 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%$q%", Criteria::LIKE);
    $cton4 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%$q%", Criteria::LIKE);
    // combine them
    $cton3->addOr($cton4);
    $c->add($cton3);

    
    $c->addJoin(ProfilePeer::ID,CoachtrainingPeer::PROFILE_ID);
    $c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }


  public static function AllExecutiveApplicants( $days = 0, $count = 0  ) {
    $c = new Criteria();

    $cton3 = $c->getNewCriterion(ExeccoachPeer::EXTRA4,'no');
    $cton4 = $c->getNewCriterion(ExeccoachPeer::EXTRA4, null, Criteria::ISNULL);
    $cton3->addOr($cton4);
    $c->add($cton3);
    if($days > 0 && $days < 1000){
      $c->add(ExeccoachPeer::UPDATED_AT, date('Y-m-d',strtotime('-'.$days.' day')), Criteria::GREATER_THAN);
    }
    else if($count > 0){
      $c->setLimit( $count );
    }

    $c->addJoin(ProfilePeer::ID,ExeccoachPeer::PROFILE_ID);
    $c->add(ProfilePeer::FIRST_NAME, null, Criteria::ISNOTNULL);
    //$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    $c->addDescendingOrderByColumn(ExeccoachPeer::UPDATED_AT);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function SearchExecutiveApplicants( $q ) {
    $c = new Criteria();

    $cton3 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%$q%", Criteria::LIKE);
    $cton4 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%$q%", Criteria::LIKE);
    // combine them
    $cton3->addOr($cton4);
    $c->add($cton3);

    
    $c->addJoin(ProfilePeer::ID,ExeccoachPeer::PROFILE_ID);
    //$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    $c->addDescendingOrderByColumn(ExeccoachPeer::UPDATED_AT);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }


  public static function AllFacultyApplicants( $days = 0, $count = 0 ) {
    $c = new Criteria();

    $c->addJoin(ProfilePeer::ID,ExeccoachPeer::PROFILE_ID);
    $c->add(ExeccoachPeer::EXTRA4,'yes');
    if($days > 0 && $days < 1000){
      $c->add(ExeccoachPeer::UPDATED_AT, date('Y-m-d',strtotime('-'.$days.' day')), Criteria::GREATER_THAN);
    }
    else if($count > 0){
      $c->setLimit( $count );
    }

    $c->add(ProfilePeer::FIRST_NAME, null, Criteria::ISNOTNULL);
    //$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    $c->addDescendingOrderByColumn(ExeccoachPeer::UPDATED_AT);


    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function SearchFacultyApplicants( $q ) {
    $c = new Criteria();

    $cton3 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%$q%", Criteria::LIKE);
    $cton4 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%$q%", Criteria::LIKE);
    // combine them
    $cton3->addOr($cton4);
    $c->add($cton3);

    
    $c->addJoin(ProfilePeer::ID,ExeccoachPeer::PROFILE_ID);
    $c->add(ExeccoachPeer::EXTRA4,'yes');
    //$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    $c->addDescendingOrderByColumn(ExeccoachPeer::UPDATED_AT);


    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }


  // ============= FORL application =============


 public static function AllForlApplicants( $days = 0, $count = 0  ) {
    $c = new Criteria();

    if($days > 0 && $days < 1000){
      $c->add(FlexformSubmissionPeer::SUBMIT_DATE, date('Y-m-d',strtotime('-'.$days.' day')), Criteria::GREATER_THAN);
    }
    else if($count > 0){
      $c->setLimit( $count );
    }

    $c->add(FlexformSubmissionPeer::EXTRA1, 'FORL' ); 
    $c->add(ProfilePeer::FIRST_NAME, null, Criteria::ISNOTNULL);
    $c->addJoin(ProfilePeer::ID,FlexformSubmissionPeer::PROFILE_ID);
    $c->addDescendingOrderByColumn(FlexformSubmissionPeer::SUBMIT_DATE);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }

  public static function SearchForlApplicants( $q ) {
    $c = new Criteria();


    $cton3 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%$q%", Criteria::LIKE);
    $cton4 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%$q%", Criteria::LIKE);
    // combine them
    $cton3->addOr($cton4);
    $c->add($cton3);


    $c->add(FlexformSubmissionPeer::EXTRA1, 'FORL' );     
    $c->addJoin(ProfilePeer::ID,FlexformSubmissionPeer::PROFILE_ID);
    //$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
    $c->addDescendingOrderByColumn(FlexformSubmissionPeer::UPDATED_AT);

    $profiles = ProfilePeer::doSelect( $c );
    return $profiles;
  }





  public static function FilemakerLogin( $email, $password ){

    $result = array( 
      'profile' => null, 
      'status' => 'failed', 
      'return_code'=>'', 
      'url' => '', 
      'email' => $email );
 
    // untaint email
    $email = preg_replace("/[^a-zA-Z0-9\.\-\_\@]/",'',$email);

    // URL encode email and password
    $email    = urlencode( $email );
    $password = urlencode( $password );

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey');
    $endpoint = sfConfig::get('app_webcomp_authen');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$email.'&pw='.$password;

    $result['url'] = $url;

    //execute post
    $json     = file_get_contents($url);  

    $result['return_code'] = json_decode( $json );
    if(isset($result['return_code']) && $result['return_code'] == 'ok'){
      $result['status'] = 'ok';
    }
    else {
      //$msg = 'failed';
    }
    
    return $result;
  }


} // ProfilePeer