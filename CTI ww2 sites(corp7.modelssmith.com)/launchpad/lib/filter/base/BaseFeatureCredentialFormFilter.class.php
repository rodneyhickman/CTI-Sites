<?php

/**
 * FeatureCredential filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFeatureCredentialFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_level'       => new sfWidgetFormFilterInput(),
      'product_feature'     => new sfWidgetFormFilterInput(),
      'required_credential' => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'product_level'       => new sfValidatorPass(array('required' => false)),
      'product_feature'     => new sfValidatorPass(array('required' => false)),
      'required_credential' => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('feature_credential_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FeatureCredential';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'product_level'       => 'Text',
      'product_feature'     => 'Text',
      'required_credential' => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
