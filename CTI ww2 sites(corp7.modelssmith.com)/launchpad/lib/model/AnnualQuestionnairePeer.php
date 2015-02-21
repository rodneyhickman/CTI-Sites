<?php

require 'lib/model/om/BaseAnnualQuestionnairePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'annual_questionnaire' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Fri Nov 11 20:47:00 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class AnnualQuestionnairePeer extends BaseAnnualQuestionnairePeer {

  public static function futureTribes(){
    $tribes = array(
      '-- Please select a date --',
  
     
'March 3, 2015 North Carolina',
'March 3, 2015 Northern California',
'March 22, 2015 Spain',
'May 3, 2015 Spain',
'May 19, 2015 Northern California',
'September 13, 2015 Spain',
'September 15, 2015 Northern California',
'September 29, 2015 North Carolina',
'November 8, 2015 Spain',
'November 17, 2015 Northern California',
      'Future Year Interest'
    );

    return $tribes;
  }

  public static function iAmTypes() {
    $iam_types = array(
      '-- Please select an I AM Type --',
      'Charm',
      'Sex',
      'Beauty',
      'Humor',
      'Danger',
      'Eccentric',
      'Intelligence'
      );

    return $iam_types;
  }


} // AnnualQuestionnairePeer
