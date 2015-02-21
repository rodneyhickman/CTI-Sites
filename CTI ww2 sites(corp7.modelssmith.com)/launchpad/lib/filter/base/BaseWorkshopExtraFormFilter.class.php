<?php

/**
 * WorkshopExtra filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWorkshopExtraFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'workshop_id'        => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'workshop_attribute' => new sfWidgetFormFilterInput(),
      'workshop_value'     => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'workshop_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Workshop', 'column' => 'id')),
      'workshop_attribute' => new sfValidatorPass(array('required' => false)),
      'workshop_value'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('workshop_extra_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkshopExtra';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'workshop_id'        => 'ForeignKey',
      'workshop_attribute' => 'Text',
      'workshop_value'     => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
