<?php
@require_once "Mail.php";

class Profile extends BaseProfile
{

  // ======= Data for this profile =======

  public function getCurrentHomework(){ // current week's homework
    $homework = HomeworkPeer::retrieveCurrentByProfile( $this->getId() );
    return $homework;
  }
  public function getMyAudios(){
    $c = new Criteria();
    $audios = AudioPeer::doSelect( $c );
    return $audios;
  }

  public function getMyDocuments(){
    $c = new Criteria();
    $docs = DocumentPeer::doSelect( $c );
    return $docs;
  }

  public function getMyHomeworks(){
    $c = new Criteria();
    $c->add(HomeworkPeer::PROFILE_ID, $this->getId());
    $c->addAscendingOrderByColumn(HomeworkPeer::WEEK_STARTING);
    $homeworks = HomeworkPeer::doSelect( $c );
    
    return $homeworks;
  }

    // ======= Roles and new fields =======

  public function isAdmin(){
    if($this->getRole() == 'admin'){
      return true;
    }
    return false;
  }

  public function getRole(){
    return $this->getExtra1();
  }

  public function setRole( $v ){
    if($this->getExtra1() != $v){
      $this->setExtra1( $v );
    } 
  }


  // T. Beutel added 12/26/12
  public function isRegistered(){
    // check to see if homework started
    $c = new Criteria();
    $c->add(HomeworkPeer::PROFILE_ID, $this->getId());
    $homework = HomeworkPeer::doSelectOne( $c );

    if($homework){
      return true;
    }
    return false;
  }


  public function newResetKey( ){ // key for matching to reset password or email address change
    $this->setResetKey( commonTools::randomKey( ) );
    $this->save();
    return $this->getResetKey();
  }


  public function getResetKey(){
    return $this->getExtra2();
  }

  public function setResetKey( $v ){
    if($this->getExtra2() != $v){
      $this->setExtra2( $v );
    } 
  }


  public function resetKeyMatches( $key ){
    if( $this->getResetKey() != '' && $key == $this->getResetKey() ){
      $this->setResetKey(''); // key is only allowed to be used once, so erase it
      $this->save();
      return true;
    }
    else {
      return false;
    }
  }

  public function getProgramGoal(){
    return $this->getExtra3();
  }

  public function setProgramGoal( $v ){
    if( $v != $this->getExtra3() ){
      $this->setExtra3($v);
    }
    return;
  }

  public function getShortBio(){
    return $this->getExtra4();
  }

  public function setShortBio( $v ){
    if( $v != $this->getExtra4() ){
      $this->setExtra4($v);
    }
    return;
  }

  public function getPhoto(){
    return $this->getExtra5();
  }

  public function setPhoto( $v ){
    if( $v != $this->getExtra5() ){
      $this->setExtra5($v);
    }
    return;
  }

  public function getAgreedToTerms(){
    return $this->getExtra6();
  }

  public function setAgreedToTerms( $v ){
    if( $v != $this->getExtra6() ){
      $this->setExtra6($v);
    }
    return;
  }

  public function setNewPassword( $password ){

    // URL encode password
    $password = urlencode( $password );

    // curl to webcomp (timeout 10 secs)
    $ch = curl_init();

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey2');
    $endpoint = sfConfig::get('app_webcomp_newpw');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$this->getEmail().'&pw='.$password;

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

    //execute post
    $result     = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    if($httpCode == 200){
      // $result is JSON
      // if result = ok, then update transaction status in org record 
     
      if($result == 'ok'){
        // transaction status = "complete"
        //$msg = 'ok';
        $this->newCommlogEntry("Changed password via Co-active Sales");
      }
      else {
        //$msg = 'failed';
      }
    }
    
    //close connection
    curl_close($ch);

  }


  // ======= MAIL =======

  public function sendPortalEmail( $subject, $message, $from = 'registration@thecoaches.com', $to = '' ){
    // PLEASE NOTE the '@' signs. These are used here to suppress warnings due to PEAR not being up to date for strictness


    // Format results for email
    if($to == ''){
      $to = $this->getEmail();
    }

    // Send email
    //$sent = mail($to, $subject, $message, $headers) ;

    $host = "smtp2.modelsmith.com";
    $port = "2225";
    $username = "msmithclient";
    $password = "3eDSw2";

    $headers = array ('From' => $from,
                      'To' => $to,
                      'Subject' => $subject);
    $smtp = @Mail::factory('smtp',
                          array ('host' => $host,
                                 'port' => $port,
                                 'auth' => true,
                                 'username' => $username,
                                 'password' => $password));

    $mail = @$smtp->send($to, $headers, $message);

    // if (PEAR::isError($mail)) {
    //   echo("<p>" . $mail->getMessage() . "</p>");
    // } else {
    //   echo("<p>Message successfully sent!</p>");
    // }


    $this->newCommlogEntry( "Email with subject '$subject' was sent from Student Portal" );
  }

  // ======= COMMLOG =======

  public function newCommlogEntry( $message ){

    // URL encode message
    $message = urlencode( $message." at ".date("H:i:s")." ET" );

    // curl to webcomp (timeout 10 secs)
    $ch = curl_init();

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey');
    $endpoint = sfConfig::get('app_webcomp_commlog');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$this->getEmail().'&m='.$message;

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

    //execute post
    $json     = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    if($httpCode == 200){
      // $result is JSON
      // if result = ok, then update transaction status in org record 
      $result = json_decode( $json );
      if(isset($result->{'result'}) && $result->{'result'} == 'ok'){
        // transaction status = "complete"
        //$msg = 'ok';
      }
      else {
        //$msg = 'failed';
      }
    }
    
    //close connection
    curl_close($ch);


  }


}