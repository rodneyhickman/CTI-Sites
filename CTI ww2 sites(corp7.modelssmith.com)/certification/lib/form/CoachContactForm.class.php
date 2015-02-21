<?php

/**
 * CoachContact form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class CoachContactForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'message'              => new sfWidgetFormTextarea(),
    ));

    //    $this->setValidators(array(
    //      'name'    => new sfValidatorString(array('required' => false)),
    //      'email'   => new sfValidatorEmail(),
    //      'subject' => new sfValidatorChoice(array('choices' => array_keys(self::$subjects))),
    //      'message' => new sfValidatorString(array('min_length' => 4)),
    //    ));


    $this->widgetSchema->setLabels(array(
      'message' => 'Message:',
    ));
  }
}
