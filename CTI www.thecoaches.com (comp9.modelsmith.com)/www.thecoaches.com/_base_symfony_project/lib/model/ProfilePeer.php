<?php

class ProfilePeer extends BaseProfilePeer
{

  public static function newProfile( $email ){
    $profile = new Profile();
    $profile->setEmail( $email );
    $profile->save();

    return $profile;
  }

  public static function retrieveByEmail( $email ){
    $c = new Criteria();
    $c->add( ProfilePeer::EMAIL, $email );
    $profile = ProfilePeer::doSelectOne( $c );
    return $profile;
  }


  public static function retrieveByKey( $key ){
    $c = new Criteria();
    //$c->add(ProfilePeer::RESET_KEY, $key);
    $c->add(ProfilePeer::EXTRA2, $key);
    $profile = ProfilePeer::doSelectOne( $c );
   
    return $profile;
  }

  public static function login( $email, $password ){
    $result = array( 'profile' => null, 'status' => 'failed', 'return_code'=>'', 'url' => '', 'email' => $email );
 
    // untaint email
    $email = preg_replace("/[^a-zA-Z0-9\.\-\_\@]/",'',$email);

    // URL encode email and password
    $email    = urlencode( $email );
    $password = urlencode( $password );

    // curl to webcomp (timeout 10 secs)
    $ch = curl_init();

    $baseurl  = sfConfig::get('app_webcomp_baseurl');
    $postkey  = sfConfig::get('app_webcomp_postkey');
    $endpoint = sfConfig::get('app_webcomp_authen');

    $url = $baseurl.'/'.$endpoint.'?postkey='.$postkey.'&em='.$email.'&pw='.$password;

    $result['url'] = $url;

    //set the url
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // timeout after 10 seconds

    //execute post
    $json     = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    if($httpCode == 200){
      // $result is JSON
      // if result = ok, then update transaction status in org record 
      $result['return_code'] = json_decode( $json );
      if(isset($result['return_code']) && $result['return_code'] == 'ok'){
        // find profile in database and authenticate. If not in database, add profile

        //$msg = 'ok';
        $result['status'] = 'ok';

      }
      else {
        //$msg = 'failed';
      }
    }
    
    //close connection
    curl_close($ch);
    

    // if timeout
    //   if local available
    //     if match, return profile
    //   return "try again later"

    // if ok
    //   if local does not exist
    //     new Profile
    //   return profile
    return $result;
  }


}
