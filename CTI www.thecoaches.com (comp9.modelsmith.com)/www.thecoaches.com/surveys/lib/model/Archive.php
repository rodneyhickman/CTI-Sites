<?php

class Archive extends BaseArchive
{
  public function getRandomKey(){
    return $this->getExtra1();
  }

  public function setRandomKey( $v ){
    if($this->getExtra1() !== $v){
      $this->setExtra1( $v );
    }
  }

}
