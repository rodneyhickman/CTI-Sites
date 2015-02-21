<?php

/**
 * Client filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseClientFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sf_guard_user_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'client_email'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                  => new sfWidgetFormFilterInput(),
      'address_line1'         => new sfWidgetFormFilterInput(),
      'address_line2'         => new sfWidgetFormFilterInput(),
      'city'                  => new sfWidgetFormFilterInput(),
      'state'                 => new sfWidgetFormFilterInput(),
      'zip'                   => new sfWidgetFormFilterInput(),
      'country'               => new sfWidgetFormFilterInput(),
      'work_phone'            => new sfWidgetFormFilterInput(),
      'contact_name'          => new sfWidgetFormFilterInput(),
      'using_version'         => new sfWidgetFormFilterInput(),
      'client_using_features' => new sfWidgetFormFilterInput(),
      'status'                => new sfWidgetFormFilterInput(),
      'subscriber_id'         => new sfWidgetFormFilterInput(),
      'subscription_plan_id'  => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'sf_guard_user_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'client_email'          => new sfValidatorPass(array('required' => false)),
      'name'                  => new sfValidatorPass(array('required' => false)),
      'address_line1'         => new sfValidatorPass(array('required' => false)),
      'address_line2'         => new sfValidatorPass(array('required' => false)),
      'city'                  => new sfValidatorPass(array('required' => false)),
      'state'                 => new sfValidatorPass(array('required' => false)),
      'zip'                   => new sfValidatorPass(array('required' => false)),
      'country'               => new sfValidatorPass(array('required' => false)),
      'work_phone'            => new sfValidatorPass(array('required' => false)),
      'contact_name'          => new sfValidatorPass(array('required' => false)),
      'using_version'         => new sfValidatorPass(array('required' => false)),
      'client_using_features' => new sfValidatorPass(array('required' => false)),
      'status'                => new sfValidatorPass(array('required' => false)),
      'subscriber_id'         => new sfValidatorPass(array('required' => false)),
      'subscription_plan_id'  => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('client_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Client';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'sf_guard_user_id'      => 'ForeignKey',
      'client_email'          => 'Text',
      'name'                  => 'Text',
      'address_line1'         => 'Text',
      'address_line2'         => 'Text',
      'city'                  => 'Text',
      'state'                 => 'Text',
      'zip'                   => 'Text',
      'country'               => 'Text',
      'work_phone'            => 'Text',
      'contact_name'          => 'Text',
      'using_version'         => 'Text',
      'client_using_features' => 'Text',
      'status'                => 'Text',
      'subscriber_id'         => 'Text',
      'subscription_plan_id'  => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
