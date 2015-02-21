<?php

/**
 * RegistrantExtra filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRegistrantExtraFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'registrant_id' => new sfWidgetFormPropelChoice(array('model' => 'Registrant', 'add_empty' => true)),
      'field_name'    => new sfWidgetFormFilterInput(),
      'field_order'   => new sfWidgetFormFilterInput(),
      'field_data'    => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'registrant_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Registrant', 'column' => 'id')),
      'field_name'    => new sfValidatorPass(array('required' => false)),
      'field_order'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'field_data'    => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('registrant_extra_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrantExtra';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'registrant_id' => 'ForeignKey',
      'field_name'    => 'Text',
      'field_order'   => 'Number',
      'field_data'    => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
