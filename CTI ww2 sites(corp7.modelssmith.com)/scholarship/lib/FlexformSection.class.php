<?php

class FlexformSection 
{

  // first and last flexform_answer

  protected $first = null;
  protected $last  = null;

  function __construct() {
  }

  public function getFirst(){
    return $this->first;
  }

  public function getLast(){
    return $this->last;
  }

  public function setFirst( $v ){
    $this->first = $v;
    return $this;
  }

  public function setLast( $v ){
    $this->last = $v;
    return $this;
  }


}
