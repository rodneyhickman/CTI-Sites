<?php

/**
 * Dietary form base class.
 *
 * @method Dietary getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDietaryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'profile_id'            => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'poultry'               => new sfWidgetFormInputText(),
      'beef'                  => new sfWidgetFormInputText(),
      'vegetarian'            => new sfWidgetFormInputText(),
      'seafood'               => new sfWidgetFormInputText(),
      'lamb'                  => new sfWidgetFormInputText(),
      'vegan'                 => new sfWidgetFormInputText(),
      'pork'                  => new sfWidgetFormInputText(),
      'dietary_restrictions'  => new sfWidgetFormInputText(),
      'describe_restrictions' => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'extra1'                => new sfWidgetFormTextarea(),
      'extra2'                => new sfWidgetFormTextarea(),
      'extra3'                => new sfWidgetFormTextarea(),
      'extra4'                => new sfWidgetFormTextarea(),
      'extra5'                => new sfWidgetFormTextarea(),
      'extra6'                => new sfWidgetFormTextarea(),
      'extra7'                => new sfWidgetFormTextarea(),
      'extra8'                => new sfWidgetFormTextarea(),
      'extra9'                => new sfWidgetFormTextarea(),
      'extra10'               => new sfWidgetFormTextarea(),
      'extra11'               => new sfWidgetFormTextarea(),
      'extra12'               => new sfWidgetFormTextarea(),
      'extra13'               => new sfWidgetFormTextarea(),
      'extra14'               => new sfWidgetFormTextarea(),
      'extra15'               => new sfWidgetFormTextarea(),
      'extra16'               => new sfWidgetFormTextarea(),
      'extra17'               => new sfWidgetFormTextarea(),
      'extra18'               => new sfWidgetFormTextarea(),
      'extra19'               => new sfWidgetFormTextarea(),
      'extra20'               => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'            => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'poultry'               => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'beef'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'vegetarian'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'seafood'               => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lamb'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'vegan'                 => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'pork'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'dietary_restrictions'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'describe_restrictions' => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'extra1'                => new sfValidatorString(array('required' => false)),
      'extra2'                => new sfValidatorString(array('required' => false)),
      'extra3'                => new sfValidatorString(array('required' => false)),
      'extra4'                => new sfValidatorString(array('required' => false)),
      'extra5'                => new sfValidatorString(array('required' => false)),
      'extra6'                => new sfValidatorString(array('required' => false)),
      'extra7'                => new sfValidatorString(array('required' => false)),
      'extra8'                => new sfValidatorString(array('required' => false)),
      'extra9'                => new sfValidatorString(array('required' => false)),
      'extra10'               => new sfValidatorString(array('required' => false)),
      'extra11'               => new sfValidatorString(array('required' => false)),
      'extra12'               => new sfValidatorString(array('required' => false)),
      'extra13'               => new sfValidatorString(array('required' => false)),
      'extra14'               => new sfValidatorString(array('required' => false)),
      'extra15'               => new sfValidatorString(array('required' => false)),
      'extra16'               => new sfValidatorString(array('required' => false)),
      'extra17'               => new sfValidatorString(array('required' => false)),
      'extra18'               => new sfValidatorString(array('required' => false)),
      'extra19'               => new sfValidatorString(array('required' => false)),
      'extra20'               => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dietary[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dietary';
  }


}
