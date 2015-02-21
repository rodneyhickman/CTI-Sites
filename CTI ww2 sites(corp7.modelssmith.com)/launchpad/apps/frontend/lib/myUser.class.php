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
