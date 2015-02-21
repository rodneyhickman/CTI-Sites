<?php


/**
 * Register form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegisterForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
                            'name'     => new sfWidgetFormInput(),
                            'email'    => new sfWidgetFormInput(),
                            'password' => new sfWidgetFormInputPassword(),
                            'verify'   => new sfWidgetFormInputPassword(),
    ));

    $this->widgetSchema->setLabels(array(
      'name'     => 'Your Name',
      'email'    => 'Your Email Address',
      'password' => 'New Password',
      'verify'   => 'Confirm New Password',
    ));

    $this->widgetSchema->setNameFormat('register[%s]');
 
    $this->setValidators(array(
      'name'     => new sfValidatorString(array('required' => true)),
      'email'    => new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.','required'=>true)),
      'password' => new sfValidatorString(array('required' => true)),
      'verify'   => new sfValidatorString(array('required' => true)),

    ));

    $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', '==', 'verify'));
  }
}
