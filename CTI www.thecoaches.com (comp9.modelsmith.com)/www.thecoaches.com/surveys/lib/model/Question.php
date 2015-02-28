<?php

class Question extends BaseQuestion
{
  public function getDisplayArray(){

  }

  public function getQNumber(){
    return $this->getExtra1();
  }

  public function setQNumber($v){
    if($this->getExtra1() !== $v){
      $this->setExtra1($v);
    }
  }


}
