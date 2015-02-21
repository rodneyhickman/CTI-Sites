<?php

/**
 * ChangePassword form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */


class ChangePasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
                            'password' => new sfWidgetFormInputPassword(),
                            'verify'   => new sfWidgetFormInputPassword(),
    ));


    $this->widgetSchema->setLabels(array(
      'password' => 'Password',
      'verify'   => 'Confirm Password',
    ));

    $this->widgetSchema->setNameFormat('register[%s]');
 
    $this->setValidators(array(
      'password' => new sfValidatorString(array('required' => true)),
      'verify'   => new sfValidatorString(array('required' => true)),
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', '==', 'verify'));



  }
}
