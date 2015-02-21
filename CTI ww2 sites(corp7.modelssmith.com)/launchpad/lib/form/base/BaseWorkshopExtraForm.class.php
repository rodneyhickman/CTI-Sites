<?php

/**
 * WorkshopExtra form base class.
 *
 * @method WorkshopExtra getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWorkshopExtraForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'workshop_id'        => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'workshop_attribute' => new sfWidgetFormInputText(),
      'workshop_value'     => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'workshop_id'        => new sfValidatorPropelChoice(array('model' => 'Workshop', 'column' => 'id', 'required' => false)),
      'workshop_attribute' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'workshop_value'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workshop_extra[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkshopExtra';
  }


}
