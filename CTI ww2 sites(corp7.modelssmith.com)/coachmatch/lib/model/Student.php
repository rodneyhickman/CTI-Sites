<?php

class Student extends BaseStudent
{
  public function getFundamentalsDate() {
    $course = $this->getCourseFundamentals();
    preg_match('/(\d\d?\/\d\d?\/\d\d?\d?\d?)/',$course,$matches);
    if(isset($matches)){
      $date = $matches[1];
      return $date;
    }
    else {
      return '';
    }
  }

  public function getSynergyDate() {
    $course = $this->getCourseInTheBones();
    preg_match('/(\d\d?\/\d\d?\/\d\d?\d?\d?)/',$course,$matches);
    if(isset($matches[1])){
      $date = $matches[1];
      return $date;
    }
    else {
      return '';
    }
  }

  public function getCompletedBridgingContentDate() {
    return $this->getInTheBonesDate();  // student.in_the_bones_date now serves as bridging content date
  }
}
