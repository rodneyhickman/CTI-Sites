<?php

class FlexformReader 
{


  function __construct() {

  }


  // Typical format of text file: Label [type] <class>
  // Example:

  // Please submit your completed
  // application and resume by July 8, 2013 [header] <head1>
  //
  // Section A: Contact Info [section] <sectionhead>
  // 1. First Name [text]
  // 2. Last Name [text]
  // 3. Permanent Address [group]
  //    Address 1 [text]
  // ...

  // Notes: 
  // - Labels can span multiple lines
  // - Group is defined by [group] and following indented questions

  public static function importFromText( $text ){
    // read text file line by line
    $section            = null;
    $null_section_count = 0;
    $sections           = array( );
    $questions          = array( );
    $group              = null;

    $lines = preg_split("/(\r\n|\n|\r)/", $text);

    $compound_line = '';
    foreach($lines as $line){
      if(preg_match('/\w/',$line)){
        if($section == null){
          $null_section_count++;
          $section = array( 'label' => "null section $null_section_count", 'class' => '', 'type' => 'section' );
        }
        if(preg_match('/(.*?)\[(.*?)\]\s*(<.*>)?/',$line, $matches)){
          // a form type was given 
          $label = $matches[1];
          $is_indented = preg_match('/^\s+/',$label) ? 1 : 0;
          $label = $compound_line . $label;
          $type  = $matches[2];
          $class = '';
          if(isset($matches[3])){
            $class = $matches[3];
            $class = preg_replace('/[<>]/','',$class);
          }

          // finish current group if there is one          
          if($group != null && ($is_indented == 0 || $type == 'group' || $type == 'section')){
            $group['questions'] = $group_questions;
            $questions[] = $group;
            $group = null;
          }

          if($type == 'group'){ // Note: groups are NOT recursive
            $group = array( 'label' => $label, 'type' => 'group', 'class' => $class );
            $group_questions = array( );
          }
          else if($type == 'section'){
            // save previous section
            $section['questions'] = $questions;
            $sections[] = $section;

            // create new section
            $section   = array( 'label' => $label, 'class' => $class, 'type' => 'section' );
            $questions = array( );
          }
          else if($group != null && $is_indented == 1){
            $group_questions[] = array( 'label' => $label, 'type' => $type, 'class' => $class );
          }
          else {
            $questions[] = array( 'label' => $label, 'type' => $type, 'class' => $class );
          }

        }
        else {
          $compound_line .= $line . ' ';
        }
      }
      else {
        $compound_line = '';
      }
    }

    // finish current group if there is one          
    if($group != null){
      $group['questions'] = $group_questions;
      $questions[] = $group;
    }
    
    if(isset($section)){
      if(isset($questions)){
        $section['questions'] = $questions;
      }
      $sections[] = $section;
    }
    
    return $sections;
  }




} // end of class
