<?php

/**
 * Leaders filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseLeadersFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'profile_id'            => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'phone_office'          => new sfWidgetFormFilterInput(),
      'time_zone'             => new sfWidgetFormFilterInput(),
      'skype'                 => new sfWidgetFormFilterInput(),
      'education_history'     => new sfWidgetFormFilterInput(),
      'credentials'           => new sfWidgetFormFilterInput(),
      'resume'                => new sfWidgetFormFilterInput(),
      'photo'                 => new sfWidgetFormFilterInput(),
      'language_fluency'      => new sfWidgetFormFilterInput(),
      'leadership_tribe'      => new sfWidgetFormFilterInput(),
      'assisted_in_tribe'     => new sfWidgetFormFilterInput(),
      'tribe_name'            => new sfWidgetFormFilterInput(),
      'leading_experience'    => new sfWidgetFormFilterInput(),
      'enrollment_experience' => new sfWidgetFormFilterInput(),
      'leader_recommendation' => new sfWidgetFormFilterInput(),
      'why_want_to_lead'      => new sfWidgetFormFilterInput(),
      'life_purpose'          => new sfWidgetFormFilterInput(),
      'quest'                 => new sfWidgetFormFilterInput(),
      'initials'              => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'profile_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'phone_office'          => new sfValidatorPass(array('required' => false)),
      'time_zone'             => new sfValidatorPass(array('required' => false)),
      'skype'                 => new sfValidatorPass(array('required' => false)),
      'education_history'     => new sfValidatorPass(array('required' => false)),
      'credentials'           => new sfValidatorPass(array('required' => false)),
      'resume'                => new sfValidatorPass(array('required' => false)),
      'photo'                 => new sfValidatorPass(array('required' => false)),
      'language_fluency'      => new sfValidatorPass(array('required' => false)),
      'leadership_tribe'      => new sfValidatorPass(array('required' => false)),
      'assisted_in_tribe'     => new sfValidatorPass(array('required' => false)),
      'tribe_name'            => new sfValidatorPass(array('required' => false)),
      'leading_experience'    => new sfValidatorPass(array('required' => false)),
      'enrollment_experience' => new sfValidatorPass(array('required' => false)),
      'leader_recommendation' => new sfValidatorPass(array('required' => false)),
      'why_want_to_lead'      => new sfValidatorPass(array('required' => false)),
      'life_purpose'          => new sfValidatorPass(array('required' => false)),
      'quest'                 => new sfValidatorPass(array('required' => false)),
      'initials'              => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('leaders_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Leaders';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'profile_id'            => 'ForeignKey',
      'phone_office'          => 'Text',
      'time_zone'             => 'Text',
      'skype'                 => 'Text',
      'education_history'     => 'Text',
      'credentials'           => 'Text',
      'resume'                => 'Text',
      'photo'                 => 'Text',
      'language_fluency'      => 'Text',
      'leadership_tribe'      => 'Text',
      'assisted_in_tribe'     => 'Text',
      'tribe_name'            => 'Text',
      'leading_experience'    => 'Text',
      'enrollment_experience' => 'Text',
      'leader_recommendation' => 'Text',
      'why_want_to_lead'      => 'Text',
      'life_purpose'          => 'Text',
      'quest'                 => 'Text',
      'initials'              => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
