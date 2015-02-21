<?php

/**
 * Leaders form base class.
 *
 * @method Leaders getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLeadersForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'profile_id'            => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'phone_office'          => new sfWidgetFormTextarea(),
      'time_zone'             => new sfWidgetFormTextarea(),
      'skype'                 => new sfWidgetFormTextarea(),
      'education_history'     => new sfWidgetFormTextarea(),
      'credentials'           => new sfWidgetFormTextarea(),
      'resume'                => new sfWidgetFormInputText(),
      'photo'                 => new sfWidgetFormInputText(),
      'language_fluency'      => new sfWidgetFormTextarea(),
      'leadership_tribe'      => new sfWidgetFormTextarea(),
      'assisted_in_tribe'     => new sfWidgetFormInputText(),
      'tribe_name'            => new sfWidgetFormTextarea(),
      'leading_experience'    => new sfWidgetFormTextarea(),
      'enrollment_experience' => new sfWidgetFormTextarea(),
      'leader_recommendation' => new sfWidgetFormInputText(),
      'why_want_to_lead'      => new sfWidgetFormTextarea(),
      'life_purpose'          => new sfWidgetFormTextarea(),
      'quest'                 => new sfWidgetFormTextarea(),
      'initials'              => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'            => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'phone_office'          => new sfValidatorString(array('required' => false)),
      'time_zone'             => new sfValidatorString(array('required' => false)),
      'skype'                 => new sfValidatorString(array('required' => false)),
      'education_history'     => new sfValidatorString(array('required' => false)),
      'credentials'           => new sfValidatorString(array('required' => false)),
      'resume'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'language_fluency'      => new sfValidatorString(array('required' => false)),
      'leadership_tribe'      => new sfValidatorString(array('required' => false)),
      'assisted_in_tribe'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'tribe_name'            => new sfValidatorString(array('required' => false)),
      'leading_experience'    => new sfValidatorString(array('required' => false)),
      'enrollment_experience' => new sfValidatorString(array('required' => false)),
      'leader_recommendation' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'why_want_to_lead'      => new sfValidatorString(array('required' => false)),
      'life_purpose'          => new sfValidatorString(array('required' => false)),
      'quest'                 => new sfValidatorString(array('required' => false)),
      'initials'              => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('leaders[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Leaders';
  }


}
