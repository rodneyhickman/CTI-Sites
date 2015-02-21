<?php

/**
 * Medical form base class.
 *
 * @method Medical getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMedicalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'profile_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'height'                      => new sfWidgetFormTextarea(),
      'weight'                      => new sfWidgetFormTextarea(),
      'conditions_physical'         => new sfWidgetFormInputText(),
      'conditions_psychological'    => new sfWidgetFormInputText(),
      'accommodations'              => new sfWidgetFormTextarea(),
      'head'                        => new sfWidgetFormInputText(),
      'neck'                        => new sfWidgetFormInputText(),
      'whiplash'                    => new sfWidgetFormInputText(),
      'shoulders'                   => new sfWidgetFormInputText(),
      'arms'                        => new sfWidgetFormInputText(),
      'wrists'                      => new sfWidgetFormInputText(),
      'hands'                       => new sfWidgetFormInputText(),
      'upper_back'                  => new sfWidgetFormInputText(),
      'lower_back'                  => new sfWidgetFormInputText(),
      'pelvis'                      => new sfWidgetFormInputText(),
      'groin'                       => new sfWidgetFormInputText(),
      'dislocations'                => new sfWidgetFormInputText(),
      'dislocations_where'          => new sfWidgetFormTextarea(),
      'asthma'                      => new sfWidgetFormInputText(),
      'do_you_smoke'                => new sfWidgetFormInputText(),
      'have_you_ever_smoked'        => new sfWidgetFormInputText(),
      'are_you_currently_pregnant'  => new sfWidgetFormInputText(),
      'due_date'                    => new sfWidgetFormDate(),
      'lower_legs'                  => new sfWidgetFormInputText(),
      'thighs'                      => new sfWidgetFormInputText(),
      'knees'                       => new sfWidgetFormInputText(),
      'ankles'                      => new sfWidgetFormInputText(),
      'feet'                        => new sfWidgetFormInputText(),
      'internal_organs'             => new sfWidgetFormInputText(),
      'heart'                       => new sfWidgetFormInputText(),
      'lungs'                       => new sfWidgetFormInputText(),
      'ears'                        => new sfWidgetFormInputText(),
      'eyes'                        => new sfWidgetFormInputText(),
      'contact_lenses'              => new sfWidgetFormInputText(),
      'dizziness'                   => new sfWidgetFormInputText(),
      'high_blood_pressure'         => new sfWidgetFormInputText(),
      'heart_attack'                => new sfWidgetFormInputText(),
      'diabetes'                    => new sfWidgetFormInputText(),
      'epilepsy_seizures'           => new sfWidgetFormInputText(),
      'other_serious_illness'       => new sfWidgetFormInputText(),
      'explanation'                 => new sfWidgetFormTextarea(),
      'allergies'                   => new sfWidgetFormTextarea(),
      'medications'                 => new sfWidgetFormInputText(),
      'name_of_medications'         => new sfWidgetFormTextarea(),
      'what_are_medications_for'    => new sfWidgetFormTextarea(),
      'medication_dosages'          => new sfWidgetFormTextarea(),
      'emergency_contact_name'      => new sfWidgetFormTextarea(),
      'emergency_relationship'      => new sfWidgetFormTextarea(),
      'emergency_address'           => new sfWidgetFormTextarea(),
      'emergency_work_phone'        => new sfWidgetFormTextarea(),
      'emergency_home_phone'        => new sfWidgetFormTextarea(),
      'emergency_other_phone'       => new sfWidgetFormTextarea(),
      'coverage_provider'           => new sfWidgetFormTextarea(),
      'policy_number'               => new sfWidgetFormTextarea(),
      'other_insurance_information' => new sfWidgetFormTextarea(),
      'doctors_name'                => new sfWidgetFormTextarea(),
      'doctors_contact_info'        => new sfWidgetFormTextarea(),
      'release_of_liability'        => new sfWidgetFormInputText(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'extra1'                      => new sfWidgetFormTextarea(),
      'extra2'                      => new sfWidgetFormTextarea(),
      'extra3'                      => new sfWidgetFormTextarea(),
      'extra4'                      => new sfWidgetFormTextarea(),
      'extra5'                      => new sfWidgetFormTextarea(),
      'extra6'                      => new sfWidgetFormTextarea(),
      'extra7'                      => new sfWidgetFormTextarea(),
      'extra8'                      => new sfWidgetFormTextarea(),
      'extra9'                      => new sfWidgetFormTextarea(),
      'extra10'                     => new sfWidgetFormTextarea(),
      'extra11'                     => new sfWidgetFormTextarea(),
      'extra12'                     => new sfWidgetFormTextarea(),
      'extra13'                     => new sfWidgetFormTextarea(),
      'extra14'                     => new sfWidgetFormTextarea(),
      'extra15'                     => new sfWidgetFormTextarea(),
      'extra16'                     => new sfWidgetFormTextarea(),
      'extra17'                     => new sfWidgetFormTextarea(),
      'extra18'                     => new sfWidgetFormTextarea(),
      'extra19'                     => new sfWidgetFormTextarea(),
      'extra20'                     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'                  => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'height'                      => new sfValidatorString(array('required' => false)),
      'weight'                      => new sfValidatorString(array('required' => false)),
      'conditions_physical'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'conditions_psychological'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'accommodations'              => new sfValidatorString(array('required' => false)),
      'head'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'neck'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'whiplash'                    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'shoulders'                   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'arms'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'wrists'                      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'hands'                       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'upper_back'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lower_back'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'pelvis'                      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'groin'                       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'dislocations'                => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'dislocations_where'          => new sfValidatorString(array('required' => false)),
      'asthma'                      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'do_you_smoke'                => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'have_you_ever_smoked'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'are_you_currently_pregnant'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'due_date'                    => new sfValidatorDate(array('required' => false)),
      'lower_legs'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'thighs'                      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'knees'                       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'ankles'                      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'feet'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'internal_organs'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'heart'                       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lungs'                       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'ears'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'eyes'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'contact_lenses'              => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'dizziness'                   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'high_blood_pressure'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'heart_attack'                => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'diabetes'                    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'epilepsy_seizures'           => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'other_serious_illness'       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'explanation'                 => new sfValidatorString(array('required' => false)),
      'allergies'                   => new sfValidatorString(array('required' => false)),
      'medications'                 => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'name_of_medications'         => new sfValidatorString(array('required' => false)),
      'what_are_medications_for'    => new sfValidatorString(array('required' => false)),
      'medication_dosages'          => new sfValidatorString(array('required' => false)),
      'emergency_contact_name'      => new sfValidatorString(array('required' => false)),
      'emergency_relationship'      => new sfValidatorString(array('required' => false)),
      'emergency_address'           => new sfValidatorString(array('required' => false)),
      'emergency_work_phone'        => new sfValidatorString(array('required' => false)),
      'emergency_home_phone'        => new sfValidatorString(array('required' => false)),
      'emergency_other_phone'       => new sfValidatorString(array('required' => false)),
      'coverage_provider'           => new sfValidatorString(array('required' => false)),
      'policy_number'               => new sfValidatorString(array('required' => false)),
      'other_insurance_information' => new sfValidatorString(array('required' => false)),
      'doctors_name'                => new sfValidatorString(array('required' => false)),
      'doctors_contact_info'        => new sfValidatorString(array('required' => false)),
      'release_of_liability'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'                  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                  => new sfValidatorDateTime(array('required' => false)),
      'extra1'                      => new sfValidatorString(array('required' => false)),
      'extra2'                      => new sfValidatorString(array('required' => false)),
      'extra3'                      => new sfValidatorString(array('required' => false)),
      'extra4'                      => new sfValidatorString(array('required' => false)),
      'extra5'                      => new sfValidatorString(array('required' => false)),
      'extra6'                      => new sfValidatorString(array('required' => false)),
      'extra7'                      => new sfValidatorString(array('required' => false)),
      'extra8'                      => new sfValidatorString(array('required' => false)),
      'extra9'                      => new sfValidatorString(array('required' => false)),
      'extra10'                     => new sfValidatorString(array('required' => false)),
      'extra11'                     => new sfValidatorString(array('required' => false)),
      'extra12'                     => new sfValidatorString(array('required' => false)),
      'extra13'                     => new sfValidatorString(array('required' => false)),
      'extra14'                     => new sfValidatorString(array('required' => false)),
      'extra15'                     => new sfValidatorString(array('required' => false)),
      'extra16'                     => new sfValidatorString(array('required' => false)),
      'extra17'                     => new sfValidatorString(array('required' => false)),
      'extra18'                     => new sfValidatorString(array('required' => false)),
      'extra19'                     => new sfValidatorString(array('required' => false)),
      'extra20'                     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('medical[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Medical';
  }


}