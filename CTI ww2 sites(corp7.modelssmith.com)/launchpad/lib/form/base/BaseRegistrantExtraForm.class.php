<?php

/**
 * RegistrantExtra form base class.
 *
 * @method RegistrantExtra getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRegistrantExtraForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'registrant_id' => new sfWidgetFormPropelChoice(array('model' => 'Registrant', 'add_empty' => true)),
      'field_name'    => new sfWidgetFormInputText(),
      'field_order'   => new sfWidgetFormInputText(),
      'field_data'    => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'registrant_id' => new sfValidatorPropelChoice(array('model' => 'Registrant', 'column' => 'id', 'required' => false)),
      'field_name'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'field_order'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'field_data'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registrant_extra[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrantExtra';
  }


}
