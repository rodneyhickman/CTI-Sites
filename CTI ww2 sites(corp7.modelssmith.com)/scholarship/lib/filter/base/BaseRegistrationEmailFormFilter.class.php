<?php

/**
 * RegistrationEmail filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRegistrationEmailFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'workshop_id'             => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'registration_email_type' => new sfWidgetFormFilterInput(),
      'text'                    => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'workshop_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Workshop', 'column' => 'id')),
      'registration_email_type' => new sfValidatorPass(array('required' => false)),
      'text'                    => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('registration_email_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrationEmail';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'workshop_id'             => 'ForeignKey',
      'registration_email_type' => 'Text',
      'text'                    => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
    );
  }
}