<?php

/**
 * Execcoach form base class.
 *
 * @method Execcoach getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseExeccoachForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'profile_id'              => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'bio_resume'              => new sfWidgetFormTextarea(),
      'photo'                   => new sfWidgetFormTextarea(),
      'home_country'            => new sfWidgetFormTextarea(),
      'phone_home'              => new sfWidgetFormTextarea(),
      'phone_office'            => new sfWidgetFormTextarea(),
      'phone_mobile'            => new sfWidgetFormTextarea(),
      'skype'                   => new sfWidgetFormTextarea(),
      'time_zone'               => new sfWidgetFormTextarea(),
      'language_fluency'        => new sfWidgetFormTextarea(),
      'education'               => new sfWidgetFormTextarea(),
      'certifications'          => new sfWidgetFormTextarea(),
      'authorized_to_work'      => new sfWidgetFormTextarea(),
      'years_cti'               => new sfWidgetFormTextarea(),
      'what_capacity'           => new sfWidgetFormTextarea(),
      'corporate_clients'       => new sfWidgetFormTextarea(),
      'training_style'          => new sfWidgetFormTextarea(),
      'publication_engagements' => new sfWidgetFormTextarea(),
      'expertise'               => new sfWidgetFormTextarea(),
      'industries'              => new sfWidgetFormTextarea(),
      'types_of_coaching'       => new sfWidgetFormTextarea(),
      'number_of_executives'    => new sfWidgetFormTextarea(),
      'outcomes_tracked'        => new sfWidgetFormTextarea(),
      'work_visa'               => new sfWidgetFormTextarea(),
      'travel_visa'             => new sfWidgetFormTextarea(),
      'media_exposure'          => new sfWidgetFormTextarea(),
      'size_of_group'           => new sfWidgetFormTextarea(),
      'endorsements'            => new sfWidgetFormTextarea(),
      'utilization_corp_forl'   => new sfWidgetFormTextarea(),
      'utilization_corp_coach'  => new sfWidgetFormTextarea(),
      'utilization_exec_coach'  => new sfWidgetFormTextarea(),
      'extra1'                  => new sfWidgetFormTextarea(),
      'extra2'                  => new sfWidgetFormTextarea(),
      'extra3'                  => new sfWidgetFormTextarea(),
      'extra4'                  => new sfWidgetFormTextarea(),
      'extra5'                  => new sfWidgetFormTextarea(),
      'extra6'                  => new sfWidgetFormTextarea(),
      'extra7'                  => new sfWidgetFormTextarea(),
      'extra8'                  => new sfWidgetFormTextarea(),
      'extra9'                  => new sfWidgetFormTextarea(),
      'extra10'                 => new sfWidgetFormTextarea(),
      'extra11'                 => new sfWidgetFormTextarea(),
      'extra12'                 => new sfWidgetFormTextarea(),
      'extra13'                 => new sfWidgetFormTextarea(),
      'extra14'                 => new sfWidgetFormTextarea(),
      'extra15'                 => new sfWidgetFormTextarea(),
      'extra16'                 => new sfWidgetFormTextarea(),
      'extra17'                 => new sfWidgetFormTextarea(),
      'extra18'                 => new sfWidgetFormTextarea(),
      'extra19'                 => new sfWidgetFormTextarea(),
      'extra20'                 => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'              => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'bio_resume'              => new sfValidatorString(array('required' => false)),
      'photo'                   => new sfValidatorString(array('required' => false)),
      'home_country'            => new sfValidatorString(array('required' => false)),
      'phone_home'              => new sfValidatorString(array('required' => false)),
      'phone_office'            => new sfValidatorString(array('required' => false)),
      'phone_mobile'            => new sfValidatorString(array('required' => false)),
      'skype'                   => new sfValidatorString(array('required' => false)),
      'time_zone'               => new sfValidatorString(array('required' => false)),
      'language_fluency'        => new sfValidatorString(array('required' => false)),
      'education'               => new sfValidatorString(array('required' => false)),
      'certifications'          => new sfValidatorString(array('required' => false)),
      'authorized_to_work'      => new sfValidatorString(array('required' => false)),
      'years_cti'               => new sfValidatorString(array('required' => false)),
      'what_capacity'           => new sfValidatorString(array('required' => false)),
      'corporate_clients'       => new sfValidatorString(array('required' => false)),
      'training_style'          => new sfValidatorString(array('required' => false)),
      'publication_engagements' => new sfValidatorString(array('required' => false)),
      'expertise'               => new sfValidatorString(array('required' => false)),
      'industries'              => new sfValidatorString(array('required' => false)),
      'types_of_coaching'       => new sfValidatorString(array('required' => false)),
      'number_of_executives'    => new sfValidatorString(array('required' => false)),
      'outcomes_tracked'        => new sfValidatorString(array('required' => false)),
      'work_visa'               => new sfValidatorString(array('required' => false)),
      'travel_visa'             => new sfValidatorString(array('required' => false)),
      'media_exposure'          => new sfValidatorString(array('required' => false)),
      'size_of_group'           => new sfValidatorString(array('required' => false)),
      'endorsements'            => new sfValidatorString(array('required' => false)),
      'utilization_corp_forl'   => new sfValidatorString(array('required' => false)),
      'utilization_corp_coach'  => new sfValidatorString(array('required' => false)),
      'utilization_exec_coach'  => new sfValidatorString(array('required' => false)),
      'extra1'                  => new sfValidatorString(array('required' => false)),
      'extra2'                  => new sfValidatorString(array('required' => false)),
      'extra3'                  => new sfValidatorString(array('required' => false)),
      'extra4'                  => new sfValidatorString(array('required' => false)),
      'extra5'                  => new sfValidatorString(array('required' => false)),
      'extra6'                  => new sfValidatorString(array('required' => false)),
      'extra7'                  => new sfValidatorString(array('required' => false)),
      'extra8'                  => new sfValidatorString(array('required' => false)),
      'extra9'                  => new sfValidatorString(array('required' => false)),
      'extra10'                 => new sfValidatorString(array('required' => false)),
      'extra11'                 => new sfValidatorString(array('required' => false)),
      'extra12'                 => new sfValidatorString(array('required' => false)),
      'extra13'                 => new sfValidatorString(array('required' => false)),
      'extra14'                 => new sfValidatorString(array('required' => false)),
      'extra15'                 => new sfValidatorString(array('required' => false)),
      'extra16'                 => new sfValidatorString(array('required' => false)),
      'extra17'                 => new sfValidatorString(array('required' => false)),
      'extra18'                 => new sfValidatorString(array('required' => false)),
      'extra19'                 => new sfValidatorString(array('required' => false)),
      'extra20'                 => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('execcoach[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Execcoach';
  }


}
