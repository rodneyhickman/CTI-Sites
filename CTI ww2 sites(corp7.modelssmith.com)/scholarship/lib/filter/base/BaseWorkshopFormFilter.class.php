<?php

/**
 * Workshop filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWorkshopFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'client_id'             => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'category_id'           => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'name'                  => new sfWidgetFormFilterInput(),
      'workshop_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'workshop_time'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'location'              => new sfWidgetFormFilterInput(),
      'cost'                  => new sfWidgetFormFilterInput(),
      'last_day_to_register'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'max_nbr_attendees'     => new sfWidgetFormFilterInput(),
      'nbr_current_attendees' => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'logistics'             => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'client_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Client', 'column' => 'id')),
      'category_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Category', 'column' => 'id')),
      'name'                  => new sfValidatorPass(array('required' => false)),
      'workshop_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'workshop_time'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'location'              => new sfValidatorPass(array('required' => false)),
      'cost'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'last_day_to_register'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'max_nbr_attendees'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbr_current_attendees' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'           => new sfValidatorPass(array('required' => false)),
      'logistics'             => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('workshop_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Workshop';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'client_id'             => 'ForeignKey',
      'category_id'           => 'ForeignKey',
      'name'                  => 'Text',
      'workshop_date'         => 'Date',
      'workshop_time'         => 'Date',
      'location'              => 'Text',
      'cost'                  => 'Number',
      'last_day_to_register'  => 'Date',
      'max_nbr_attendees'     => 'Number',
      'nbr_current_attendees' => 'Number',
      'description'           => 'Text',
      'logistics'             => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
