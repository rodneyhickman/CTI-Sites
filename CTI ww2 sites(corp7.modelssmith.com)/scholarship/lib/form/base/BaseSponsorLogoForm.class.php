<?php

/**
 * SponsorLogo form base class.
 *
 * @method SponsorLogo getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSponsorLogoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'workshop_id' => new sfWidgetFormPropelChoice(array('model' => 'Workshop', 'add_empty' => true)),
      'filename'    => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormInputText(),
      'url'         => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'workshop_id' => new sfValidatorPropelChoice(array('model' => 'Workshop', 'column' => 'id', 'required' => false)),
      'filename'    => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'url'         => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sponsor_logo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SponsorLogo';
  }


}
