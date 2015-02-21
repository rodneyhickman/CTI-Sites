<?php





class myUser extends sfGuardSecurityUser
{

 protected $homePreference = 'leadership';
 protected $referer = 'admin/leadership';

 public function getProfileId()
 {
   $profile_id = $this->getAttribute('profile_id', 0);

   // if profile is unknown, create brand new profile
   if($profile_id < 1){
     $profile = new Profile();
     $profile->save();
     $profile_id = $profile->getId();
     $this->setAttribute('profile_id',$profile_id);
   } 

   return $profile_id;
 }

 public function getProfileIdFromEmail()
 {
   $profile_id = $this->getAttribute('profile_id', 0);
   $email      = $this->getAttribute('email','');
   
   if($email != ''){
     $c = new Criteria();
     $c->add(ProfilePeer::EMAIL1, $email);
     $profile = ProfilePeer::doSelectOne( $c );
     if(isset($profile)){
       $this->setAttribute('profile_id',$profile->getId());
       return $profile->getId();
     }
   }

   if($profile_id > 0){
     // check to make sure profile_id is valid
     $c = new Criteria();
     $c->add(ProfilePeer::ID, $profile_id);
     $profile = ProfilePeer::doSelectOne( $c );
     if(isset($profile)){
       return $profile_id;
     }
   }

   // profile is unknown, so create brand new profile
   $profile = new Profile();
   $profile->setEmail1( $email );
   $profile->save();
   $profile_id = $profile->getId();
   $this->setAttribute('profile_id',$profile_id);
   $this->setAttribute('email',$email);
   
   return $profile_id;
 }

 public function getTestString()
 {
   return "Hello World from myUser!";
 }

 public function setHomePreference( $pref ){
   $this->homePreference = $pref;
 }

 public function getHomePreference(){
   return $this->homePreference;
 }

 public function setReferer_( $pref ){
   $this->referer = $pref;
 }

 public function getReferer_(){
   return $this->referer;
 }
}
