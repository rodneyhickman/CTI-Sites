<?php

/**
 * Leadership form base class.
 *
 * @method Leadership getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLeadershipForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'profile_id'            => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'program_preference'    => new sfWidgetFormTextarea(),
      'preferred_date1'       => new sfWidgetFormTextarea(),
      'preferred_date2'       => new sfWidgetFormTextarea(),
      'preferred_date3'       => new sfWidgetFormTextarea(),
      'how_started'           => new sfWidgetFormTextarea(),
      'what_impact'           => new sfWidgetFormTextarea(),
      'why_take'              => new sfWidgetFormTextarea(),
      'desired_impact'        => new sfWidgetFormTextarea(),
      'how_accountable'       => new sfWidgetFormTextarea(),
      'what_bring'            => new sfWidgetFormTextarea(),
      'why_applying'          => new sfWidgetFormTextarea(),
      'what_size'             => new sfWidgetFormTextarea(),
      'background'            => new sfWidgetFormTextarea(),
      'understood_agreements' => new sfWidgetFormTextarea(),
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
      'program_preference'    => new sfValidatorString(array('required' => false)),
      'preferred_date1'       => new sfValidatorString(array('required' => false)),
      'preferred_date2'       => new sfValidatorString(array('required' => false)),
      'preferred_date3'       => new sfValidatorString(array('required' => false)),
      'how_started'           => new sfValidatorString(array('required' => false)),
      'what_impact'           => new sfValidatorString(array('required' => false)),
      'why_take'              => new sfValidatorString(array('required' => false)),
      'desired_impact'        => new sfValidatorString(array('required' => false)),
      'how_accountable'       => new sfValidatorString(array('required' => false)),
      'what_bring'            => new sfValidatorString(array('required' => false)),
      'why_applying'          => new sfValidatorString(array('required' => false)),
      'what_size'             => new sfValidatorString(array('required' => false)),
      'background'            => new sfValidatorString(array('required' => false)),
      'understood_agreements' => new sfValidatorString(array('required' => false)),
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

    $this->widgetSchema->setNameFormat('leadership[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Leadership';
  }


}
