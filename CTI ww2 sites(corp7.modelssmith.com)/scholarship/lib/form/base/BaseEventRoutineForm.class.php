<?php

/**
 * EventRoutine form base class.
 *
 * @method EventRoutine getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEventRoutineForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'event_name'       => new sfWidgetFormInputText(),
      'action_routine'   => new sfWidgetFormInputText(),
      'next_day_to_run'  => new sfWidgetFormDate(),
      'next_time_to_run' => new sfWidgetFormTime(),
      'last_run'         => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'event_name'       => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'action_routine'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'next_day_to_run'  => new sfValidatorDate(array('required' => false)),
      'next_time_to_run' => new sfValidatorTime(array('required' => false)),
      'last_run'         => new sfValidatorDateTime(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('event_routine[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EventRoutine';
  }


}
