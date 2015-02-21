<?php

/**
 * TribeParticipant filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTribeParticipantFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'profile_id' => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'tribe_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tribe', 'add_empty' => true)),
      'role'       => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'profile_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'tribe_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tribe', 'column' => 'id')),
      'role'       => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tribe_participant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TribeParticipant';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'profile_id' => 'ForeignKey',
      'tribe_id'   => 'ForeignKey',
      'role'       => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
