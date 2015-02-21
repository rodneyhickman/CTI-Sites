<?php

/**
 * FeatureCredential form base class.
 *
 * @method FeatureCredential getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFeatureCredentialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'product_level'       => new sfWidgetFormInputText(),
      'product_feature'     => new sfWidgetFormInputText(),
      'required_credential' => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'product_level'       => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'product_feature'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'required_credential' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('feature_credential[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FeatureCredential';
  }


}
