<?php

class FlexformElements 
{

 

  function __construct() {
  }

  public function getHtml( $question ){  // can be FlexformAnswer or FlexformQuestion
    $content = '';
    if(method_exists($question, 'getContent')){
      $content = $question->getContent();
    }

    $type = $question->getType();
    switch($type){
    case 'section':
      return $this->section( $question );

    case 'header':
      return $this->header( $question, $content );

    case 'group':
      return $this->group( $question, $content );

    case 'text':
      return $this->textInput( $question, $content );

    case 'textarea':
      return $this->textArea( $question, $content );

      
    }
    return '';
  }

  public function section( $question ){
    if(preg_match('/^null/i',$question->getLabel())){
      return '';
    }
    $html = '<div class="section">'.$question->getLabel().'</div>'."\n";
    return $html;
  }

  public function header( $question, $content ){

  }

  public function group( $question, $content ){

  }

  public function textInput( $question, $content ){

  }

  public function textArea( $question, $content ){

  }

}
