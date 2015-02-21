<?php

/**
 * Availability form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class AvailabilityForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'availability' => new sfWidgetFormChoice(array(
             'expanded' => true,
             'choices'  => array( 'I am not currently available', 'I am available to coach a CTI student'),
      ))  
    ));


    $this->widgetSchema->setLabels(array(
      'availability' => 'Indicate Your Availability',
    ));
  }
}
