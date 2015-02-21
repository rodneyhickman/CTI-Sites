<?php

/**
 * Certification form base class.
 *
 * @method Certification getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCertificationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'profile_id'             => new sfWidgetFormPropelChoice(array('model' => 'Profile', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'address'                => new sfWidgetFormTextarea(),
      'address2'               => new sfWidgetFormTextarea(),
      'city'                   => new sfWidgetFormTextarea(),
      'state_province'         => new sfWidgetFormTextarea(),
      'country'                => new sfWidgetFormTextarea(),
      'zip_postal_code'        => new sfWidgetFormTextarea(),
      'evening_phone'          => new sfWidgetFormTextarea(),
      'day_phone'              => new sfWidgetFormTextarea(),
      'email'                  => new sfWidgetFormTextarea(),
      'fax'                    => new sfWidgetFormTextarea(),
      'mobile'                 => new sfWidgetFormTextarea(),
      'how_many_clients'       => new sfWidgetFormTextarea(),
      'month_to_begin'         => new sfWidgetFormTextarea(),
      'languages_coaching'     => new sfWidgetFormTextarea(),
      'date_completed_process' => new sfWidgetFormTextarea(),
      'date_of_synergy'        => new sfWidgetFormTextarea(),
      'your_certified_coach'   => new sfWidgetFormTextarea(),
      'cpcc'                   => new sfWidgetFormInputText(),
      'pcc'                    => new sfWidgetFormInputText(),
      'mcc'                    => new sfWidgetFormInputText(),
      'your_coachs_email'      => new sfWidgetFormTextarea(),
      'call_length'            => new sfWidgetFormTextarea(),
      'times_a_month'          => new sfWidgetFormTextarea(),
      'extra1'                 => new sfWidgetFormTextarea(),
      'extra2'                 => new sfWidgetFormTextarea(),
      'extra3'                 => new sfWidgetFormTextarea(),
      'extra4'                 => new sfWidgetFormTextarea(),
      'extra5'                 => new sfWidgetFormTextarea(),
      'extra6'                 => new sfWidgetFormTextarea(),
      'extra7'                 => new sfWidgetFormTextarea(),
      'extra8'                 => new sfWidgetFormTextarea(),
      'extra9'                 => new sfWidgetFormTextarea(),
      'extra10'                => new sfWidgetFormTextarea(),
      'extra11'                => new sfWidgetFormTextarea(),
      'extra12'                => new sfWidgetFormTextarea(),
      'extra13'                => new sfWidgetFormTextarea(),
      'extra14'                => new sfWidgetFormTextarea(),
      'extra15'                => new sfWidgetFormTextarea(),
      'extra16'                => new sfWidgetFormTextarea(),
      'extra17'                => new sfWidgetFormTextarea(),
      'extra18'                => new sfWidgetFormTextarea(),
      'extra19'                => new sfWidgetFormTextarea(),
      'extra20'                => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'profile_id'             => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'address'                => new sfValidatorString(array('required' => false)),
      'address2'               => new sfValidatorString(array('required' => false)),
      'city'                   => new sfValidatorString(array('required' => false)),
      'state_province'         => new sfValidatorString(array('required' => false)),
      'country'                => new sfValidatorString(array('required' => false)),
      'zip_postal_code'        => new sfValidatorString(array('required' => false)),
      'evening_phone'          => new sfValidatorString(array('required' => false)),
      'day_phone'              => new sfValidatorString(array('required' => false)),
      'email'                  => new sfValidatorString(array('required' => false)),
      'fax'                    => new sfValidatorString(array('required' => false)),
      'mobile'                 => new sfValidatorString(array('required' => false)),
      'how_many_clients'       => new sfValidatorString(array('required' => false)),
      'month_to_begin'         => new sfValidatorString(array('required' => false)),
      'languages_coaching'     => new sfValidatorString(array('required' => false)),
      'date_completed_process' => new sfValidatorString(array('required' => false)),
      'date_of_synergy'        => new sfValidatorString(array('required' => false)),
      'your_certified_coach'   => new sfValidatorString(array('required' => false)),
      'cpcc'                   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'pcc'                    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'mcc'                    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'your_coachs_email'      => new sfValidatorString(array('required' => false)),
      'call_length'            => new sfValidatorString(array('required' => false)),
      'times_a_month'          => new sfValidatorString(array('required' => false)),
      'extra1'                 => new sfValidatorString(array('required' => false)),
      'extra2'                 => new sfValidatorString(array('required' => false)),
      'extra3'                 => new sfValidatorString(array('required' => false)),
      'extra4'                 => new sfValidatorString(array('required' => false)),
      'extra5'                 => new sfValidatorString(array('required' => false)),
      'extra6'                 => new sfValidatorString(array('required' => false)),
      'extra7'                 => new sfValidatorString(array('required' => false)),
      'extra8'                 => new sfValidatorString(array('required' => false)),
      'extra9'                 => new sfValidatorString(array('required' => false)),
      'extra10'                => new sfValidatorString(array('required' => false)),
      'extra11'                => new sfValidatorString(array('required' => false)),
      'extra12'                => new sfValidatorString(array('required' => false)),
      'extra13'                => new sfValidatorString(array('required' => false)),
      'extra14'                => new sfValidatorString(array('required' => false)),
      'extra15'                => new sfValidatorString(array('required' => false)),
      'extra16'                => new sfValidatorString(array('required' => false)),
      'extra17'                => new sfValidatorString(array('required' => false)),
      'extra18'                => new sfValidatorString(array('required' => false)),
      'extra19'                => new sfValidatorString(array('required' => false)),
      'extra20'                => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('certification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Certification';
  }


}
