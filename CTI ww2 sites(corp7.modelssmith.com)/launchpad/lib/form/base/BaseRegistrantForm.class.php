<?php

/**
 * Registrant form base class.
 *
 * @method Registrant getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRegistrantForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'first_name'                   => new sfWidgetFormInputText(),
      'middle_name'                  => new sfWidgetFormInputText(),
      'last_name'                    => new sfWidgetFormInputText(),
      'address_line1'                => new sfWidgetFormInputText(),
      'address_line2'                => new sfWidgetFormInputText(),
      'city'                         => new sfWidgetFormInputText(),
      'state'                        => new sfWidgetFormInputText(),
      'zip'                          => new sfWidgetFormInputText(),
      'country'                      => new sfWidgetFormInputText(),
      'phone'                        => new sfWidgetFormInputText(),
      'email'                        => new sfWidgetFormInputText(),
      'workshop_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'conf_email_sent_to_client_at' => new sfWidgetFormDateTime(),
      'cookie_name'                  => new sfWidgetFormInputText(),
      'cookie_value'                 => new sfWidgetFormInputText(),
      'created_at'                   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'first_name'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'middle_name'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'address_line1'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address_line2'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'city'                         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'state'                        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'zip'                          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'country'                      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'phone'                        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'email'                        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'workshop_id'                  => new sfValidatorPropelChoice(array('model' => 'Workshop', 'column' => 'id', 'required' => false)),
      'conf_email_sent_to_client_at' => new sfValidatorDateTime(array('required' => false)),
      'cookie_name'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cookie_value'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'                   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registrant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registrant';
  }


}
