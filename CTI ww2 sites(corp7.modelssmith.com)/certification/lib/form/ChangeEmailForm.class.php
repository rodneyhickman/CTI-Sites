<?php

/**
 * ChangePassword form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class ChangeEmailForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'emailaddress' => new sfWidgetFormInputPassword(),
    ));


    $this->widgetSchema->setLabels(array(
      'emailaddress' => 'New Email Address',
    ));

    $this->widgetSchema->setNameFormat('register[%s]');
 
    $this->setValidators(array(
      'emailaddress' => new sfValidatorString(array('required' => true)),
    ));



  }
}
