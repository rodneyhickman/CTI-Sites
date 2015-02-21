<?php

// lib/form/BBContactForm.class.php
class BBContactForm extends BaseForm
{
  protected static $subjects = array('A' => 'Subject A', 'B' => 'Subject B', 'C' => 'Subject C');
  
  public function configure()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormInputText(),
      'email'   => new sfWidgetFormInputText(),
      'subject' => new sfWidgetFormSelect(array('choices' => self::$subjects)),
      'message' => new sfWidgetFormTextarea(),
    ));

    $this->widgetSchema->setNameFormat('contact[%s]');
    $this->setDefaults(array('email' => 'Your Email Here', 'name' => 'Your Name Here'));
    
    $this->setValidators(array(
 //     Before custom error messages
 //     'name'    => new sfValidatorString(array('required' => false)),
 //     'email'   => new sfValidatorEmail(),
 //     'subject' => new sfValidatorChoice(array('choices' => array_keys(self::$subjects))),
 //     'message' => new sfValidatorString(array('min_length' => 4)),
 //   before highly customize error message
 //    'name'    => new sfValidatorString(array('required' => false)),
      'name' => new sfValidatorAnd(array(
        new sfValidatorString(array('min_length' => 5)),
        new sfValidatorRegex(array('pattern' => '/[\w- ]+/')),
      )),
      'email'   => new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.')),
      'subject' => new sfValidatorChoice(array('choices' => array_keys(self::$subjects))),
//       Before highly customize error message
//      'message' => new sfValidatorString(array('min_length' => 4), array('required' => 'The message field is required.')),
      'message' => new sfValidatorString(array('min_length' => 4), array(
        'required'   => 'The message field is required',
        'min_length' => 'The message "%value%" is too short. It must be of %min_length% characters at least.',
      )),
    ));
  }
}
