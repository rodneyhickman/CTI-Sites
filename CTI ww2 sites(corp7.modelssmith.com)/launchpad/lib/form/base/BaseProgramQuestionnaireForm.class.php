<?php

/**
 * ProgramQuestionnaire form base class.
 *
 * @method ProgramQuestionnaire getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProgramQuestionnaireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'profile_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'nationality'                 => new sfWidgetFormTextarea(),
      'relationship_status'         => new sfWidgetFormTextarea(),
      'current_profession'          => new sfWidgetFormTextarea(),
      'past_profession'             => new sfWidgetFormTextarea(),
      'personal_professional_goals' => new sfWidgetFormTextarea(),
      'strengths'                   => new sfWidgetFormTextarea(),
      'holds_you_back'              => new sfWidgetFormTextarea(),
      'handle_failing'              => new sfWidgetFormTextarea(),
      'willing_to_fail'             => new sfWidgetFormTextarea(),
      'willing_to_listen'           => new sfWidgetFormTextarea(),
      'therapy'                     => new sfWidgetFormInputText(),
      'therapy_details'             => new sfWidgetFormTextarea(),
      'therapy_impact'              => new sfWidgetFormTextarea(),
      'fundamentals'                => new sfWidgetFormInputText(),
      'intermediate_curriculum'     => new sfWidgetFormInputText(),
      'certification'               => new sfWidgetFormInputText(),
      'quest'                       => new sfWidgetFormInputText(),
      'icc_curriculum'              => new sfWidgetFormInputText(),
      'have_a_coach'                => new sfWidgetFormInputText(),
      'coaching_impact'             => new sfWidgetFormTextarea(),
      'religious_affiliations'      => new sfWidgetFormTextarea(),
      'religious_influences'        => new sfWidgetFormTextarea(),
      'growth_experiences'          => new sfWidgetFormTextarea(),
      'impact_as_a_leader'          => new sfWidgetFormTextarea(),
      'challenge'                   => new sfWidgetFormTextarea(),
      'why_this_program'            => new sfWidgetFormTextarea(),
      'play_level'                  => new sfWidgetFormInputText(),
      'what_would_it_take'          => new sfWidgetFormTextarea(),
      'bring_yourself_back'         => new sfWidgetFormTextarea(),
      'going_the_distance'          => new sfWidgetFormTextarea(),
      'i_was_born_to'               => new sfWidgetFormTextarea(),
      'comments'                    => new sfWidgetFormTextarea(),
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
      'nationality'                 => new sfValidatorString(array('required' => false)),
      'relationship_status'         => new sfValidatorString(array('required' => false)),
      'current_profession'          => new sfValidatorString(array('required' => false)),
      'past_profession'             => new sfValidatorString(array('required' => false)),
      'personal_professional_goals' => new sfValidatorString(array('required' => false)),
      'strengths'                   => new sfValidatorString(array('required' => false)),
      'holds_you_back'              => new sfValidatorString(array('required' => false)),
      'handle_failing'              => new sfValidatorString(array('required' => false)),
      'willing_to_fail'             => new sfValidatorString(array('required' => false)),
      'willing_to_listen'           => new sfValidatorString(array('required' => false)),
      'therapy'                     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'therapy_details'             => new sfValidatorString(array('required' => false)),
      'therapy_impact'              => new sfValidatorString(array('required' => false)),
      'fundamentals'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'intermediate_curriculum'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'certification'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'quest'                       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'icc_curriculum'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'have_a_coach'                => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'coaching_impact'             => new sfValidatorString(array('required' => false)),
      'religious_affiliations'      => new sfValidatorString(array('required' => false)),
      'religious_influences'        => new sfValidatorString(array('required' => false)),
      'growth_experiences'          => new sfValidatorString(array('required' => false)),
      'impact_as_a_leader'          => new sfValidatorString(array('required' => false)),
      'challenge'                   => new sfValidatorString(array('required' => false)),
      'why_this_program'            => new sfValidatorString(array('required' => false)),
      'play_level'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'what_would_it_take'          => new sfValidatorString(array('required' => false)),
      'bring_yourself_back'         => new sfValidatorString(array('required' => false)),
      'going_the_distance'          => new sfValidatorString(array('required' => false)),
      'i_was_born_to'               => new sfValidatorString(array('required' => false)),
      'comments'                    => new sfValidatorString(array('required' => false)),
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

    $this->widgetSchema->setNameFormat('program_questionnaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProgramQuestionnaire';
  }


}
