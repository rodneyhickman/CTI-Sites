<?php

/**
 * Workshop form base class.
 *
 * @method Workshop getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWorkshopForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'client_id'             => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'category_id'           => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'name'                  => new sfWidgetFormInputText(),
      'workshop_date'         => new sfWidgetFormDate(),
      'workshop_time'         => new sfWidgetFormTime(),
      'location'              => new sfWidgetFormInputText(),
      'cost'                  => new sfWidgetFormInputText(),
      'last_day_to_register'  => new sfWidgetFormDate(),
      'max_nbr_attendees'     => new sfWidgetFormInputText(),
      'nbr_current_attendees' => new sfWidgetFormInputText(),
      'description'           => new sfWidgetFormTextarea(),
      'logistics'             => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'client_id'             => new sfValidatorPropelChoice(array('model' => 'Client', 'column' => 'id', 'required' => false)),
      'category_id'           => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'workshop_date'         => new sfValidatorDate(array('required' => false)),
      'workshop_time'         => new sfValidatorTime(array('required' => false)),
      'location'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'cost'                  => new sfValidatorNumber(array('required' => false)),
      'last_day_to_register'  => new sfValidatorDate(array('required' => false)),
      'max_nbr_attendees'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nbr_current_attendees' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'description'           => new sfValidatorString(array('required' => false)),
      'logistics'             => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workshop[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Workshop';
  }


}
