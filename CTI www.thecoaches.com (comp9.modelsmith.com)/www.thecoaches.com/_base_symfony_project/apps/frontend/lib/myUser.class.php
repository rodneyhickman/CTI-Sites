<?php

class myUser extends sfBasicSecurityUser
{
  // see http://www.symfony-project.org/cookbook/1_2/en/cookie for remember_me code

  public function signIn()
  {
    $this->setAuthenticated(true);
  }
 
  public function signOut()
  {
    $this->setAuthenticated(false);
  }

  public function setProfile( $profile ){
    if(isset($profile)){
      $this->setAttribute('profile_id', $profile->getId() );
    }
  }

  public function getProfile( ){
    $profile_id = $this->getAttribute('profile_id', 0);
    $profile = ProfilePeer::retrieveByPk( $profile_id );

    return $profile;
  }

}
