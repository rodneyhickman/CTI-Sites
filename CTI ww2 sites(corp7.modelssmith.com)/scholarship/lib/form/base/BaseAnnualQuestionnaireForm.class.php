<?php

/**
 * AnnualQuestionnaire form base class.
 *
 * @method AnnualQuestionnaire getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAnnualQuestionnaireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'profile_id'          => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'tribe_first_choice'  => new sfWidgetFormTextarea(),
      'tribe_second_choice' => new sfWidgetFormTextarea(),
      'i_am_type'           => new sfWidgetFormTextarea(),
      'your_tribe_name'     => new sfWidgetFormTextarea(),
      'your_tribe_leader1'  => new sfWidgetFormTextarea(),
      'your_tribe_leader2'  => new sfWidgetFormTextarea(),
      'anything_else'       => new sfWidgetFormTextarea(),
      'contact_telephone'   => new sfWidgetFormTextarea(),
      'contact_email'       => new sfWidgetFormTextarea(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'extra1'              => new sfWidgetFormTextarea(),
      'extra2'              => new sfWidgetFormTextarea(),
      'extra3'              => new sfWidgetFormTextarea(),
      'extra4'              => new sfWidgetFormTextarea(),
      'extra5'              => new sfWidgetFormTextarea(),
      'extra6'              => new sfWidgetFormTextarea(),
      'extra7'              => new sfWidgetFormTextarea(),
      'extra8'              => new sfWidgetFormTextarea(),
      'extra9'              => new sfWidgetFormTextarea(),
      'extra10'             => new sfWidgetFormTextarea(),
      'extra11'             => new sfWidgetFormTextarea(),
      'extra12'             => new sfWidgetFormTextarea(),
      'extra13'             => new sfWidgetFormTextarea(),
      'extra14'             => new sfWidgetFormTextarea(),
      'extra15'             => new sfWidgetFormTextarea(),
      'extra16'             => new sfWidgetFormTextarea(),
      'extra17'             => new sfWidgetFormTextarea(),
      'extra18'             => new sfWidgetFormTextarea(),
      'extra19'             => new sfWidgetFormTextarea(),
      'extra20'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'          => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'tribe_first_choice'  => new sfValidatorString(array('required' => false)),
      'tribe_second_choice' => new sfValidatorString(array('required' => false)),
      'i_am_type'           => new sfValidatorString(array('required' => false)),
      'your_tribe_name'     => new sfValidatorString(array('required' => false)),
      'your_tribe_leader1'  => new sfValidatorString(array('required' => false)),
      'your_tribe_leader2'  => new sfValidatorString(array('required' => false)),
      'anything_else'       => new sfValidatorString(array('required' => false)),
      'contact_telephone'   => new sfValidatorString(array('required' => false)),
      'contact_email'       => new sfValidatorString(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'extra1'              => new sfValidatorString(array('required' => false)),
      'extra2'              => new sfValidatorString(array('required' => false)),
      'extra3'              => new sfValidatorString(array('required' => false)),
      'extra4'              => new sfValidatorString(array('required' => false)),
      'extra5'              => new sfValidatorString(array('required' => false)),
      'extra6'              => new sfValidatorString(array('required' => false)),
      'extra7'              => new sfValidatorString(array('required' => false)),
      'extra8'              => new sfValidatorString(array('required' => false)),
      'extra9'              => new sfValidatorString(array('required' => false)),
      'extra10'             => new sfValidatorString(array('required' => false)),
      'extra11'             => new sfValidatorString(array('required' => false)),
      'extra12'             => new sfValidatorString(array('required' => false)),
      'extra13'             => new sfValidatorString(array('required' => false)),
      'extra14'             => new sfValidatorString(array('required' => false)),
      'extra15'             => new sfValidatorString(array('required' => false)),
      'extra16'             => new sfValidatorString(array('required' => false)),
      'extra17'             => new sfValidatorString(array('required' => false)),
      'extra18'             => new sfValidatorString(array('required' => false)),
      'extra19'             => new sfValidatorString(array('required' => false)),
      'extra20'             => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('annual_questionnaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AnnualQuestionnaire';
  }


}
