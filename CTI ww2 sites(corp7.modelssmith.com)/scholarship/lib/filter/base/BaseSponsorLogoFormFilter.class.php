<?php

/**
 * SponsorLogo filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSponsorLogoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'workshop_id' => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'filename'    => new sfWidgetFormFilterInput(),
      'name'        => new sfWidgetFormFilterInput(),
      'url'         => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'workshop_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Workshop', 'column' => 'id')),
      'filename'    => new sfValidatorPass(array('required' => false)),
      'name'        => new sfValidatorPass(array('required' => false)),
      'url'         => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('sponsor_logo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SponsorLogo';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'workshop_id' => 'ForeignKey',
      'filename'    => 'Text',
      'name'        => 'Text',
      'url'         => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
