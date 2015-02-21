<?php

class myUser extends sfGuardSecurityUser
{
 public function getProfile()
 {
   // get profile, or create one if undefined
   $c = new Criteria();
   $c->add(ProfilePeer::SF_GUARD_USER_ID, $this->getGuardUser()->getId() );
   $profile = ProfilePeer::doSelectOne( $c );

   if(! isset($profile)){
     return null;
     // $profile = new Profile();
     // $profile->setEmail( $this->getGuardUser()->getUsername() );
     // $profile->setSfGuardUserId( $this->getGuardUser()->getId() );
     // $profile->save();
   }

   return $profile;
 } 


}
