<?php

/**
 * Profile form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInput(),
      'email'                   => new sfWidgetFormInput(),
      'location'                => new sfWidgetFormInput(),
      'niche'                   => new sfWidgetFormTextarea(),
      'expertise'               => new sfWidgetFormTextarea(),
      'sf_guard_user_id'        => new sfWidgetFormInput(),
      'agree_clicked'           => new sfWidgetFormDateTime(),
      'number_of_contacts_made' => new sfWidgetFormInput(),
      'phone'                   => new sfWidgetFormInput(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'Profile', 'column' => 'id', 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'email'                   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'location'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'niche'                   => new sfValidatorString(array('required' => false)),
      'expertise'               => new sfValidatorString(array('required' => false)),
      'sf_guard_user_id'        => new sfValidatorInteger(array('required' => false)),
      'agree_clicked'           => new sfValidatorDateTime(array('required' => false)),
      'number_of_contacts_made' => new sfValidatorInteger(array('required' => false)),
      'phone'                   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }


}
