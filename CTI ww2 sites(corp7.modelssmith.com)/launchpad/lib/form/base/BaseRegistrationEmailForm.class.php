<?php

/**
 * RegistrationEmail form base class.
 *
 * @method RegistrationEmail getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRegistrationEmailForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'workshop_id'             => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'registration_email_type' => new sfWidgetFormInputText(),
      'text'                    => new sfWidgetFormTextarea(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'workshop_id'             => new sfValidatorPropelChoice(array('model' => 'Workshop', 'column' => 'id', 'required' => false)),
      'registration_email_type' => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'text'                    => new sfValidatorString(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registration_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrationEmail';
  }


}
