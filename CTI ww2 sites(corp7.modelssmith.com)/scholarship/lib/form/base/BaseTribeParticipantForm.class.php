<?php

/**
 * TribeParticipant form base class.
 *
 * @method TribeParticipant getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTribeParticipantForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'profile_id' => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'tribe_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tribe', 'add_empty' => true)),
      'role'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id' => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'tribe_id'   => new sfValidatorPropelChoice(array('model' => 'Tribe', 'column' => 'id', 'required' => false)),
      'role'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tribe_participant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TribeParticipant';
  }


}
