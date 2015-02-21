<?php

/**
 * WorkshopRegistrant filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWorkshopRegistrantFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'registrant_id' => new sfWidgetFormPropelChoice(array('model' => 'Registrant', 'add_empty' => true)),
      'workshop_id'   => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'registrant_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Registrant', 'column' => 'id')),
      'workshop_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Workshop', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('workshop_registrant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkshopRegistrant';
  }

  public function getFields()
  {
    return array(
      'registrant_id' => 'ForeignKey',
      'workshop_id'   => 'ForeignKey',
      'id'            => 'Number',
    );
  }
}
