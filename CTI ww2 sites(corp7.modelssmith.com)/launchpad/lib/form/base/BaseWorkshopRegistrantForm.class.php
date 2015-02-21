<?php

/**
 * WorkshopRegistrant form base class.
 *
 * @method WorkshopRegistrant getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWorkshopRegistrantForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'registrant_id' => new sfWidgetFormPropelChoice(array('model' => 'Registrant', 'add_empty' => true)),
      'workshop_id'   => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'id'            => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'registrant_id' => new sfValidatorPropelChoice(array('model' => 'Registrant', 'column' => 'id', 'required' => false)),
      'workshop_id'   => new sfValidatorPropelChoice(array('model' => 'Workshop', 'column' => 'id', 'required' => false)),
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workshop_registrant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkshopRegistrant';
  }


}
