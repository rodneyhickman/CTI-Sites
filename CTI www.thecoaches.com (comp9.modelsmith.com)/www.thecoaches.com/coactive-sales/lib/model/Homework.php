<?php

class Homework extends BaseHomework
{

  public function getWeekStartingFormatted(){
    $formatted = date('M d, Y', strtotime($this->getWeekStarting()) );
    return $formatted;
  }

  public function getProgramGoal(){
    return $this->getExtra1();
  }

  public function setProgramGoal( $v ){
    if( $v != $this->getExtra1() ){
      $this->setExtra1($v);
    }
    return;
  }

  public function getTotalClients(){
    return $this->getExtra2();
  }

  public function setTotalClients( $v ){
    if( $v != $this->getExtra2() ){
      $this->setExtra2($v);
    }
    return;
  }

}
