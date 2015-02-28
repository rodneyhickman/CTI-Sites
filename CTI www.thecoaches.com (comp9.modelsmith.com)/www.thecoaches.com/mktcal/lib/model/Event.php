<?php

class Event extends BaseEvent
{

  public function getLocationName( ) {
    return $this->getExtra1();
  }

  public function setLocationName( $v ){
    if($v !== $this->getExtra1() ){
      $this->setExtra1( $v );
    }
    return;
  }

  public function getDate() {
      return $this->getStartDate('Y-m-d');
  }
  
  public function setDate($v) {
      $this->setStartDate($v);
  }
  
  public function getTime() {
      return $this->getExtra2();
  }
  
  public function setTime($v) {
    if($v !== $this->getExtra2()){
      $this->setExtra2($v);
    }
    return;
  }
  
  public function getUpdatedBy() {
      return $this->getExtra3();
  }
  
  public function setUpdatedBy($v) {
    if($v !== $this->getExtra3()){
      $this->setExtra3($v);
    }
    return;
  }

  public function getFullDetails( ) {
    //$location_name = preg_replace('/[:^ascii:]/','',$this->getLocationName() );
    $location_name = iconv('UTF-8', 'ASCII//TRANSLIT', $this->getLocationName()  );
	/* Start Ticket 720 - Leader name shown in mkt cal */
	if($this->getLeaderName())
	{
		$leadername=$this->getLeaderName();
		$leadername= ', </br> <b>Leader:</b> '.$leadername.'</br>';
	}
	/* End Ticket 720 - Leader name shown in mkt cal */
	 
    $details = $this->getName().' '.$this->getStartDate('n/d/y').', '.$location_name.$leadername;
    return $details;
  }

  public function getNameLocation( ){
    $name_loc = $this->getName( ).'<br />'.$this->getLocation();
    $name_loc = iconv('UTF-8', 'ASCII//TRANSLIT', $name_loc);
    return $name_loc;
  }

}
