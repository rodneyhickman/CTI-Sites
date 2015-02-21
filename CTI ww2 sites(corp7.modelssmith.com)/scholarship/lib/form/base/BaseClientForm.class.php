<?php

/**
 * Client form base class.
 *
 * @method Client getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseClientForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'sf_guard_user_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'client_email'          => new sfWidgetFormInputText(),
      'name'                  => new sfWidgetFormInputText(),
      'address_line1'         => new sfWidgetFormInputText(),
      'address_line2'         => new sfWidgetFormInputText(),
      'city'                  => new sfWidgetFormInputText(),
      'state'                 => new sfWidgetFormInputText(),
      'zip'                   => new sfWidgetFormInputText(),
      'country'               => new sfWidgetFormInputText(),
      'work_phone'            => new sfWidgetFormInputText(),
      'contact_name'          => new sfWidgetFormInputText(),
      'using_version'         => new sfWidgetFormInputText(),
      'client_using_features' => new sfWidgetFormInputText(),
      'status'                => new sfWidgetFormInputText(),
      'subscriber_id'         => new sfWidgetFormInputText(),
      'subscription_plan_id'  => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'sf_guard_user_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'client_email'          => new sfValidatorString(array('max_length' => 100)),
      'name'                  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address_line1'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address_line2'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'city'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'state'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'zip'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'country'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'work_phone'            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'contact_name'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'using_version'         => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'client_using_features' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'status'                => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'subscriber_id'         => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'subscription_plan_id'  => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Client', 'column' => array('client_email')))
    );

    $this->widgetSchema->setNameFormat('client[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Client';
  }


}
